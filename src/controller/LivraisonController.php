<?php

class LivraisonController extends Controller
{
    public function renderViewLivraison()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'LivraisonView');

        $view->renderView();
    }

    public function renderViewItineraire()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ItineraireView');

        $view->renderView();
    }

    public function listeLivraisons()
    {
        // Création des objets DAO
        $commandeClientLivraisonDAO = new CommandeClientLivraisonDAO();
        $livreurDAO = new LivreurDAO();
        $moyensTransportDAO = new MoyenTransportDAO();
        $clientDAO = new ClientDAO();

        $json = array(
            'data' => array(
                'livreur' => false,
                'osrm_profile' => '',
                'commandes' => array()
            )
        );

        // Récupération de l'utilisateur connecté
        $userSession = UserSession::getUserSession();
        if ($userSession->isLogged() && $userSession->isLivreur()) {
            $json['data']['livreur'] = true;

            // Récupération du livreur
            $livreur = $livreurDAO->selectById($userSession->getCompte()->getId());

            if ($livreur !== null) {
                // Récupération du moyen de transport du livreur
                $moyenTransport = $moyensTransportDAO->selectById($livreur->getIdMoyenTransport());

                if ($moyenTransport !== null) {
                    $json['data']['osrm_profile'] = $moyenTransport->getOsrmProfile();
                }
            }
        }

        // Récupération des commandes
        $commandes = $commandeClientLivraisonDAO->selectAllNonArchive();

        // Formatage des commandes en json
        foreach ($commandes as $commande) {
            // Formatage de la commande en json
            $jsonCommande = array(
                'id' => $commande->getId(),
                'adresse_depart' => array(
                    'osm_type' => 'W',
                    'osm_id' => 219487836,
                    'numero' => 11,
                    'rue' => 'Rue Georges Maugey',
                    'ville' => 'Chalon-sur-Saône',
                    'code_postal' => '71100'
                ),
                'adresse_arrivee' => array(
                    'osm_type' => $commande->getAdresseOsmType(),
                    'osm_id' => $commande->getAdresseOsmId(),
                    'numero' => $commande->getAdresseNumero(),
                    'rue' => $commande->getAdresseRue(),
                    'ville' => $commande->getAdresseVille(),
                    'code_postal' => $commande->getAdresseCodePostal()
                ),
                'heure_livraison' => $commande->getHeureLivraison()
            );

            // Récupération du client
            $client = $clientDAO->selectById($commande->getIdClient());

            if ($client !== null) {
                // Formatage du client en json
                $jsonCommande['client'] = array(
                    'id' => $commande->getIdClient(),
                    'nom' => $client->getNom(),
                    'prenom' => $client->getPrenom()
                );
            }

            if (!empty($commande->getIdLivreur())) {
                // Récupération du livreur
                $livreur = $livreurDAO->selectById($commande->getIdLivreur());

                if ($livreur !== null) {
                    // Formatage du livreur en json
                    $jsonCommande['livreur'] = array(
                        'id' => $commande->getIdLivreur(),
                        'nom' => $livreur->getNom(),
                        'prenom' => $livreur->getPrenom()
                    );
                }
            }

            // Différents status de la commande possibles
            // ETATS TERMINE
            // Archive : date_archive non null & id_livreur null
            // Livré : date_archive non null & id_livreur non null

            // ETATS EN COURS
            // En livraison : date_recuperation non null & id_livreur non null
            // Attente livreur : date_pret non null
            // En cuisine : date_commande non null & date_pret null

            // Formatage du status en json
            if (!empty($commande->getDateArchive()) && empty($commande->getIdLivreur())) {
                $jsonCommande['status'] = 'archive';
            } else if (!empty($commande->getDateArchive()) && !empty($commande->getIdLivreur())) {
                $jsonCommande['status'] = 'livre';
            } else if (!empty($commande->getHeureRecuperation()) && !empty($commande->getIdLivreur())) {
                $jsonCommande['status'] = 'en_livraison';
            } else if (!empty($commande->getDatePret())) {
                $jsonCommande['status'] = 'attente_livreur';
            } else if (!empty($commande->getDateCommande()) && empty($commande->getDatePret())) {
                $jsonCommande['status'] = 'en_cuisine';
            } else {
                $jsonCommande['status'] = 'en_attente';
            }

            // Tri des commandes par heure de livraison
            usort($json['data']['commandes'], function ($a, $b) {
                return $a['heure_livraison'] <=> $b['heure_livraison'];
            });

            $json['data']['commandes'][] = $jsonCommande;
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }

    public function prendreLivraison()
    {
        $json = array(
            'success' => false,
            'message' => ''
        );

        // Récupération de l'utilisateur connecté
        $userSession = UserSession::getUserSession();
        if (!$userSession->isLogged()) {
            ErrorController::error(401, 'Vous devez être connecté pour accéder à cette page');
        }

        if (!$userSession->isLivreur()) {
            ErrorController::error(403, 'Vous n\'êtes pas livreur !');
        }

        // Récupération des données
        $idCommande = Form::getParam('id', Form::METHOD_POST, Form::TYPE_INT, true);

        // Création des objets DAO
        $commandeClientLivraisonDAO = new CommandeClientLivraisonDAO();
        $livreurDAO = new LivreurDAO();

        // Récupération de la commande
        $commande = $commandeClientLivraisonDAO->selectById($idCommande);

        if ($commande === null) {
            ErrorController::error(404, 'La commande n\'existe pas');
        }

        // Récupération du livreur
        $livreur = $livreurDAO->selectById($userSession->getCompte()->getId());

        if ($livreur === null) {
            ErrorController::error(404, 'Le livreur n\'existe pas');
        }

        // Vérification que la commande n'est pas déjà prise
        if ($commande->getIdLivreur() !== null) {
            $json['message'] = 'La commande a déjà été prise';
        } else {
            // Prise de la commande
            $commande->setIdLivreur($livreur->getId());

            $commandeClientLivraisonDAO->update($commande);

            $json['success'] = true;
        }

        $view = new View(BaseTemplate::JSON);
        $view->json = $json;
        $view->renderView();
    }

    public function listeMoyensTransport()
    {
        // Création des objets DAO
        $moyensTransportDAO = new MoyenTransportDAO();
        $livreurDAO = new LivreurDAO();

        $json = array(
            'data' => array(
                'moyens_transport' => array()
            )
        );

        // Récupération de la liste des moyens de transport
        $moyensTransport = $moyensTransportDAO->selectAll();

        // Formatage des moyens de transport en json
        foreach ($moyensTransport as $moyenTransport) {
            $json['data']['moyens_transport'][] = array(
                'id' => $moyenTransport->getId(),
                'nom' => $moyenTransport->getNom(),
                'osrm_profile' => $moyenTransport->getOsrmProfile()
            );
        }

        // Récupération de l'utilisateur connecté
        $userSession = UserSession::getUserSession();
        if ($userSession->isLogged() && $userSession->isLivreur()) {
            // Récupération du livreur
            $livreur = $livreurDAO->selectById($userSession->getCompte()->getId());

            if ($livreur !== null) {
                // Récupération du profil actuel du livreur
                $json['data']['profil_actuel'] = $livreur->getIdMoyenTransport();
            }
        }

        $view = new View(BaseTemplate::JSON);
        $view->json = $json;
        $view->renderView();
    }

    public function afficherItineraire()
    {
    }
}
