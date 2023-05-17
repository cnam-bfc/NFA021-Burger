<?php
class ListeProduitsController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeProduitsView');

        $ingredientDAO = new IngredientDAO();
        $view->ingr = $ingredientDAO->selectAll();

        $ingr = $ingredientDAO->selectAll();

        $icone = array();
        foreach ($ingr as $donnees) {
            $icone[] =
                ["img" => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $donnees->getId() . DIRECTORY_SEPARATOR . 'presentation.img'];
        }

        $view->modifier = array(
            ["img" => IMG . "icone/Modifier.png"]
        );

        $fournisseurDAO = new FournisseurDAO();
        $view->fournisseur = $fournisseurDAO->selectAll();

        $view->icone = $icone;

        $view->renderView();
    }
}
