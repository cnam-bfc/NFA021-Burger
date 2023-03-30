<?php
class EditRecetteController extends Controller
{
    public function renderViewAjouterRecette()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'EditRecetteView');

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

        $view = new View(BaseTemplate::EMPLOYE, 'EditRecetteView');

        // Définition des variables utilisées dans la vue
        $view->titre = "Modification d'une recette";

        $view->renderView();
    }

    public function renderViewSupprimerRecette()
    {
        /* TODO à faire
        $view = new View(BaseTemplate::EMPLOYE, 'EditRecetteView');

        // Définition des variables utilisées dans la vue

        $view->renderView();*/
    }
}
