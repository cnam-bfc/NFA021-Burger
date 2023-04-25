<?php

class ModifsBurgersController extends Controller
{
    public function renderViewPimpBurgers()
    {
        $view = new View(BaseTemplate::CLIENT, 'PimpBurgersView');
        

        $view->renderView();
    }
    public function getIngredients()
    {
        $identifiant = $_POST['id'];
        $view = new View(BaseTemplate::JSON, null);
        
        $view->json=array(
            'ingredient' => array()

        );

        $view->renderView();
    }

}
