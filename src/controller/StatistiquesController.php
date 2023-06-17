<?php

class StatistiquesController extends Controller
{
    const DEFAULT_INTERVALLE_DAY = 12;
    const DEFAULT_INTERVALLE_MONTH = 12;
    const DEFAULT_INTERVALLE_YEAR = 12;

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

    public function getAllFournisseurs()
    {
        // On récupère les informations des burgers
        $rawData = Form::getParam('dataReceived', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);
        $archives = $data["archives"];

        // On récupère toutes les recettes
        $fournisseurDAO = new FournisseurDAO();
        $fournisseurs = $fournisseurDAO->selectAllForSelectStats($archives, 1);

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu les recettes
        if (!empty($fournisseurs)) {
            foreach ($fournisseurs as $fournisseur) {
                $result[] = array(
                    "id" => $fournisseur->getId(),
                    "nom" => $fournisseur->getNom()
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
        $archive = 0;

        if ($data["recette_all"] == false) {
            $recettes = $data["recettes"];
        }

        if ($data["date_all"] == false) {
            $dateDebut = $data["date_debut"];
            $dateFin = $data["date_fin"];
        }

        $archive = $data["archives"];

        // On récupère toutes les recettes
        $statsVenteBurgerDAO = new StatsVenteBurgerDAO();
        $statsVenteBurgers = $statsVenteBurgerDAO->selectForStatisticsTotal($recettes, $dateDebut, $dateFin, $archive);

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

    public function getDataBurgerVenteTemps()
    {
        $rawData = Form::getParam('dataReceived', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);
        $view = new View(BaseTemplate::JSON);

        $dateDebut = null;
        $dateFin = null;
        $recettes = $data["recettes"];;
        $archive = 0;
        $intervalle = 1;

        if (!empty($data["intervalle"])) {
            $intervalle = $data["intervalle"];
        }

        if (!empty($data['archives'])) {
            $archive = $data["archives"];
        }

        if ($data["date_all"] == false) {
            $dateDebut = $data["date_debut"];
            $dateFin = $data["date_fin"];
        }

        if ($dateDebut == null && $dateFin == null) {
            $dateDebut = self::dateGenerator(false, $intervalle);
            $dateFin = new DateTime();
            $dateFin = $dateFin->format("Y-m-d");
        } else {
            if ($dateDebut == null) {
                $dateDebut = self::dateGenerator(false, $intervalle);
            }

            if ($dateFin == null) {
                $dateFin = self::dateGenerator(true, $intervalle);
            }
        }

        // On récupère les recettes
        $statsVenteBurgerIntervalleDAO = new StatsVenteBurgerIntervalleDAO();
        $statsVenteBurgersIntervalles = $statsVenteBurgerIntervalleDAO->selectForStatisticsTemps($recettes, $intervalle, $dateDebut, $dateFin, $archive);

        // on vérifie qu'on a pas reçu null
        if ($statsVenteBurgersIntervalles == null) {
            // envoi des données à la vue
            $view->json = null;
            $view->renderView();
        }

        // on récupère les données pour la vue
        $result = array(
            "info" => array(),
            "data" => array()
        );

        // Faire une requête pour remplir info, info = nom des recettes + id
        $recetteDAO = new RecetteDAO();
        foreach ($recettes as $recette) {
            $recette = $recetteDAO->selectById($recette, $archive);
            $result["info"][$recette->getId()] = array(
                "id" => $recette->getId(),
                "nom" => $recette->getNom()
            );
        }


        // Info -> (id -> nom)
        // Data -> date -> id recette -> quantite

        // Il faut générer le tableau de données proprement en fonction de l'intervalle
        switch ($intervalle) {
            case 0:
                // On initialise un tableau dans $result["data"] pour chaque jour yyyy-mm-dd en fonction de la date début et fin
                $dateDebut = new DateTime($dateDebut);
                $dateFin = new DateTime($dateFin);
                $dateFin->modify('+1 day');
                $interval = new DateInterval('P1D');
                $dateRange = new DatePeriod($dateDebut, $interval, $dateFin);
                foreach ($dateRange as $date) {
                    $result["data"][$date->format("Y-m-d")] = null;
                }
                break;
            case 1:
                // On initialise un tableau dans $result["data"] pour chaque semaine yyyy-mm en fonction de la date début et fin
                $dateDebut = new DateTime($dateDebut);
                $dateFin = new DateTime($dateFin);
                $dateFin->modify('+1 week');
                $interval = new DateInterval('P1M');
                $dateRange = new DatePeriod($dateDebut, $interval, $dateFin);
                foreach ($dateRange as $date) {
                    $result["data"][$date->format("Y-m")] = null;
                }
                break;
            case 2:
                // On initialise un tableau dans $result["data"] pour chaque mois yyyy en fonction de la date début et fin
                $dateDebut = new DateTime($dateDebut);
                $dateFin = new DateTime($dateFin);
                $dateFin->modify('+1 year');
                $interval = new DateInterval('P1Y');
                $dateRange = new DatePeriod($dateDebut, $interval, $dateFin);
                foreach ($dateRange as $date) {
                    $result["data"][$date->format("Y")] = null;
                }
                break;
        }

        // On parcours les résultats
        foreach ($statsVenteBurgersIntervalles as $statsVenteBurgerIntervalle) {
            $result["data"][$statsVenteBurgerIntervalle->getDate()][$statsVenteBurgerIntervalle->getId()] = $statsVenteBurgerIntervalle->getQuantite();
        }

        // envoi des données à la vue
        $view->json = $result;
        $view->renderView();
    }

    /**
     * Méthode permettant de retournée une date dans le futur ou le passé en fonction des constantes de classe et l'intervalle choisi
     *
     * @param [type] $futur true si on veut une date dans le futur, false si on veut une date dans le passé
     * @param [type] $intervalle 0 pour jour, 1 pour mois, 2 pour année
     * @return string date
     */
    private function dateGenerator($futur, $intervalle)
    {
        $today = new DateTime();  // Date actuelle
        $interval = null;
        switch ($intervalle) {
            case 0: // jour
                $interval = new DateInterval('P' . self::DEFAULT_INTERVALLE_DAY . 'D');  // Période de 12 jours
                break;
            case 1: // mois 
                $interval = new DateInterval('P' . self::DEFAULT_INTERVALLE_MONTH . 'M');  // Période de 12 mois
                break;
            case 2: // année
                $interval = new DateInterval('P' . self::DEFAULT_INTERVALLE_YEAR . 'Y');  // Période de 12 ans
                break;
            default:
                // exception
                throw new Exception("Intervalle non géré");
                break;
        }
        if (!$futur) {
            $interval->invert = 1;  // Inverser l'intervalle pour obtenir une date dans le passé
        }
        $today->add($interval);
        return $today->format('Y-m-d');
    }
}
