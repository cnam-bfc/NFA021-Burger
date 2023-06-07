<?php

class StatistiquesController extends Controller
{
    public function renderViewStatistiques()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'StatistiquesView');

        $view->renderView();
    }

    public function getAllBurgers()
    {
        // On récupère les informations des burgers
        $rawData = Form::getParam('dataReceived', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);
        $archives = $data["archives"];

        // On récupère toutes les recettes
        $recetteDAO = new RecetteDAO();
        $recettes = $recetteDAO->selectAllForSelectStats($archives, 1);

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
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    public function getDataBurgerVenteTotal()
    {
        $rawData = Form::getParam('dataReceived', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);
        $dateDebut = null;
        $dateFin = null;
        $recettes = null;

        if ($data["recette_all"] == false) {
            $recettes = $data["recettes"];
        }

        if ($data["date_all"] == false) {
            $dateDebut = $data["date_debut"];
            $dateFin = $data["date_fin"];
        }

        // On récupère toutes les recettes
        $statsVenteBurgerDAO = new StatsVenteBurgerDAO();
        $statsVenteBurgers = $statsVenteBurgerDAO->selectForStatisticsTotal($recettes, $dateDebut, $dateFin);

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu les recettes
        if (!empty($statsVenteBurgers)) {
            foreach ($statsVenteBurgers as $statsVenteBurger) {
                $result[] = array(
                    "id" => $statsVenteBurger->getId(),
                    "nom" => $statsVenteBurger->getNom(),
                    "quantite" => $statsVenteBurger->getQuantite(),
                    "dateDebut" => $statsVenteBurger->getDateDebut(),
                    "dateFin" => $statsVenteBurger->getDateFin()
                );
            }
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);
        $view->json = $result;
        $view->renderView();
    }
}
