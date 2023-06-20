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
        //créer la varible de session Panier si elle n'existe pas déjà

        if (!isset($_SESSION['panier'])) {

            $_SESSION['panier'] = array();
        }

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

    function setPanier(){
        $_SESSION['panier'] = $_POST['panierFinal'];
    }
}
