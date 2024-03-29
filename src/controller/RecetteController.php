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
        $recetteIngredientBasiqueDAO = new RecetteIngredientBasiqueDAO();
        $recetteIngredientOptionnelDAO = new RecetteIngredientOptionnelDAO();
        $recetteSelectionMultipleDAO = new RecetteSelectionMultipleDAO();
        $ingredientRecetteSelectionMultipleDAO = new IngredientRecetteSelectionMultipleDAO();

        $json = array();
        $json['data'] = array();

        // Récupération des recettes
        $recettes = $recetteDAO->selectAllNonArchive();

        // Récupération des ingrédients
        $ingredients = $ingredientDAO->selectAll();

        // Récupération des unités
        $unites = $uniteDAO->selectAll();

        // Formatage des recettes en json
        foreach ($recettes as $recette) {
            // Récupération des ingrédients basiques de la recette
            $ingredientRecetteBasiques = $recetteIngredientBasiqueDAO->selectAllByIdRecette($recette->getId());

            // Récupération des ingrédients optionnels de la recette
            $ingredientRecetteOptionnels = $recetteIngredientOptionnelDAO->selectAllByIdRecette($recette->getId());

            $jsonRecetteIngredients = array();

            // Formatage des ingrédients basiques en json
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

                // Si l'unité n'existe pas, on passe à l'ingrédient de la recette suivant
                if ($unite === null) {
                    continue;
                }

                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'ordre' => $ingredientRecetteBasique->getOrdre(),
                    'nom' => $ingredient->getNom(),
                    'quantite' => $ingredientRecetteBasique->getQuantite(),
                    'unite' => $unite->getDiminutif(),
                    'optionnel' => false
                );

                $jsonRecetteIngredients[] = $jsonIngredient;
            }

            // Formatage des ingrédients optionnels en json
            foreach ($ingredientRecetteOptionnels as $ingredientRecetteOptionnel) {
                /** @var Ingredient $ingredient */
                $ingredient = null;
                // Récupération de l'ingrédient
                foreach ($ingredients as $ingredientTmp) {
                    if ($ingredientTmp->getId() === $ingredientRecetteOptionnel->getIdIngredient()) {
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

                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'ordre' => $ingredientRecetteOptionnel->getOrdre(),
                    'nom' => $ingredient->getNom(),
                    'quantite' => $ingredientRecetteOptionnel->getQuantite(),
                    'unite' => $unite->getDiminutif(),
                    'optionnel' => true
                );

                $jsonRecetteIngredients[] = $jsonIngredient;
            }

            // Récupération des sélections multiples de la recette
            $recetteSelectionMultiples = $recetteSelectionMultipleDAO->selectAllByIdRecette($recette->getId());
            foreach ($recetteSelectionMultiples as $recetteSelectionMultiple) {
                // Récupération des ingrédients de la sélection multiple
                $ingredientRecetteSelectionMultiples = $ingredientRecetteSelectionMultipleDAO->selectAllByIdSelectionMultipleRecette($recetteSelectionMultiple->getId());

                // Construction du json de la sélection multiple
                $jsonSelectionMultiple = array(
                    'ordre' => $recetteSelectionMultiple->getOrdre(),
                    'quantite' => $recetteSelectionMultiple->getQuantite(),
                    'ingredients' => array()
                );

                // Formatage des ingrédients de la sélection multiple en json
                foreach ($ingredientRecetteSelectionMultiples as $ingredientRecetteSelectionMultiple) {
                    /** @var Ingredient $ingredient */
                    $ingredient = null;
                    // Récupération de l'ingrédient
                    foreach ($ingredients as $ingredientTmp) {
                        if ($ingredientTmp->getId() === $ingredientRecetteSelectionMultiple->getIdIngredient()) {
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

                    // Construction du json de l'ingrédient
                    $jsonIngredient = array(
                        'nom' => $ingredient->getNom(),
                        'quantite' => $ingredientRecetteSelectionMultiple->getQuantite(),
                        'unite' => $unite->getDiminutif(),
                    );

                    $jsonSelectionMultiple['ingredients'][] = $jsonIngredient;
                }

                $jsonRecetteIngredients[] = $jsonSelectionMultiple;
            }

            // Tri des ingrédients par ordre
            usort($jsonRecetteIngredients, function ($a, $b) {
                return $a['ordre'] - $b['ordre'];
            });

            // Formatage de la recette en json
            $jsonRecette = array(
                'id' => $recette->getId(),
                'nom' => $recette->getNom(),
                'description' => $recette->getDescription(),
                'image' => IMG . 'recettes' . DIRECTORY_SEPARATOR . $recette->getId() . DIRECTORY_SEPARATOR . 'presentation.img',
                'prix' => $recette->getPrix(),
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
        elseif ($recette->getDateArchive() !== null) {
            $json['success'] = false;
        }
        // Sinon, on archive la recette
        else {
            // Archivage de la recette
            $recette->setDateArchive(date('Y-m-d H:i:s'));

            // Mise à jour de la recette
            $recetteDAO->update($recette);

            $json['success'] = true;
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }
}
