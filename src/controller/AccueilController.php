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

        // voir si on fait défiler différentes news 
        $news = array (
            "title" => "Notre histoire",
            "message" => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
        );

        $data = array(
            "backgroundImage" => $backgroundImage,
            "topRecette" => $topRecette,
            "news" => $news
        );
        
        $view = new View('AccueilClientView');
        $view->renderView($data);
    }

    public function renderViewAccueilEmploye() {

    }
}