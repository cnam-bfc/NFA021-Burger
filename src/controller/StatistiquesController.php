<?php

class StatistiquesController extends Controller
{
    public function renderViewStatistiques()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'StatistiquesView');

        $view->renderView();
    }

}
