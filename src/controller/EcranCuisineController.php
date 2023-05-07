<?php
class EcranCuisineController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::CUISINIER, 'EcranCuisineView');
        $view->renderView();
    }
}
