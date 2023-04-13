<?php

class AccueilController extends Controller
{
    public function renderView()
    {
        // il faudra vérifier ici si on est en mode client ou en mode gérant
        $this->renderViewAccueilClient();
    }

    public function renderViewAccueilClient()
    {
        $view = new View(BaseTemplate::CLIENT, 'AccueilClientView');

        // Définition des variables utilisées dans la vue
        $view->backgroundImage = IMG . "accueil_background.webp";

        $view->carte = IMG . "carte_with_ping_name.png";

        // DEBUT - A DEPLACER DANS AJAX
        // ici il faudra appeler le modèle pour récupérer le top 3 des recettes du moment mais c'est une démonstration
        $recetteDAO = new RecetteDAO();
        $topRecettes = $recetteDAO->selectTop3Recette();
        if ($topRecettes !== null) {
            $topRecette = array();
            foreach ($topRecettes as $recette) {
                $topRecette[] = array(
                    "nom" => $recette->getNom(),
                    "img" => IMG . $recette->getPhotoRecette()
                );
            }
            $view->topRecette = $topRecette;
        } else {
            $view->topRecette = array(
                ["nom" => "cheddar lover", "img" => IMG . "recette/burger/cheddar_lover.webp"],
                ["nom" => "steakhouse", "img" => IMG . "recette/burger/steakhouse.webp"],
                ["nom" => "triple cheese", "img" => IMG . "recette/burger/triple_cheese.webp"]
            );
        }
        // FIN - A DEPLACER DANS AJAX

        // voir si on fait défiler différentes news 
        $view->news = array(
            "title" => "Notre histoire",
            "message" => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
        );

        $view->renderView();
    }

    public function renderViewAccueilEmploye()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'AccueilEmployeView');

        // Définition des variables utilisées dans la vue
        $view->backgroundImage = IMG . "accueilemploye_background.webp";

        $view->renderView();
    }
}
