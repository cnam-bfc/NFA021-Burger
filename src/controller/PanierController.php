<?php

class PanierController extends Controller
{
    public function renderViewPanier()
    {
        $view = new View(BaseTemplate::CLIENT, 'PanierView');


        $view->renderView();
    }

    public function getSessionPanier()
    {

        $infosJSON = $_SESSION['panier'];

        $view = new View(BaseTemplate::JSON, null);
        $view->json = $infosJSON;
        $view->renderView();
    }
    function suppElemPanier()
    {
        $idElem = $_POST['idElem'];
        array_splice($_SESSION['panier'], $idElem, 1);
        $infosJSON = $_SESSION['panier'];

        $view = new View(BaseTemplate::JSON, null);
        $view->json = $infosJSON;
        $view->renderView();
    }
}
