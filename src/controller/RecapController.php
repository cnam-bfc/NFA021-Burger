<?php

class RecapController extends Controller
{
    public function renderViewRecap()
    {
        $view = new View(BaseTemplate::CLIENT, 'RecapView');


        $view->renderView();
    }
    public function getRecapInfos()
    {

        $infosJSON = $_SESSION['infosRecupCommande'];

        $view = new View(BaseTemplate::JSON, null);
        $view->json = $infosJSON;
        $view->renderView();
    }

    
    
}
