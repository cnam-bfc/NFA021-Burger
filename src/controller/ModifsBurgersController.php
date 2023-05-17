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
        $RecetteDAO = new RecetteDAO();


        //Récupération du prix de la Recette
        $Recette = $RecetteDAO->selectById((int)$idRecette);
        $prix = $Recette->getPrix();
        $nomRecette = $Recette->getNom();
        $tabResult = array();

        foreach ($IngredientsBasiques as $IngredientBasique) {
            $idIngredient = $IngredientBasique->getIdIngredient();
            $ordreIngredient = $IngredientBasique->getOrdre();
            $Ingredient = $ingredientDAO->selectById((int) $idIngredient);
            $nom = $Ingredient->getNom();
            $quantite = $IngredientBasique->getQuantite();
            $imgEclatee = IMG . 'ingredients/' . $idIngredient . '/presentation.img';
            $tabResult[] = array('nom' => $nom, "quantite" => $quantite, "imgEclatee" => $imgEclatee, 'ordre' => $ordreIngredient, 'nom Recette' => $nomRecette);
        }


        // Fonction de comparaison personnalisée
        usort($tabResult, function ($a, $b) {
            if ($a['ordre'] == $b['ordre']) {
                return 0;
            }
            return ($a['ordre'] < $b['ordre']) ? -1 : 1;
        });

        $tabRecette[] = array($tabResult, $prix, $nomRecette);


        $view = new View(BaseTemplate::JSON, null);

        $view->json = $tabRecette;


        $view->renderView();
    }

    public function ajoutPanier()
    {

        //créer la varible de session Panier si elle n'existe pas déjà

        if (!isset($_SESSION['panier'])) {

            $_SESSION['panier'] = array();
        }



        $infosJSON = $_POST['burgerAjoute'];

        $json_str = json_encode($infosJSON);
        $infos = json_decode($json_str, false);

        if ($infos === null) {
            error_log('Erreur de décodage JSON : ' . json_last_error_msg(), 0);
            $error = array('error' => 'Erreur de décodage JSON.');
            http_response_code(400); // code de réponse HTTP pour une erreur de requête
            echo json_encode($error);
            return;
        }



        array_push($_SESSION['panier'],$infos);
        
        


        $view = new View(BaseTemplate::JSON, null);
        $view->json = $infos;
        $view->renderView();
    }
}
