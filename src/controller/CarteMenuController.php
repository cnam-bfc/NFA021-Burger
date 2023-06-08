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
                'id' => $recette->getId(),
                'nom' => $recette->getNom(),
                'description' => $recette->getDescription(),
                'image' => IMG . 'recettes' . DIRECTORY_SEPARATOR . $recette->getId() . DIRECTORY_SEPARATOR .'presentation.img',
                'prix' => $recette->getPrix(),
            );
            $json['data'][] = $jsonRecette;

        }

        $view = new View(BaseTemplate::JSON);
        $view->json = $json;

        $view->renderView();


    }

    public function ajoutPanier() {


    }
}

