<?php
class RecetteEditController extends Controller
{
    public function renderViewAjouterRecette()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'RecetteEditView');

        // Définition des variables utilisées dans la vue
        $view->titre = "Ajout d'une recette";

        $view->renderView();
    }

    public function renderViewModifierRecette()
    {
        // Récupération de l'id de la recette à modifier
        $recetteId = Form::getParam('id', Form::METHOD_GET, Form::TYPE_INT);

        // Initialisation des DAO
        $recetteDAO = new RecetteDAO();

        // Récupération de la recette à modifier
        $recette = $recetteDAO->selectById($recetteId);

        // Si la recette n'existe pas, on affiche une erreur
        if ($recette == null) {
            ErrorController::error(404, "La recette n'existe pas.");
            return;
        }

        $view = new View(BaseTemplate::EMPLOYE, 'RecetteEditView');

        // Définition des variables utilisées dans la vue
        $view->titre = "Modification d'une recette";

        $view->recetteId = $recette->getId();
        $view->recetteNom = $recette->getNom();
        $view->recetteDescription = $recette->getDescription();
        $view->recettePrix = $recette->getPrix();
        $view->recetteImage = IMG . 'recettes' . DIRECTORY_SEPARATOR . $recette->getId() . DIRECTORY_SEPARATOR . 'presentation.img';

        $view->renderView();
    }

    public function listeIngredients()
    {
        // Récupération de l'id de la recette
        $recetteId = Form::getParam('id', Form::METHOD_GET, Form::TYPE_INT);

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

        // Récupération de la recette
        $recette = $recetteDAO->selectById($recetteId);
        // Si la recette n'existe pas, on affiche une erreur
        if ($recette === null) {
            ErrorController::error(404, "La recette n'existe pas.");
            return;
        }

        // Récupération des unités
        $unites = $uniteDAO->selectAll();

        // Formatage des ingrédients en json
        // Récupération des ingrédients basiques de la recette
        $recetteIngredientBasiques = $recetteIngredientBasiqueDAO->selectAllByIdRecette($recette->getId());

        // Récupération des ingrédients optionnels de la recette
        $recetteIngredientOptionnels = $recetteIngredientOptionnelDAO->selectAllByIdRecette($recette->getId());

        // Récupération des ingrédients des sélections multiples de la recette
        $recetteSelectionMultiples = $recetteSelectionMultipleDAO->selectAllByIdRecette($recette->getId());

        // Formatage des ingrédients basiques en json
        foreach ($recetteIngredientBasiques as $recetteIngredientBasique) {
            // Récupération de l'ingrédient
            $ingredient = $ingredientDAO->selectById($recetteIngredientBasique->getIdIngredient());

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

            // Récupération de l'image de l'ingrédient
            if ($ingredient->isAfficherVueEclatee()) {
                $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'eclate.img';
            } else {
                $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img';
            }

            // Construction du json de l'ingrédient
            $jsonIngredient = array(
                'id' => $ingredient->getId(),
                'ordre' => $recetteIngredientBasique->getOrdre(),
                'image' => $imageIngredient,
                'nom' => $ingredient->getNom(),
                'quantite' => $recetteIngredientBasique->getQuantite(),
                'unite' => $unite->getDiminutif(),
                'optionnel' => false
            );

            $json['data'][] = $jsonIngredient;
        }

        // Formatage des ingrédients optionnels en json
        foreach ($recetteIngredientOptionnels as $recetteIngredientOptionnel) {
            // Récupération de l'ingrédient
            $ingredient = $ingredientDAO->selectById($recetteIngredientOptionnel->getIdIngredient());

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

            // Récupération de l'image de l'ingrédient
            if ($ingredient->isAfficherVueEclatee()) {
                $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'eclate.img';
            } else {
                $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img';
            }

            // Construction du json de l'ingrédient
            $jsonIngredient = array(
                'id' => $ingredient->getId(),
                'ordre' => $recetteIngredientOptionnel->getOrdre(),
                'image' => $imageIngredient,
                'nom' => $ingredient->getNom(),
                'quantite' => $recetteIngredientOptionnel->getQuantite(),
                'unite' => $unite->getDiminutif(),
                'optionnel' => true,
                'prix' => $recetteIngredientOptionnel->getPrix()
            );

            $json['data'][] = $jsonIngredient;
        }

        // Formatage des ingrédients en "sélection multiple" en json
        foreach ($recetteSelectionMultiples as $recetteSelectionMultiple) {
            // Récupération des ingrédients de la sélection multiple
            $selectionMultipleIngredients = $ingredientRecetteSelectionMultipleDAO->selectAllByIdSelectionMultipleRecette($recetteSelectionMultiple->getId());

            // Formatage des ingrédients en json
            $jsonSelectionMultipleIngredients = array();

            foreach ($selectionMultipleIngredients as $selectionMultipleIngredient) {
                // Récupération de l'ingrédient
                $ingredient = $ingredientDAO->selectById($selectionMultipleIngredient->getIdIngredient());

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

                // Récupération de l'image de l'ingrédient
                if ($ingredient->isAfficherVueEclatee()) {
                    $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'eclate.img';
                } else {
                    $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img';
                }

                // Construction du json de l'ingrédient
                $jsonIngredient = array(
                    'id' => $ingredient->getId(),
                    'image' => $imageIngredient,
                    'nom' => $ingredient->getNom(),
                    'quantite' => $selectionMultipleIngredient->getQuantite(),
                    'unite' => $unite->getDiminutif()
                );

                $jsonSelectionMultipleIngredients[] = $jsonIngredient;
            }

            // Construction du json de la sélection multiple
            $jsonSelectionMultiple = array(
                'ordre' => $recetteSelectionMultiple->getOrdre(),
                'quantite' => $recetteSelectionMultiple->getQuantite(),
                'ingredients' => $jsonSelectionMultipleIngredients
            );

            $json['data'][] = $jsonSelectionMultiple;
        }

        // Tri des ingrédients par ordre
        usort($json['data'], function ($a, $b) {
            return $a['ordre'] - $b['ordre'];
        });

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }

    public function listeAllIngredients()
    {
        // Création des objets DAO
        $ingredientDAO = new IngredientDAO();
        $uniteDAO = new UniteDAO();

        $json = array();
        $json['data'] = array();

        // Récupération des ingrédients
        $ingredients = $ingredientDAO->selectAllNonArchive();

        // Récupération des unités
        $unites = $uniteDAO->selectAll();

        // Formatage des ingrédients en json
        foreach ($ingredients as $ingredient) {
            /** @var Unite $unite */
            $unite = null;
            // Récupération de l'unité
            foreach ($unites as $uniteTmp) {
                if ($uniteTmp->getId() === $ingredient->getIdUnite()) {
                    $unite = $uniteTmp;
                    break;
                }
            }

            // Si l'unité n'existe pas, on passe à l'ingrédient suivant
            if ($unite === null) {
                continue;
            }

            // Récupération de l'image de l'ingrédient
            if ($ingredient->isAfficherVueEclatee()) {
                $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'eclate.img';
            } else {
                $imageIngredient = IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img';
            }

            // Construction du json de l'ingrédient
            $jsonIngredient = array(
                'id' => $ingredient->getId(),
                'image' => $imageIngredient,
                'nom' => $ingredient->getNom(),
                'unite' => $unite->getDiminutif(),
                'optionnel' => false
            );

            $json['data'][] = $jsonIngredient;
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }

    public function enregistrerRecette()
    {
        // Récupération des paramètres
        $recetteId = Form::getParam('id_recette', Form::METHOD_POST, Form::TYPE_INT, false);
        $recetteNom = Form::getParam('nom_recette', Form::METHOD_POST, Form::TYPE_STRING);
        $recetteDescription = Form::getParam('description_recette', Form::METHOD_POST, Form::TYPE_STRING);
        $recettePrix = Form::getParam('prix_recette', Form::METHOD_POST, Form::TYPE_FLOAT);

        $json = array();

        // Initialisation des DAO
        $recetteDAO = new RecetteDAO();
        $recetteIngredientBasiqueDAO = new RecetteIngredientBasiqueDAO();
        $recetteIngredientOptionnelDAO = new RecetteIngredientOptionnelDAO();
        $recetteSelectionMultipleDAO = new RecetteSelectionMultipleDAO();
        $ingredientRecetteSelectionMultipleDAO = new IngredientRecetteSelectionMultipleDAO();

        // CAS - Création d'une nouvelle recette
        if ($recetteId === null) {
            // Récupération de l'image de la recette
            $recetteImage = Form::getFile('image_recette', true);

            // Création de la recette
            $recette = new Recette();
            $recette->setNom($recetteNom);
            $recette->setDescription($recetteDescription);
            $recette->setPrix($recettePrix);

            // Enregistrement de la recette
            $recetteDAO->create($recette);

            $recetteId = $recette->getId();
        }
        // CAS - Modification d'une recette existante
        else {
            // Récupération de l'image de la recette
            $recetteImage = Form::getFile('image_recette', false);

            // Récupération de la recette
            $recette = $recetteDAO->selectById($recetteId);

            // Si la recette n'existe pas, on affiche une erreur
            if ($recette === null) {
                ErrorController::error(404, "La recette n'existe pas.");
                return;
            }

            // Modification de la recette
            $recette->setNom($recetteNom);
            $recette->setDescription($recetteDescription);
            $recette->setPrix($recettePrix);

            // Enregistrement de la recette
            $recetteDAO->update($recette);

            // Suppression des ingrédients basiques de la recette
            $recetteIngredientBasiqueDAO->deleteAllByIdRecette($recetteId);

            // Suppression des ingrédients optionnels de la recette
            $recetteIngredientOptionnelDAO->deleteAllByIdRecette($recetteId);

            // Suppression des ingrédients des sélections multiples de la recette
            $recetteSelectionsMultiples = $recetteSelectionMultipleDAO->selectAllByIdRecette($recetteId);
            foreach ($recetteSelectionsMultiples as $recetteSelectionMultiple) {
                $ingredientsRecetteSelectionMultiple = $ingredientRecetteSelectionMultipleDAO->selectAllByIdSelectionMultipleRecette($recetteSelectionMultiple->getId());
                foreach ($ingredientsRecetteSelectionMultiple as $ingredientRecetteSelectionMultiple) {
                    $ingredientRecetteSelectionMultipleDAO->delete($ingredientRecetteSelectionMultiple);
                }

                $recetteSelectionMultipleDAO->delete($recetteSelectionMultiple);
            }
        }

        // Si une image est présente, on l'enregistre dans le bon dossier
        if ($recetteImage !== null) {
            // Déplacement de l'image dans le dossier des images de recettes
            $recetteFolder = DATA_RECETTES . $recetteId . DIRECTORY_SEPARATOR;
            if (!file_exists($recetteFolder)) {
                mkdir($recetteFolder, 0777, true);
            }
            $recetteImagePresentation = $recetteFolder . 'presentation.img';
            move_uploaded_file($recetteImage['tmp_name'], $recetteImagePresentation);
        }

        // Récupération des ingrédients
        $ingredients = json_decode(Form::getParam('ingredients_recette', Form::METHOD_POST, Form::TYPE_STRING), true);

        // Tri des ingrédients par ordre (Remarque : le tri est fait par le javascript, mais on le refait ici pour être sûr. Puis l'ordre sera recalculé dans la boucle suivante)
        usort($ingredients, function ($a, $b) {
            return $a['ordre'] - $b['ordre'];
        });

        // Enregistrement des ingrédients
        $countIngredients = count($ingredients);
        for ($i = 0; $i < $countIngredients; $i++) {
            $ingredient = $ingredients[$i];

            // CAS - Ingrédient
            if (isset($ingredient['id'])) {
                // Récupération des paramètres
                // Vérification valeurs présentes
                if (!isset($ingredient['id']) || !isset($ingredient['quantite']) || !isset($ingredient['optionnel'])) {
                    continue;
                }
                $ingredientId = $ingredient['id'];
                $ingredientQuantite = $ingredient['quantite'];
                $ingredientOptionnel = $ingredient['optionnel'];

                // CAS - Ingrédient basique
                if (!$ingredientOptionnel) {
                    // Création de l'ingrédient
                    $recetteIngredientBasique = new RecetteIngredientBasique();
                    $recetteIngredientBasique->setOrdre($i + 1);
                    $recetteIngredientBasique->setQuantite($ingredientQuantite);
                    $recetteIngredientBasique->setIdRecette($recetteId);
                    $recetteIngredientBasique->setIdIngredient($ingredientId);

                    // Enregistrement de l'ingrédient
                    $recetteIngredientBasiqueDAO->create($recetteIngredientBasique);
                }
                // CAS - Ingrédient optionnel
                else {
                    // Récupération du prix
                    // Vérification valeur présente
                    if (empty($ingredient['prix'])) {
                        continue;
                    }
                    $ingredientPrix = $ingredient['prix'];

                    // Création de l'ingrédient
                    $recetteIngredientOptionnel = new RecetteIngredientOptionnel();
                    $recetteIngredientOptionnel->setOrdre($i + 1);
                    $recetteIngredientOptionnel->setQuantite($ingredientQuantite);
                    $recetteIngredientOptionnel->setPrix($ingredientPrix);
                    $recetteIngredientOptionnel->setIdRecette($recetteId);
                    $recetteIngredientOptionnel->setIdIngredient($ingredientId);

                    // Enregistrement de l'ingrédient
                    $recetteIngredientOptionnelDAO->create($recetteIngredientOptionnel);
                }
            }
            // CAS - Sélection multiple
            elseif (isset($ingredient['ingredients'])) {
                // Récupération des paramètres
                // Vérification valeurs présentes
                if (!isset($ingredient['quantite']) || !isset($ingredient['ingredients'])) {
                    continue;
                }
                $selectionMultipleQuantite = $ingredient['quantite'];
                $selectionMultipleIngredients = $ingredient['ingredients'];

                // Création de la sélection multiple
                $recetteSelectionMultiple = new RecetteSelectionMultiple();
                $recetteSelectionMultiple->setOrdre($i + 1);
                $recetteSelectionMultiple->setQuantite($selectionMultipleQuantite);
                $recetteSelectionMultiple->setIdRecette($recetteId);

                // Enregistrement de la sélection multiple
                $recetteSelectionMultipleDAO->create($recetteSelectionMultiple);

                // Récupération de l'id de la sélection multiple
                $selectionMultipleId = $recetteSelectionMultiple->getId();

                // Enregistrement des ingrédients de la sélection multiple
                foreach ($selectionMultipleIngredients as $selectionMultipleIngredient) {
                    // Récupération des paramètres
                    // Vérification valeurs présentes
                    if (!isset($selectionMultipleIngredient['id']) || !isset($selectionMultipleIngredient['quantite'])) {
                        continue;
                    }
                    $selectionMultipleIngredientId = $selectionMultipleIngredient['id'];
                    $selectionMultipleIngredientQuantite = $selectionMultipleIngredient['quantite'];

                    // Création de l'ingrédient de la sélection multiple
                    $ingredientRecetteSelectionMultiple = new IngredientRecetteSelectionMultiple();
                    $ingredientRecetteSelectionMultiple->setQuantite($selectionMultipleIngredientQuantite);
                    $ingredientRecetteSelectionMultiple->setIdSelectionMultipleRecette($selectionMultipleId);
                    $ingredientRecetteSelectionMultiple->setIdIngredient($selectionMultipleIngredientId);

                    // Enregistrement de l'ingrédient de la sélection multiple
                    $ingredientRecetteSelectionMultipleDAO->create($ingredientRecetteSelectionMultiple);
                }
            }
        }

        // Formatage du json
        $json['success'] = true;
        $json['id'] = $recetteId;

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }
}
