<?php

class CarteMenuController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::CLIENT, 'CarteMenuView');

        $view->renderView();
    }

    public function listeBurgers()
    {

        // Création des objets DAO
        $recetteDAO = new RecetteDAO();

        $json = array();
        $json['data'] = array();

        $recettes = $recetteDAO->selectAllNonArchive();

        //Formatage des recettes en json
        foreach ($recettes as $recette) {

            $jsonRecette = array(
                'id' => $recette->getIdRecette(),
                'nom' => $recette->getNomRecette(),
                'description' => $recette->getDescriptionRecette(),
                'image' => IMG . $recette->getPhotoRecette(),
                'prix' => $recette->getPrixRecette(),
            );
            $json['data'][] = $jsonRecette;

        }

        $view = new View(BaseTemplate::JSON);
        $view->json = $json;

        $view->renderView();


    }
}

