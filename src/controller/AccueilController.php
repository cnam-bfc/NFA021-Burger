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
                    "image" => IMG . $recette->getPhotoRecette()
                );
            }
        } else {
            $result = array();
            $result[] = array(
                "nom" => "cheddar lover",
                "image" => IMG . "recette/burger/cheddar_lover.webp"
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
        $view->backgroundImage = IMG . "accueilemploye_background.webp";

        $view->renderView();
    }
}
