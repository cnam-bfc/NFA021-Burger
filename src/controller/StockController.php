<?php
class StockController extends Controller
{
    public function renderViewStock()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'StockView');
        $view->renderView();
    }
}
