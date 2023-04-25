<?php

class CollectLivraisonController extends Controller
{
    public function renderViewCollectORDelivery()
    {
        $view = new View(BaseTemplate::CLIENT, 'CollectORDeliveryView');
        

        $view->renderView();
    }
}
