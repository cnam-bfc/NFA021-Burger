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
        $IngredientRecetteBasiqueDAO = new RecetteIngredientBasiqueDAO();
        $IngredientsBasiques = $IngredientRecetteBasiqueDAO->selectAllByIdRecette($idRecette);
        /* dans ce tableau  : $IngredientsRecette,
        j'ai idRecette, idIngredient & quantite 
        Je dois utiliser idIngredient pour avoire le nom de l'ingrédient & l'img éclatée
        PS ce que je dois avoire au final c'est la nom, la quantité, l'image éclaté pour chaque ingrédient*/
        $ingredientDAO = new IngredientDAO();
        $tabResult = array();

        foreach ($IngredientsBasiques as $IngredientBasique) {
            $idIngredient = $IngredientBasique->getIdIngredient();
            $ordreIngredient = $IngredientBasique->getOrdre();
            $Ingredient = $ingredientDAO->selectById((int) $idIngredient);
            $nom = $Ingredient->getNom();
            $quantite = $IngredientBasique->getQuantite();
            $imgEclatee = IMG . 'ingredients/' . $idIngredient . '/presentation.img';
            $tabResult[] = array('nom' => $nom, "quantite" => $quantite, "imgEclatee" => $imgEclatee, 'ordre' => $ordreIngredient);
        }

        // Fonction de comparaison personnalisée
        usort($tabResult, function($a, $b) {
            if ($a['ordre'] == $b['ordre']) {
                return 0;
            }
            return ($a['ordre'] < $b['ordre']) ? -1 : 1;
        });
        








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
