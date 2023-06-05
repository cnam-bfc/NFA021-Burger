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

        $json = array();
        $json['data'] = array();

        // Récupération des commandes
        $commandes = $commandeClientLivraisonDAO->selectAllNonArchive();

        // Formatage des commandes en json
        foreach ($commandes as $commande) {
            // Formatage de la commande en json
            $jsonCommande = array(
                'id' => $commande->getId(),
                'adresse_depart' => array(
                    'osm_type' => 'way',
                    'osm_id' => 123456789,
                    'numero' => 11,
                    'rue' => 'rue Georges Maugey',
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
                'distance' => '1,2',
                'heure_livraison' => $commande->getHeureLivraison()
            );

            if (!empty($commande->getIdLivreur())) {
                // Récupération du livreur
                $livreurDAO = new LivreurDAO();
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

            // Tri des commandes par heure de livraison
            usort($json['data'], function ($a, $b) {
                return $a['heure_livraison'] <=> $b['heure_livraison'];
            });

            $json['data'][] = $jsonCommande;
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
}
