<?php

class RecetteCuisineController extends Controller
{
    public function afficheBurger()
    {
        // Récupération de l'id de la recette à afficher vue éclatée
        $recetteId = Form::getParam('id', Form::METHOD_GET, Form::TYPE_INT);

        // Création des objets DAO


        // Création du json
        $json = array();
        $json['data'] = array();

        // Récupération de la recette
        // Création des objets DAO
        $recetteDAO = new RecetteDAO();
        $recetteFinaleDAO = new RecetteFinaleDAO();
        $recetteIngredientBasiqueDAO = new RecetteIngredientBasiqueDAO();
        $ingredientDAO = new IngredientDAO();
        $uniteDAO = new UniteDAO();


        // Création du json
        $json = array();
        $json['data'] = array();

        // Récupération de la recette
        $ingredientsBasiques = $recetteIngredientBasiqueDAO->selectAllByIdRecette($recetteId);

        $recette = $recetteDAO->selectById($recetteId);

        // Récupération des ingrédients
        $ingredients = $ingredientDAO->selectAll();

        // Récupération des unités
        $unites = $uniteDAO->selectAll();

        $jsonRecette = array();

        foreach ($ingredientsBasiques as $ingredientBasique) {
            /** @var Ingredient $ingredient */
            $ingredient = null;
            // Récupération de l'ingrédient
            foreach ($ingredients as $ingredientTmp) {
                if ($ingredientTmp->getId() === $ingredientBasique->getIdIngredient()) {
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

            // Si l'unité n'existe pas, on passe à l'ingrédient de la recette suivant
            if ($unite === null) {
                continue;
            }

            if($ingredient->isAfficherVueEclatee() == 1) {
                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'ordre' => $ingredientBasique->getOrdre(),
                    'nom' => $ingredient->getNom(),
                    'quantite' => $ingredientBasique->getQuantite(),
                    'unite' => $unite->getDiminutif(),
                    'image' => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'eclate.img',
                );
            } else {
                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'ordre' => $ingredientBasique->getOrdre(),
                    'nom' => $ingredient->getNom(),
                    'quantite' => $ingredientBasique->getQuantite(),
                    'unite' => $unite->getDiminutif(),
                    'image' => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img',
                );
            }

            $jsonRecetteIngredients[] = $jsonIngredient;
        }

        $jsonRecette = array(
            'id' => $recette->getId(),
            'nom' => $recette->getNom(),
            'ingredients' => $jsonRecetteIngredients,
        );

        $json['data'][] = $jsonRecette;

        usort($json['data'], function ($a, $b) {
            return $a['ordre'] <=> $b['ordre'];
        });


        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }

    public function renderView()
    {
        $view = new View(BaseTemplate::EMPTY, 'RecetteCuisineView');

        $view->renderView();
    }
}