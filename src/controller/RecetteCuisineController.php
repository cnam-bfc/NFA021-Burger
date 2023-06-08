<?php

class RecetteCuisineController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPTY, 'RecetteCuisineView');

        $view->renderView();
    }

    public function listeRecetteCmd()
    {
        // Récupération de l'id de la recette à afficher vue éclatée
        $recetteId = Form::getParam('id', Form::METHOD_GET, Form::TYPE_INT);

        // Création des objets DAO



        // Création du json
        $json = array();
        $json['data'] = array();
        // Récupération de la recette



        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }
}