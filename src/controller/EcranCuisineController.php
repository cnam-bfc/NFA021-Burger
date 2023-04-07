<?php
class EcranCuisineController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPTY, 'EcranCuisineView');
        $view->renderView();
    }
}
