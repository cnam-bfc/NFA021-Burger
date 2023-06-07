<?php
class ListeProduitsController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeProduitsView');

        if (!empty($_GET)) {
            $ingredientDAO = new IngredientDAO();

            $ingredient = $ingredientDAO->selectById($_GET['idIngredient']);
            $ingredient->setDateArchive(date('Y-m-d H:i:s'));

            $ingredientDAO->update($ingredient);
        }


        $ingredientDAO = new IngredientDAO();
        $view->ingr = $ingredientDAO->selectAllNonArchive();

        $ingr = $ingredientDAO->selectAllNonArchive();

        $icone = array();
        foreach ($ingr as $donnees) {
            $icone[] =
                ["img" => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $donnees->getId() . DIRECTORY_SEPARATOR . 'presentation.img'];
        }

        $view->utile = array(
            ["img" => IMG . "icone/Modifier.png"],
            ["img" => IMG . "icone/Archiver.png"]
        );

        $fournisseurDAO = new FournisseurDAO();
        $view->fournisseur = $fournisseurDAO->selectAll();

        $view->icone = $icone;

        $view->renderView();
    }
}
