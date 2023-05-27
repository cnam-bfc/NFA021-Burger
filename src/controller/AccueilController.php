<?php

class AccueilController extends Controller
{
    public function renderView()
    {
        // il faudra vérifier ici si on est en mode client ou en mode gérant
        $this->renderViewAccueilClient();
    }

    /***************************
     ***** ACCUEIL CLIENT *****
     **************************/

    public function renderViewAccueilClient()
    {
        $view = new View(BaseTemplate::CLIENT, 'AccueilClientView');

        // Définition des variables utilisées dans la vue
        $view->backgroundImage = IMG . "accueil_background.webp";

        // image de l'emplacement du restaurant
        $view->carte = IMG . "carte_with_ping_name.png";

        // voir si on fait défiler différentes news (mettre des news en bdd ou dans un fichier json ??)
        $view->news = array(
            "title" => "Notre histoire",
            "message" => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
        );

        $view->renderView();
    }

    public function refreshTopRecetteAJAX()
    {
        $recetteDAO = new RecetteDAO();
        $topRecettes = $recetteDAO->selectTop3Recette();
        if ($topRecettes !== null) {
            $result = array();
            foreach ($topRecettes as $recette) {
                $result[] = array(
                    "nom" => $recette->getNom(),
                    "image" => IMG
                );
            }
        } else {
            $result = array();
            $result[] = array(
                "nom" => "cheddar lover",
                "image" => IMG . "recette/burger/presentation.webp"
            );
            $result[] = array(
                "nom" => "steakhouse",
                "image" => IMG . "recette/burger/steakhouse.webp"
            );
            $result[] = array(
                "nom" => "triple cheese",
                "image" => IMG . "recette/burger/triple_cheese.webp"
            );
        }
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    /***************************
     ***** ACCUEIL EMPLOYE *****
     **************************/

    public function renderViewAccueilEmploye()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'AccueilEmployeView');

        // Définition des variables utilisées dans la vue
        $view->icones = array(
            ["nom" => "statistiques", "img" => IMG . "icone/accueil_employe/statistiques.png"],
            ["nom" => "stocks", "img" => IMG . "icone/accueil_employe/stocks.png"],
            ["nom" => "recettes", "img" => IMG . "icone/accueil_employe/recettes.png"],
            ["nom" => "produits", "img" => IMG . "icone/accueil_employe/produits.png"],
            ["nom" => "inventaire", "img" => IMG . "icone/accueil_employe/inventaire.png"],
            ["nom" => "historique", "img" => IMG . "icone/accueil_employe/historique.png"],
            ["nom" => "bons_commandes", "img" => IMG . "icone/accueil_employe/bons_commandes.png"],
            ["nom" => "prep_commandes", "img" => IMG . "icone/accueil_employe/prep_commandes.png"],
            ["nom" => "livraison", "img" => IMG . "icone/accueil_employe/livraison.png"],
            ["nom" => "trajet", "img" => IMG . "icone/accueil_employe/trajet.png"],

        );

        $view->renderView();
    }

    public function afficherEspaceAccueilEmploye() {
        // Récupération la "session" de l'utilisateur
        $userSession = UserSession::getUserSession();

        $json = array();
        $json['data'] = array();
        // Vérification que l'utilisateur est connecté
        if ($userSession->isLogged()) {
            // CAS SPÉCIFIQUES POUR CHAQUE RÔLE
            // Si l'utilisateur est un cuisinier
            if ($userSession->isCuisinier()) {
                $json['data'] = array(
                    'id' => 0,
                );
            }
            // Si l'utilisateur est un livreur
            elseif ($userSession->isLivreur()) {
                $json['data'] = array(
                    'id' => 1,
                );
            }
            // Si l'utilisateur est un gérant
            elseif ($userSession->isGerant()) {
                $json['data'] = array(
                    'id' => 2,
                );
            }

            $view = new View(BaseTemplate::JSON);
            $view->json = $json;

            $view->renderView();
        }
    }
}
