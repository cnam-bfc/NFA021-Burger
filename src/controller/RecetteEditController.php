<?php
class RecetteEditController extends Controller
{
    public function renderViewAjouterRecette()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'RecetteEditView');

        // Définition des variables utilisées dans la vue
        $view->titre = "Ajout d'une recette";

        $view->renderView();
    }

    public function renderViewModifierRecette()
    {
        // Vérification de l'existence de la recette
        if (!isset($_GET['id'])) {
            // Afficher une erreur
            ErrorController::error(404, "Recette introuvable");
            return;
        }

        $view = new View(BaseTemplate::EMPLOYE, 'RecetteEditView');

        // Définition des variables utilisées dans la vue
        $view->titre = "Modification d'une recette";

        $view->recetteId = $_GET['id'];
        $view->recetteNom = "Cheddar Lover";
        $view->recetteDescription = "Burger au cheddar, bacon, oignons rouges, tomates, salade, sauce cheddar et sauce BBQ";
        $view->recettePrix = 10.99;
        $view->recetteImage = IMG . "recette/burger/cheddar_lover.webp";

        $view->renderView();
    }

    public function renderViewSupprimerRecette()
    {
        /* TODO à faire
        $view = new View(BaseTemplate::EMPLOYE, 'RecetteEditView');

        // Définition des variables utilisées dans la vue

        $view->renderView();*/
    }
}
