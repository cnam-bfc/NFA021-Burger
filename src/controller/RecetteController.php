<?php
class RecetteController extends Controller
{
    public function renderViewRecettes()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'RecetteView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }
}