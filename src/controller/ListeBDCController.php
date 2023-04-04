<?php
class ListeBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeBDCView');
        $view->renderView();
    }
}
