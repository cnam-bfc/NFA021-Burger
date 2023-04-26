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
        $recetteDAO = new IngredientRecetteBasiqueDAO();
        $tabIngredients = $recetteDAO->selectAllByIdRecette($idRecette);

        $ingredientDAO = new IngredientDAO();
        $tabDetailsIngredients = array();

        foreach ($tabIngredients as $donnes) {
            $tabDetailsIngredients[] = $ingredientDAO->selectById($donnes->getIdIngredient());
        }


        




        $view = new View(BaseTemplate::JSON, null);

        $view->json = $tabDetailsIngredients;

        $view->renderView();
    }
}
