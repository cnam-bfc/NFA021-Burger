<?php
class ListeProduitsController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeProduitsView');

        $view->icone = array(
            ["nom" => "modifier", "img" => IMG . "icone/modifier.png"],
            ["nom" => "pain", "img" => IMG . "icone/pain.png"],
            ["nom" => "steak", "img" => IMG . "icone/steak.png"],
            ["nom" => "tomate", "img" => IMG . "icone/tomate.png"],
            ["nom" => "salade", "img" => IMG . "icone/salade.png"],
            ["nom" => "plus", "img" => IMG . "icone/plus.png"],
        );

        $view->renderView();
    }
}
