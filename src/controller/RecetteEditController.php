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

        $view->recetteId = $recette->getIdRecette();
        $view->recetteNom = $recette->getNomRecette();
        $view->recetteDescription = $recette->getDescriptionRecette();
        $view->recettePrix = $recette->getPrixRecette();
        $view->recetteImage = $recette->getPhotoRecette();

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
        $ingredientRecetteBasiqueDAO = new IngredientRecetteBasiqueDAO();
        $ingredientRecetteOptionnelDAO = new IngredientRecetteOptionnelDAO();

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
        $ingredientRecetteBasiques = $ingredientRecetteBasiqueDAO->selectAllByIdRecette($recette->getIdRecette());

        // Récupération des ingrédients optionnels de la recette
        $ingredientRecetteOptionnels = $ingredientRecetteOptionnelDAO->selectAllByIdRecette($recette->getIdRecette());

        // Formatage des ingrédients basiques en json
        $jsonRecetteIngredientsBasique = array();
        foreach ($ingredientRecetteBasiques as $ingredientRecetteBasique) {
            // Récupération de l'ingrédient
            $ingredient = $ingredientDAO->selectById($ingredientRecetteBasique->getIdIngredient());

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
                'id' => $ingredient->getIdIngredient(),
                'nom' => $ingredient->getNomIngredient(),
                'quantite' => $ingredientRecetteBasique->getQuantite(),
                'unite' => $unite->getDiminutifUnite(),
                'optionnel' => false
            );

            $json['data'][] = $jsonIngredient;
        }

        // Formatage des ingrédients optionnels en json
        $jsonRecetteIngredientsOptionnel = array();
        foreach ($ingredientRecetteOptionnels as $ingredientRecetteOptionnel) {
            // Récupération de l'ingrédient
            $ingredient = $ingredientDAO->selectById($ingredientRecetteOptionnel->getIdIngredient());

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
                'id' => $ingredient->getIdIngredient(),
                'nom' => $ingredient->getNomIngredient(),
                'quantite' => $ingredientRecetteOptionnel->getQuantite(),
                'unite' => $unite->getDiminutifUnite(),
                'optionnel' => true,
                'prix' => $ingredientRecetteOptionnel->getPrix()
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
        $recetteId = Form::getParam('id', Form::METHOD_POST, Form::TYPE_INT, false);
        $recetteNom = Form::getParam('nom', Form::METHOD_POST, Form::TYPE_STRING);
        $recetteDescription = Form::getParam('description', Form::METHOD_POST, Form::TYPE_STRING);
        $recettePrix = Form::getParam('prix', Form::METHOD_POST, Form::TYPE_FLOAT);

        $json = array();

        // Initialisation des DAO
        $recetteDAO = new RecetteDAO();
        $ingredientRecetteBasiqueDAO = new IngredientRecetteBasiqueDAO();
        $ingredientRecetteOptionnelDAO = new IngredientRecetteOptionnelDAO();

        // CAS - Création d'une nouvelle recette
        if ($recetteId === null) {
            // Récupération de l'image de la recette
            $recetteImage = Form::getFile('image', true);

            // Création de la recette
            $recette = new Recette();
            $recette->setNomRecette($recetteNom);
            $recette->setDescriptionRecette($recetteDescription);
            $recette->setPrixRecette($recettePrix);

            // Enregistrement de la recette
            $recetteDAO->create($recette);

            $recetteId = $recette->getIdRecette();
        }
        // CAS - Modification d'une recette existante
        else {
            // Récupération de l'image de la recette
            $recetteImage = Form::getFile('image', false);

            // Récupération de la recette
            $recette = $recetteDAO->selectById($recetteId);

            // Si la recette n'existe pas, on affiche une erreur
            if ($recette === null) {
                ErrorController::error(404, "La recette n'existe pas.");
                return;
            }

            // Modification de la recette
            $recette->setNomRecette($recetteNom);
            $recette->setDescriptionRecette($recetteDescription);
            $recette->setPrixRecette($recettePrix);

            // Enregistrement de la recette
            $recetteDAO->update($recette);
        }

        // Si une image est présente, on l'enregistre dans le bon dossier
        if ($recetteImage !== null) {
            // Déplacement de l'image dans le dossier des images de recettes
            $recetteFolder = DATA_RECETTES . $recetteId . '/';
            if (!file_exists($recetteFolder)) {
                mkdir($recetteFolder, 0777, true);
            }
            $recetteImagePresentation = $recetteFolder . 'presentation.img';
            move_uploaded_file($recetteImage['tmp_name'], $recetteImagePresentation);
        }

        // Enregistrement des ingrédients basiques
        // TODO à faire

        // Enregistrement des ingrédients optionnels
        // TODO à faire

        // Formatage du json
        $json['success'] = true;
        $json['id'] = $recetteId;

        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }
}
