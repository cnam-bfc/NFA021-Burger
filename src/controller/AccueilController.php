<?php

class AccueilController
{
    public function renderView()
    {
        // il faudra vérifier ici si on est en mode client ou en mode gérant
        $this->renderViewAccueilClient();
    }

    public function renderViewAccueilClient ()
    {
        $backgroundImage = IMG . "accueil_background.webp";
        // ici il faudra appeler le modèle pour récupérer le top 3 des recettes du moment mais c'est une démonstration
        $topRecette = array (
            ["nom" => "cheddar lover", "img" => IMG . "recette/burger/cheddar_lover.webp"],
            ["nom" => "steakhouse", "img" => IMG . "recette/burger/steakhouse.webp"],
            ["nom" => "triple cheese", "img" => IMG . "recette/burger/triple_cheese.webp"]
        );

        $data = array(
            "backgroundImage" => $backgroundImage,
            "topRecette" => $topRecette
        );
        
        $view = new View('AccueilClientView');
        $view->renderView($data);
    }

    public function renderViewAccueilEmploye() {

    }
}