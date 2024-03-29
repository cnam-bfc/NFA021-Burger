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
        $view->backgroundImage = IMG . "accueil_background.png";

        // image de l'emplacement du restaurant
        $view->carte = IMG . "carte_with_ping_name.png";

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
                    "id" => $recette->getId(),
                    "nom" => $recette->getNom(),
                    "image" => IMG . 'recettes' . DIRECTORY_SEPARATOR . $recette->getId() . DIRECTORY_SEPARATOR . 'presentation.img',
                );
            }
        } else {
            $result = null;
        }
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    public function refreshTextAccueil() {

        $accueilTextDAO = new AccueilTextDAO();
        $accueilText = $accueilTextDAO->selectRandomText();
        if ($accueilText !== null) {
            $result = array(
                "title" => $accueilText->getTitle(),
                "text" => $accueilText->getText()
            );
        } else {
            $result = array(
                "title" => "Bienvenue chez Burger Code !" ,
                "text" => "Venez comme vous êtes dans notre restaurant. Nous vous accueillons tous les jours de la semaine, de 11h à 23h."
            );
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    /***************************
     ***** ACCUEIL EMPLOYE *****
     *************************
     * @return void
     */

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

        if (UserSession::getUserSession()->isGerant()) {
            $view->typeCompte = "gerant";
        }
        elseif (UserSession::getUserSession()->isCuisinier()) {
            $view->typeCompte = "cuisinier";
        }
        elseif (UserSession::getUserSession()->isLivreur()) {
            $view->typeCompte = "livreur";
        }
        else {
            $view->typeCompte = "employe";
        }

        $view->renderView();
    }

}
