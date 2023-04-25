<?php

class RecetteCuisineController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPTY, 'RecetteCuisineView');

        $view->recette = array(
            ["nom" => "burger", "img" => IMG . "recette/burger/burger.jpg"],
        );

        $view->renderView();
    }
}