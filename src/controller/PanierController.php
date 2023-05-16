<?php

class PanierController extends Controller
{
    public function renderViewPanier()
    {
        $view = new View(BaseTemplate::CLIENT, 'PanierView');


        $view->renderView();
    }

   
}

