<?php
class StockController extends Controller
{
    public function renderViewStock()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'StockView');
        $view->renderView();
    }

    /**
     * Fonction permettant de récupérer tous les bons de commandes
     *
     * @return void
     */
    public function getBonsCommandesAJAX()
    {
        // On récupère tous les bons de commandes
        $bdcDAO = new CommandeFournisseurDAO();
        $bonsCommande = $bdcDAO->selectAllNonArchive();

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($bonsCommande)) {
            foreach ($bonsCommande as $bonCommande) {
                $result[] = array(
                    "id_commande" => $bonCommande->getId(),
                    "date_commande" => $bonCommande->getDateCommande(),
                    "id_fournisseur_fk" => $bonCommande->getIdFournisseur()
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['date_commande'] <=> $b['date_commande'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    /**
     * Fonction qui permet de récupérer les fournisseurs
     *
     * @return void
     */
    public function getFournisseursAJAX()
    {
        // On récupère tous les fournisseurs
        $fournisseurDAO = new FournisseurDAO();
        $fournisseurs = $fournisseurDAO->selectAll();

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($fournisseurs)) {
            foreach ($fournisseurs as $fournisseur) {
                $result[] = array(
                    "id_fournisseur" => $fournisseur->getId(),
                    "nom_fournisseur" => $fournisseur->getNom()
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['nom_fournisseur'] <=> $b['nom_fournisseur'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    /**
     * Fonction permettant de récupérer tous les ingrédients et quantité lié à un bon de commande
     * 
     * @return void
     */
    public function refreshTableauIngredientsAJAX()
    {
        // On vérifie et on récupère les données du formulaire sous forme de json
        $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);

        // on récupère tous les ingrédients
        $IngredientDAO = new IngredientDAO();
        $ingredients = $IngredientDAO->selectByIdCommandeForStock($data);

        // On récupère les informations liées au bon de commande et on traite pour faire la liaison avec les ingrédients
        $commandeFournisseurIngredientDAO = new CommandeFournisseurIngredientDAO();
        $commandeFournisseurIngredients = $commandeFournisseurIngredientDAO->selectAllByIdCommandeFournisseur($data);
        $commandeFournisseurIngredientsFormat = array();
        foreach ($commandeFournisseurIngredients as $commandeFournisseurIngredient) {
            $commandeFournisseurIngredientsFormat[$commandeFournisseurIngredient->getIdIngredient()] = $commandeFournisseurIngredient->getQuantiteCommandee();
        }

        // on récupère toutes les unités et on traite pour faire la liaison avec les ingrédients
        $uniteDAO = new UniteDAO();
        $unites = $uniteDAO->selectAll();
        $uniteFormat = array();
        foreach ($unites as $unite) {
            $uniteFormat[$unite->getId()] = $unite->getDiminutif();
        }

        $result = array();
        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($ingredients)) {
            // on récupère les données pour la vue
            foreach ($ingredients as $ingredient) {
                $result[] = array(
                    "id" => $ingredient->getId(),
                    "photo" => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img',
                    "nom" => $ingredient->getNom(),
                    "quantite_attendu" => $commandeFournisseurIngredientsFormat[$ingredient->getId()],
                    "unite" => $uniteFormat[$ingredient->getIdUnite()]
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['nom'] <=> $b['nom'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    public function validationBonCommandeAJAX()
    {
        // On vérifie et on récupère les données du formulaire sous forme de json
        $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);

        // on déclare les DAO
        $ingredientDAO = new IngredientDAO();
        $commandeFournisseurDAO = new CommandeFournisseurDAO();
        $commandeFournisseurIngredientDAO = new CommandeFournisseurIngredientDAO();

        // on procède à une transaction pour être sur que tous les ingrédients sont bien mis à jour
        Database::getInstance()->getPDO()->beginTransaction();

        $dateActuelle = date("Y-m-d H:i:s");
        if ($data["id_bdc"] != -1) {
            // Mettre à jour les stocks
            foreach ($data["ingredients"] as $ingredient) {
                // On met la quantité reçu dans le bon de commande
                $commandeFournisseurIngrdedient = $commandeFournisseurIngredientDAO->selectByIdIngredientAndIdCommandeFournisseur($ingredient["id"], $data["id_bdc"]);
                if ($commandeFournisseurIngrdedient != null) {
                    $commandeFournisseurIngrdedient->setQuantiteRecue($ingredient["quantite_recu"]);
                    $commandeFournisseurIngredientDAO->update($commandeFournisseurIngrdedient);
                } else {
                    $commandeFournisseurIngredient = new CommandeFournisseurIngredient();
                    $commandeFournisseurIngredient->setIdCommandeFournisseur($data["id_bdc"]);
                    $commandeFournisseurIngredient->setIdIngredient($ingredient["id"]);
                    $commandeFournisseurIngredient->setQuantiteRecue($ingredient["quantite_recu"]);
                    $commandeFournisseurIngredient->setQuantiteCommandee(null);
                    $commandeFournisseurIngredientDAO->create($commandeFournisseurIngredient);
                }

                // on met à jour les stocks des ingrédients
                $ingredientAMettreAJour = $ingredientDAO->selectById($ingredient["id"]);
                $ingredientAMettreAJour->setQuantiteStock($ingredientAMettreAJour->getQuantiteStock() + $ingredient["quantite_recu"]);
                $ingredientDAO->update($ingredientAMettreAJour);

                // on récupère le bon de commande
                $commandeFournisseur = $commandeFournisseurDAO->selectById($data["id_bdc"]);
            }
        } else {
            // on crée un bon de commande
            $commandeFournisseur = new CommandeFournisseur();
            $commandeFournisseur->setCreationAutomatique(0);
            $commandeFournisseur->setDateCreation($dateActuelle);
            $commandeFournisseur->setDateCommande($dateActuelle);
            $commandeFournisseur->setIdFournisseur($data["id_fournisseur"]);
            $commandeFournisseurDAO->create($commandeFournisseur);

            // Mettre à jour les stocks
            foreach ($data["ingredients"] as $ingredient) {
                // On met la quantité reçu dans le bon de commande
                $commandeFournisseurIngredient = new CommandeFournisseurIngredient();
                $commandeFournisseurIngredient->setIdCommandeFournisseur($commandeFournisseur->getId());
                $commandeFournisseurIngredient->setIdIngredient($ingredient["id"]);
                $commandeFournisseurIngredient->setQuantiteRecue($ingredient["quantite_recu"]);
                $commandeFournisseurIngredient->setQuantiteCommandee(null);
                $commandeFournisseurIngredientDAO->create($commandeFournisseurIngredient);

                // on met à jour les stocks des ingrédients
                $ingredientAMettreAJour = $ingredientDAO->selectById($ingredient["id"]);
                $ingredientAMettreAJour->setQuantiteStock($ingredientAMettreAJour->getQuantiteStock() + $ingredient["quantite_recu"]);
                $ingredientDAO->update($ingredientAMettreAJour);
            }
        }
        // TODO : une fois que les États seront la il faudra le modifier
        $commandeFournisseur->setDateArchive($dateActuelle);
        $commandeFournisseurDAO->update($commandeFournisseur);

        // on valide la transaction
        $result = Database::getInstance()->getPDO()->commit();

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    public function refreshListeIngredients()
    {
        // On vérifie et on récupère les données du formulaire sous forme de json
        $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);

        // on récupère tous les ingrédients
        $ingredientDAO = new IngredientDAO();
        $ingredients = $ingredientDAO->selectAllWithoutIngredientsNonArchive($data);

        // on récupère toutes les unités
        $uniteDAO = new UniteDAO();
        $unites = $uniteDAO->selectAll();
        $uniteFormat = array();
        foreach ($unites as $unite) {
            $uniteFormat[$unite->getId()] = $unite->getDiminutif();
        }

        $result = array();
        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($ingredients)) {
            // on récupère les données pour la vue
            foreach ($ingredients as $ingredient) {
                $result[] = array(
                    "id" => $ingredient->getId(),
                    "photo" => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img',
                    "nom" => $ingredient->getNom(),
                    "unite" => $uniteFormat[$ingredient->getIdUnite()]
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['nom'] <=> $b['nom'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }
}
