<?php
class InventaireController extends Controller
{
    public function renderViewInventaire()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'InventaireView');
        $view->renderView();
    }
}
