<?php

class CarteMenuController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::CLIENT, 'CarteMenuView');
        $view->renderView();
    }
}