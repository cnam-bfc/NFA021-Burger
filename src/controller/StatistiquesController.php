<?php

class StatistiquesController extends Controller
{
    public function renderViewStatistiques()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'StatistiquesView');

        $view->renderView();
    }

    public function recupererLesRecettes()
    {
        // On récupère toutes les recettes
        $recetteDAO = new RecetteDAO();
        $recettes = $recetteDAO->selectAll();

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu les recettes
        if (!empty($recettes)) {
            foreach ($recettes as $recette) {
                $result[] = array(
                    "id" => $recette->getId(),
                    "nom" => $recette->getNom()
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            usort($result, function ($a, $b) {
                return $a['nom'] <=> $b['nom'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    public function recupererRecettesPourStatistiques() {
        $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);
        $dateDebut = null;
        $dateFin = null;
        $recettes = null;

        if ($data["recettes_all"] == false) {
            $recettes = $data["recettes"];
        }

        if ($data["date_all"] == true) {
            $dateDebut = $data["date_debut"];
            $dateFin = $data["date_fin"];
        }

         // On récupère toutes les recettes
         $recetteDAO = new RecetteDAO();
         $recettes = $recetteDAO->selectAllForStats($dateDebut, $dateFin, $recettes);
 
         // on récupère les données pour la vue
         $result = array();
 
         // On vérifie qu'on a bien reçu les recettes
         if (!empty($recettes)) {
             foreach ($recettes as $recette) {
                 $result[] = array(
                     "id" => $recette->getId(),
                     "nom" => $recette->getNom()
                 );
             }
 
             // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
             usort($result, function ($a, $b) {
                 return $a['nom'] <=> $b['nom'];
             });
         }
 
         // envoi des données à la vue
         $view = new View(BaseTemplate::JSON);
 
         $view->json = $result;
 
         $view->renderView();
    }

}
