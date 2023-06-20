<?php

class VisuBurgerCuisineController extends Controller
{
    public function afficheBurger()
    {
        // Récupération de l'id de la recette à afficher vue éclatée
        $recetteId = Form::getParam('id', Form::METHOD_GET, Form::TYPE_INT);
        $comClientId = Form::getParam('idcc', Form::METHOD_GET, Form::TYPE_INT);
        $recetteFinaleId = Form::getParam('idrf', Form::METHOD_GET, Form::TYPE_INT);

        // Création des objets DAO


        // Création du json
        $json = array();
        $json['data'] = array();

        // Récupération de la recette
        // Création des objets DAO
        $recetteDAO = new RecetteDAO();
        $recetteFinaleDAO = new RecetteFinaleDAO();
        $recetteFinaleIngredientDAO = new RecetteFinaleIngredientDAO();
        $recetteIngredientBasiqueDAO = new RecetteIngredientBasiqueDAO();
        $ingredientDAO = new IngredientDAO();
        $uniteDAO = new UniteDAO();


        // Création du json
        $json = array();
        $json['data'] = array();

        // Récupération de la recette

        $recette = $recetteDAO->selectById($recetteId);

        $recetteFinale = $recetteFinaleDAO->selectByIdCmdClientAndRecette($recetteId, $comClientId);

        $recetteFinaleIngredients = $recetteFinaleIngredientDAO->selectAllByIdRecetteFinale($recetteFinaleId);

        // Récupération des ingrédients
        $ingredients = $ingredientDAO->selectAll();

        // Récupération des unités
        $unites = $uniteDAO->selectAll();

        $jsonRecette = array();

        foreach ($recetteFinaleIngredients as $ingredientFinal) {
            /** @var Ingredient $ingredient */
            $ingredient = null;
            // Récupération de l'ingrédient
            foreach ($ingredients as $ingredientTmp) {
                if ($ingredientTmp->getId() === $ingredientFinal->getIdIngredient()) {
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

            if ($ingredient->isAfficherVueEclatee() == 1) {
                $image = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'eclate.img';
            } else {
                $image = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img';
            }
            if ($ingredientFinal->getQuantite() == 0)
            {
                continue;
            }
            else
            {
                $jsonIngredient = array(
                    'ordre' => $ingredientFinal->getOrdre(),
                    'nom' => $ingredient->getNom(),
                    'quantite' => $ingredientFinal->getQuantite(),
                    'unite' => $unite->getDiminutif(),
                    'image' => $image,
                );
            }

            $jsonRecetteIngredients[] = $jsonIngredient;
        }

        $jsonRecette = array(
            'id' => $recette->getId(),
            'idcc' => $comClientId,
            'nom' => $recette->getNom(),
            'quantite' => $recetteFinale->getQuantite(),
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
        $view = new View(BaseTemplate::EMPTY, 'VisuBurgerCuisineView');
        $view->renderView();
    }
}