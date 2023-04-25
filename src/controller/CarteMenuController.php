<?php

class CarteMenuController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::CLIENT, 'CarteMenuView');

        $view->image_burger = array(
            ["nom" => "cheddar lover", "img" => IMG . "recette/burger/cheddar_lover.webp"],
            ["nom" => "steakhouse", "img" => IMG . "recette/burger/steakhouse.webp"],
            ["nom" => "triple cheese", "img" => IMG . "recette/burger/triple_cheese"],
            );

        $view->renderView();
    }
}