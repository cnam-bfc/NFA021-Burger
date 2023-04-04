<?php
class NouveauBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'NouveauBDCView');
        $view->renderView();
    }
}
