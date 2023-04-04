<?php
class NouveauProduitController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'NouveauProduitView');
        $view->renderView();
    }
}
