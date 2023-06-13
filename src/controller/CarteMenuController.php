<?php

class CarteMenuController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::CLIENT, 'CarteMenuView');

        $view->renderView();
    }

    public function listeBurgers()
    {

        // Création des objets DAO
        $recetteDAO = new RecetteDAO();

        $json = array();
        $json['data'] = array();

        $recettes = $recetteDAO->selectAllNonArchive();

        //Formatage des recettes en json
        foreach ($recettes as $recette) {

            $jsonRecette = array(
                'id' => $recette->getId(),
                'nom' => $recette->getNom(),
                'description' => $recette->getDescription(),
                'image' => IMG . 'recettes' . DIRECTORY_SEPARATOR . $recette->getId() . DIRECTORY_SEPARATOR .'presentation.img',
                'prix' => $recette->getPrix(),
            );
            $json['data'][] = $jsonRecette;

        }
        usort($json['data'], function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });

        $view = new View(BaseTemplate::JSON);
        $view->json = $json;

        $view->renderView();


    }

    public function ajoutPanier() {


        if (!isset($_SESSION['panier'])) {

            $_SESSION['panier'] = array();
        }

        //Récupération de l'id du Burger cliqué
        $idBurger = Form::getParam('id', Form::METHOD_POST, Form::TYPE_INT);

        //Appel des DAO
        $recetteDAO = new RecetteDAO();
        $ingredientBasiqueDAO = new RecetteIngredientBasiqueDAO();
        $ingredientDAO = new IngredientDAO();
        $uniteDAO = new UniteDAO();


        $recette = $recetteDAO->selectById($idBurger);
        $ingredientRecetteBasiques = $ingredientBasiqueDAO->selectAllByIdRecette($idBurger);
        $unites = $uniteDAO->selectAllNonArchive();
        $ingredients = $ingredientDAO->selectAllNonArchive();

        $json = array();
        $json['data'] = array();
        $jsonIngredients[] = array();

        foreach ($ingredientRecetteBasiques as $ingredientRecetteBasique) {
            /** @var Ingredient $ingredient */
            $ingredient = null;
            // Récupération de l'ingrédient
            foreach ($ingredients as $ingredientTmp) {
                if ($ingredientTmp->getId() === $ingredientRecetteBasique->getIdIngredient()) {
                    $ingredient = $ingredientTmp;
                    break;
                }
            }

            // Si l'ingrédient n'existe pas, on passe à l'ingrédient de la recette suivant
            if ($ingredient === null) {
                continue;
            }

            /** @var Unite $unite */
            $unite = null;
            // Récupération de l'unité
            foreach ($unites as $uniteTmp) {
                if ($uniteTmp->getId() === $ingredient->getIdUnite()) {
                    $unite = $uniteTmp;
                    break;
                }
            }

            if ($unite === null) {
                continue;
            }
            $quantite = $ingredientRecetteBasique->getQuantite() . ' ' . $unite->getDiminutif();
            // Construction du json de l'ingrédient
            $jsonIngredients[] = [
                'nom' => $ingredient->getNom(),
                'quantite' =>  $quantite,

            ];
        }

        $json = array(
            'prixRecette' => $recette->getPrix(),
            'nomRecette' => $recette->getNom(),
            'idRecette' => $recette->getId(),
            'carteburger' => true,
            'ingredientsFinaux' => $jsonIngredients,
        );

        $_SESSION['panier'][] = $json;

        $view = new View(BaseTemplate::JSON);

        $view->json = $_SESSION['panier'];

        $view->renderView();
    }
}

