<?php

class ModifsBurgersController extends Controller
{
    public function renderViewPimpBurgers()
    {
        $view = new View(BaseTemplate::CLIENT, 'PimpBurgersView');
        

        $view->renderView();
    }
}
