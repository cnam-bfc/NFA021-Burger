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

        $flecheG = IMG . 'Fleches/FlecheCourbeGauche.png';
        $flecheD = IMG . 'Fleches/FlecheCourbeDroite.png';

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
        $uniteDao = new UniteDAO();

        //DAO recette selection multiple (if yes)
        $rSelectionMultiple = new RecetteSelectionMultipleDAO();
        $tabRecettesSelectionMultiple = $rSelectionMultiple->selectAllByIdRecette((int)$idRecette);

        //DAO ingrédient recette selection multiple
        //si la recette a des selection multiple

        $tabResult = array();
        $Recette = $RecetteDAO->selectById((int)$idRecette);
        $prix = $Recette->getPrix();
        $nomRecette = $Recette->getNom();

        if ($tabRecettesSelectionMultiple != null) {


            //je récupère les id recetteSelectionMultiple
            // $tabRecetteSelectionMutipleId = array();
            foreach ($tabRecettesSelectionMultiple as $r) {
                // array_push($tabRecetteSelectionMutipleId,$r->getId());
                $nom = array();
                $quantite  = array();
                $nom = array();
                $unite = array();
                $imgEclatee = array();
                $ordreIngredient = array();


                $iSelectionMultiple = new IngredientRecetteSelectionMultipleDAO();
                $tabIngreidentsRecetteSM = $iSelectionMultiple->selectAllByIdSelectionMultipleRecette($r->getId());
                foreach ($tabIngreidentsRecetteSM as $i) {
                    // var_dump($i);
                    $Ingredient = $ingredientDAO->selectById((int) $i->getIdIngredient());


                    $idIngredient = $Ingredient->getId();

                    $Ingredient = $ingredientDAO->selectById((int) $idIngredient);
                    $n = $Ingredient->getNom();
                    $q = $i->getQuantite();

                    $idUnite = $Ingredient->getIdUnite();
                    $uniteSelect = $uniteDao->selectById($idUnite);
                    $u = $uniteSelect->getDiminutif();
                    $img = IMG . 'ingredients/' . $idIngredient . '/eclate.img';

                    $nom[] = $n;
                    $quantite[] = $q;
                    $unite[] = $u;
                    $imgEclatee[] = $img;
                }
                $ordreIngredient = $r->getOrdre();
                //combien d'ingrédient à choisir parmis les 4 par exemple
                $aChoisir = $r->getQuantite();


                $tabResult[] = array('nom' => $nom, "quantite" => $quantite, "unite" =>  $unite, "imgEclatee" => $imgEclatee, 'ordre' => $ordreIngredient, 'nom Recette' => $nomRecette, 'flecheDroite' => $flecheD, 'flecheGauche' => $flecheG, 'aChoisir' => $aChoisir, 'selectMultiple' => true, 'IdIngredient' => $idIngredient);
            }

            //dans foreach verifier l'ingrédient avec id ingredient_fk
        }


        //Récupération du prix de la Recette



        foreach ($IngredientsBasiques as $IngredientBasique) {
            $idIngredient = $IngredientBasique->getIdIngredient();
            $ordreIngredient = $IngredientBasique->getOrdre();
            $Ingredient = $ingredientDAO->selectById((int) $idIngredient);
            $nom = $Ingredient->getNom();
            $quantite = $IngredientBasique->getQuantite();
            $idUnite = $Ingredient->getIdUnite();
            $uniteSelect = $uniteDao->selectById($idUnite);
            $unite = $uniteSelect->getDiminutif();
            $imgEclatee = IMG . 'ingredients/' . $idIngredient . '/eclate.img';

            $tabResult[] = array('nom' => $nom, "quantite" => $quantite, "unite" =>  $unite, "imgEclatee" => $imgEclatee, 'ordre' => $ordreIngredient, 'nom Recette' => $nomRecette, 'flecheDroite' => $flecheD, 'flecheGauche' => $flecheG, 'selectMultiple' => false, 'IdIngredient' => $idIngredient);
        }


        // Fonction de comparaison personnalisée
        usort($tabResult, function ($a, $b) {
            if ($a['ordre'] == $b['ordre']) {
                return 0;
            }
            return ($a['ordre'] < $b['ordre']) ? -1 : 1;
        });
        ////////////////////POUR LES SUPPLEMENTS//////////////////////////////
        $SupplementsTab = array();
        $supplementsDAO = new RecetteIngredientOptionnelDAO();
        $supplements = $supplementsDAO->selectAllByIdRecette($idRecette);
        $ingredientDAO = new IngredientDAO();
        $uniteDao = new UniteDAO();


        foreach ($supplements as $supplement) {
            $ordre = $supplement->getOrdre();
            $id = $supplement->getId();

            $idI = $supplement->getIdIngredient();
            $quantite = $supplement->getQuantite();

            $Ingredient = $ingredientDAO->selectById($idI);

            $nom = $Ingredient->getNom();


            $idUnite = $Ingredient->getIdUnite();
            $uniteSelect = $uniteDao->selectById($idUnite);
            $unite = $uniteSelect->getDiminutif();

            $imgEclatee = IMG . 'ingredients/' . $idI . '/eclate.img';

            // $ingredient = $ingredientDAO->selectById($idI);
            // $imgE=$ingredient->

            $SupplementsTab[] = array('id' => $id, 'nom' => $nom, "quantite" => $quantite, "unite" =>  $unite, "imgEclatee" => $imgEclatee, 'ordre' => $ordre, 'IdIngredient' => $idI);
        }

         // Fonction de comparaison personnalisée
         usort($SupplementsTab, function ($a, $b) {
            if ($a['ordre'] == $b['ordre']) {
                return 0;
            }
            return ($a['ordre'] < $b['ordre']) ? -1 : 1;
        });
        /////////////////////FIN POUR LES SUPPLEMENTS////////////////////////////////////////////

        $tabRecette = array($tabResult, $prix, $nomRecette,$SupplementsTab);
        // echo ("resultat");
        // var_dump($tabRecette);

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

        array_push($_SESSION['panier'], $infos);


        $view = new View(BaseTemplate::JSON, null);
        $view->json = $_SESSION['panier'];
        $view->renderView();
    }
    public function getSupplements()
    {
        $idRecette = $_POST['id'];

        $tabResult = array();
        $supplementsDAO = new RecetteIngredientOptionnelDAO();
        $supplements = $supplementsDAO->selectAllByIdRecette($idRecette);
        $ingredientDAO = new IngredientDAO();
        $uniteDao = new UniteDAO();


        foreach ($supplements as $supplement) {
            $ordre = $supplement->getOrdre();
            $id = $supplement->getId();

            $idI = $supplement->getIdIngredient();
            $quantite = $supplement->getQuantite();

            $Ingredient = $ingredientDAO->selectById($idI);

            $nom = $Ingredient->getNom();


            $idUnite = $Ingredient->getIdUnite();
            $uniteSelect = $uniteDao->selectById($idUnite);
            $unite = $uniteSelect->getDiminutif();

            $imgEclatee = IMG . 'ingredients/' . $idI . '/eclate.img';

            $prix = $supplement->getPrix(); 

            // $ingredient = $ingredientDAO->selectById($idI);
            // $imgE=$ingredient->

            $tabResult[] = array('id' => $id, 'nom' => $nom, "quantite" => $quantite, "unite" =>  $unite, "imgEclatee" => $imgEclatee, 'ordre' => $ordre, 'IdIngredient' => $idI, "prix" => $prix);
        }


        $view = new View(BaseTemplate::JSON, null);
        $view->json = $tabResult;
        $view->renderView();
    }
}
