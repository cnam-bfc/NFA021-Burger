<?php
class ListeProduitsController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeProduitsView');

        $ingredientDAO = new IngredientDAO();
        $view->ingr = $ingredientDAO->selectAllNonArchive();

        $ingredients = $ingredientDAO->selectAllNonArchive();

        //Pour chaque ingrédient on récupère son icone
        $icone = array();
        foreach ($ingredients as $donnees) {
            $icone[] =
                ["img" => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $donnees->getId() . DIRECTORY_SEPARATOR . 'presentation.img'];
        }

        $fournisseurDAO = new FournisseurDAO();
        $view->fournisseur = $fournisseurDAO->selectAll();

        $view->icone = $icone;

        $view->renderView();
    }

    //Méthode pour archiver un ingrédient
    function archiver()
    {
        $view = new View(BaseTemplate::JSON);

        if (isset($_POST['data'])) {

            $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
            $data = json_decode($rawData, true);

            $idIngredient = $data['id'];

            $dao = new IngredientDAO();
            $ingredient = $dao->selectById($idIngredient);

            $ingredient->setDateArchive(date("Y-m-d H:i:s"));
            $dao->update($ingredient);

            unset($_POST['data']);
        }
        $view->json = array("id" => $idIngredient);
        $view->renderView();
    }
}
