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
        // ici il faudra appeler le modèle pour récupérer le top 3 des recettes du moment mais c'est une démonstration
        $view->topRecette = array(
            ["nom" => "cheddar lover", "img" => IMG . "recette/burger/cheddar_lover.webp"],
            ["nom" => "steakhouse", "img" => IMG . "recette/burger/steakhouse.webp"],
            ["nom" => "triple cheese", "img" => IMG . "recette/burger/triple_cheese.webp"]
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
