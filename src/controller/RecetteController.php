<?php
class RecetteController extends Controller
{
    public function renderViewRecettes()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'RecetteView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function listeRecettes()
    {
        // Création des objets DAO
        $recetteDAO = new RecetteDAO();
        $ingredientDAO = new IngredientDAO();
        $uniteDAO = new UniteDAO();
        $ingredientRecetteBasiqueDAO = new IngredientRecetteBasiqueDAO();
        $ingredientRecetteOptionnelDAO = new IngredientRecetteOptionnelDAO();

        $json = array();
        $json['data'] = array();

        // Récupération des recettes
        $recettes = $recetteDAO->selectAll();

        // Récupération des ingrédients
        $ingredients = $ingredientDAO->selectAll();

        // Récupération des unités
        $unites = $uniteDAO->selectAll();

        // Formatage des recettes en json
        foreach ($recettes as $recette) {
            // Si la recette est archivée, on ne l'affiche pas
            if ($recette->getDateArchiveRecette() !== null) {
                continue;
            }

            // Récupération des ingrédients basiques de la recette
            $ingredientRecetteBasiques = $ingredientRecetteBasiqueDAO->selectAllByIdRecette($recette->getIdRecette());

            // Récupération des ingrédients optionnels de la recette
            $ingredientRecetteOptionnels = $ingredientRecetteOptionnelDAO->selectAllByIdRecette($recette->getIdRecette());

            // Formatage des ingrédients basiques en json
            $jsonRecetteIngredientsBasique = array();
            foreach ($ingredientRecetteBasiques as $ingredientRecetteBasique) {
                /** @var Ingredient $ingredient */
                $ingredient = null;
                // Récupération de l'ingrédient
                foreach ($ingredients as $ingredientTmp) {
                    if ($ingredientTmp->getIdIngredient() === $ingredientRecetteBasique->getIdIngredient()) {
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
                    if ($uniteTmp->getIdUnite() === $ingredient->getIdUniteFK()) {
                        $unite = $uniteTmp;
                        break;
                    }
                }

                // Si l'unité n'existe pas, on passe à l'ingrédient de la recette suivant
                if ($unite === null) {
                    continue;
                }

                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'nom' => $ingredient->getNomIngredient(),
                    'quantite' => $ingredientRecetteBasique->getQuantite(),
                    'unite' => $unite->getDiminutifUnite(),
                    'optionnel' => false
                );

                $jsonRecetteIngredients[] = $jsonIngredient;
            }

            // Formatage des ingrédients optionnels en json
            $jsonRecetteIngredientsOptionnel = array();
            foreach ($ingredientRecetteOptionnels as $ingredientRecetteOptionnel) {
                /** @var Ingredient $ingredient */
                $ingredient = null;
                // Récupération de l'ingrédient
                foreach ($ingredients as $ingredientTmp) {
                    if ($ingredientTmp->getIdIngredient() === $ingredientRecetteOptionnel->getIdIngredient()) {
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
                    if ($uniteTmp->getIdUnite() === $ingredient->getIdUniteFK()) {
                        $unite = $uniteTmp;
                        break;
                    }
                }

                // Si l'unité n'existe pas, on passe à l'ingrédient de la recette suivant
                if ($unite === null) {
                    continue;
                }

                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'nom' => $ingredient->getNomIngredient(),
                    'quantite' => $ingredientRecetteOptionnel->getQuantite(),
                    'unite' => $unite->getDiminutifUnite(),
                    'optionnel' => true
                );

                $jsonRecetteIngredients[] = $jsonIngredient;
            }

            // Formatage de la recette en json
            $jsonRecette = array(
                'id' => $recette->getIdRecette(),
                'nom' => $recette->getNomRecette(),
                'description' => $recette->getDescriptionRecette(),
                'image' => DATA_RECETTES . $recette->getIdRecette() . '/presentation.img',
                'prix' => $recette->getPrixRecette(),
                'ingredients' => $jsonRecetteIngredients,
            );

            $json['data'][] = $jsonRecette;
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }

    public function supprimerRecette()
    {
        // Récupération des paramètres
        $idRecette = Form::getParam('id', Form::METHOD_POST, Form::TYPE_INT);

        $json = array();

        // Création des objets DAO
        $recetteDAO = new RecetteDAO();

        // Récupération de la recette
        $recette = $recetteDAO->selectById($idRecette);

        // Si la recette n'existe pas, on retourne une erreur
        if ($recette === null) {
            $json['success'] = false;
        }
        // Si la recette est déjà archivée, on retourne une erreur
        elseif ($recette->getDateArchiveRecette() !== null) {
            $json['success'] = false;
        }
        // Sinon, on archive la recette
        else {
            // Archivage de la recette
            $recette->setDateArchiveRecette(date('Y-m-d H:i:s'));

            // Mise à jour de la recette
            $recetteDAO->update($recette);

            $json['success'] = true;
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }
}
