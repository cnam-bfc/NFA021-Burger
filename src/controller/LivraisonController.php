<?php

class LivraisonController extends Controller
{
    public function renderViewLivraison()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'LivraisonView');

        $view->renderView();
    }

    public function renderViewItineraire()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ItineraireView');

        $view->renderView();
    }
}
