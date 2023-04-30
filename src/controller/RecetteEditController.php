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
        $view->recetteImage = IMG . 'recettes' . DIRECTORY_SEPARATOR . $recette->getId()  . DIRECTORY_SEPARATOR . 'presentation.img';

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

            // Construction du json de l'ingrédient
            $jsonIngredient = array(
                'id' => $ingredient->getId(),
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

            // Construction du json de l'ingrédient
            $jsonIngredient = array(
                'id' => $ingredient->getId(),
                'nom' => $ingredient->getNom(),
                'quantite' => $recetteIngredientOptionnel->getQuantite(),
                'unite' => $unite->getDiminutif(),
                'optionnel' => true,
                'prix' => $recetteIngredientOptionnel->getPrix()
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

        // Enregistrement des ingrédients
        foreach ($ingredients as $ingredient) {
            // Récupération des paramètres
            $ingredientId = $ingredient['id_ingredient'];
            $ingredientQuantite = $ingredient['quantite_ingredient'];
            $ingredientOptionnel = $ingredient['optionnel_ingredient'];

            // CAS - Ingrédient basique
            if (!$ingredientOptionnel) {
                // Création de l'ingrédient
                $recetteIngredientBasique = new RecetteIngredientBasique();
                $recetteIngredientBasique->setIdRecette($recetteId);
                $recetteIngredientBasique->setIdIngredient($ingredientId);
                $recetteIngredientBasique->setQuantite($ingredientQuantite);

                // Enregistrement de l'ingrédient
                $recetteIngredientBasiqueDAO->create($recetteIngredientBasique);
            }
            // CAS - Ingrédient optionnel
            else {
                // Récupération du prix
                $ingredientPrix = $ingredient['prix_ingredient'];

                // Création de l'ingrédient
                $recetteIngredientOptionnel = new RecetteIngredientOptionnel();
                $recetteIngredientOptionnel->setIdRecette($recetteId);
                $recetteIngredientOptionnel->setIdIngredient($ingredientId);
                $recetteIngredientOptionnel->setQuantite($ingredientQuantite);
                $recetteIngredientOptionnel->setPrix($ingredientPrix);

                // Enregistrement de l'ingrédient
                $recetteIngredientOptionnelDAO->create($recetteIngredientOptionnel);
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
