<?php

class ModifsBurgersController extends Controller
{
    public function renderViewPimpBurgers()
    {
        $view = new View(BaseTemplate::CLIENT, 'PimpBurgersView');


        $view->renderView();
    }
    public function getIngredients()
    {



        $idRecette = $_POST['id'];

        /*Jusque là c'est good*/
        $IngredientRecetteBasiqueDAO = new IngredientRecetteBasiqueDAO();
        $IngredientsBasiques = $IngredientRecetteBasiqueDAO->selectAllByIdRecette($idRecette);
        /* dans ce tableau  : $IngredientsRecette,
        j'ai idRecette, idIngredient & quantite 
        Je dois utiliser idIngredient pour avoire le nom de l'ingrédient & l'img éclatée
        PS ce que je dois avoire au final c'est la nom, la quantité, l'image éclaté pour chaque ingrédient*/
        $ingredientDAO = new IngredientDAO();
        $tabResult = array();

        foreach ($IngredientsBasiques as $IngredientBasique) {
            $idIngredient = $IngredientBasique->getIdIngredient();
            $Ingredient = $ingredientDAO->selectById((int) $idIngredient);
            $nom = $Ingredient->getNomIngredient();
            $quantite = $IngredientBasique->getQuantite();
            $imgEclatee = $Ingredient->getPhotoEclateeIngredient();
            $tabResult[] = array('nom' => $nom, "quantite" => $quantite, "imgEclatee" => $imgEclatee);
        }








        /*$jsonIngredient = array(
            'nom' => $ingredient->getNomIngredient(),
            'quantite' => $ingredientRecetteBasique->getQuantite(),
            'unite' => $unite->getDiminutifUnite(),
            'optionnel' => false
        );*/







        $view = new View(BaseTemplate::JSON, null);

        $view->json = $tabResult;


        $view->renderView();
    }
}
