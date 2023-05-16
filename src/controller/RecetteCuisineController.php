<?php

class RecetteCuisineController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPTY, 'RecetteCuisineView');

        $view->recette = array(
            ["nom" => "burger", "img" => IMG . "recette/burger/burger.jpg"],
        );

        $view->renderView();
    }

    public function listeRecetteCmd()
    {
        // Récupération de l'id de la recette à afficher vue éclatée
        $recetteId = Form::getParam('id', Form::METHOD_GET, Form::TYPE_INT);

        // Création des objets DAO

        $recetteFinaleDAO = new RecetteFinaleDAO();
        $recetteFinaleIngredientDAO = new RecetteFinaleIngredientDAO();

        $json = array();
        $json['data'] = array();

        $recettes = $recetteFinaleDAO->selectById($recetteId);


        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }
}