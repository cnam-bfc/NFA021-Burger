<?php

/**
 * DAO Ingredient
 */
class IngredientDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Ingredient $ingredient (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($ingredient)
    {
        // Vérification que l'objet n'a pas d'id
        if ($ingredient->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_ingredient (
                                                nom,
                                                afficher_vue_eclatee,
                                                quantite_stock,
                                                stock_auto,
                                                stock_auto_quantite_standard,
                                                stock_auto_quantite_minimum,
                                                prix_fournisseur,
                                                date_inventaire,
                                                date_archive,
                                                id_unite_fk,
                                                id_fournisseur_fk
                                                ) VALUES (
                                                :nom,
                                                :afficher_vue_eclatee,
                                                :quantite_stock,
                                                :stock_auto,
                                                :stock_auto_quantite_standard,
                                                :stock_auto_quantite_minimum,
                                                :prix_fournisseur,
                                                :date_inventaire,
                                                :date_archive,
                                                :id_unite_fk,
                                                :id_fournisseur_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $ingredient->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':afficher_vue_eclatee', $ingredient->isAfficherVueEclatee(), PDO::PARAM_BOOL);
        $statement->bindValue(':quantite_stock', $ingredient->getQuantiteStock(), PDO::PARAM_INT);
        $statement->bindValue(':stock_auto', $ingredient->isStockAuto(), PDO::PARAM_BOOL);
        $statement->bindValue(':stock_auto_quantite_standard', $ingredient->getQuantiteStandardStockAuto(), PDO::PARAM_INT);
        $statement->bindValue(':stock_auto_quantite_minimum', $ingredient->getQuantiteMinimaleStockAuto(), PDO::PARAM_INT);
        $statement->bindValue(':prix_fournisseur', $ingredient->getPrixFournisseur(), PDO::PARAM_STR);
        $statement->bindValue(':date_inventaire', $ingredient->getDateDernierInventaire(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $ingredient->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_unite_fk', $ingredient->getIdUnite(), PDO::PARAM_INT);
        $statement->bindValue(':id_fournisseur_fk', $ingredient->getIdFournisseur(), PDO::PARAM_INT);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $ingredient->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Ingredient $ingredient (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($ingredient)
    {
        // Vérification que l'objet a un id
        if ($ingredient->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_ingredient WHERE id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient', $ingredient->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Ingredient $ingredient (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($ingredient)
    {
        // Vérification que l'objet a un id
        if ($ingredient->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_ingredient SET nom = :nom,
                                            afficher_vue_eclatee = :afficher_vue_eclatee,
                                            quantite_stock = :quantite_stock,
                                            stock_auto = :stock_auto,
                                            stock_auto_quantite_standard = :stock_auto_quantite_standard,
                                            stock_auto_quantite_minimum = :stock_auto_quantite_minimum,
                                            prix_fournisseur = :prix_fournisseur,
                                            date_inventaire = :date_inventaire,
                                            date_archive = :date_archive,
                                            id_unite_fk = :id_unite_fk,
                                            id_fournisseur_fk = :id_fournisseur_fk
                                            WHERE id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $ingredient->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':afficher_vue_eclatee', $ingredient->isAfficherVueEclatee(), PDO::PARAM_BOOL);
        $statement->bindValue(':quantite_stock', $ingredient->getQuantiteStock(), PDO::PARAM_INT);
        $statement->bindValue(':stock_auto', $ingredient->isStockAuto(), PDO::PARAM_BOOL);
        $statement->bindValue(':stock_auto_quantite_standard', $ingredient->getQuantiteStandardStockAuto(), PDO::PARAM_INT);
        $statement->bindValue(':stock_auto_quantite_minimum', $ingredient->getQuantiteMinimaleStockAuto(), PDO::PARAM_INT);
        $statement->bindValue(':prix_fournisseur', $ingredient->getPrixFournisseur(), PDO::PARAM_STR);
        $statement->bindValue(':date_inventaire', $ingredient->getDateDernierInventaire(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $ingredient->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_unite_fk', $ingredient->getIdUnite(), PDO::PARAM_INT);
        $statement->bindValue(':id_fournisseur_fk', $ingredient->getIdFournisseur(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredient->getId(), PDO::PARAM_INT);
        $statement->execute();

        //On vérifie après la mise à jour si le stock n'est pas passé en-dessous du stock mini
        if($ingredient->isStockAuto() && $ingredient->getQuantiteStock() < $ingredient->getQuantiteMinimaleStockAuto()) {
            $daoBdc = new CommandeFournisseurDAO();

            $bdc = new CommandeFournisseur();
            $bdc->setCreationAutomatique(1);
            $bdc->setDateCreation(date('Y-m-d H:i:s'));
            $bdc->setIdFournisseur($ingredient->getIdFournisseur());

            $daoBdc->create($bdc);

            $daoIngredientBdc = new CommandeFournisseurIngredientDAO();

            $ingredientBdc = new CommandeFournisseurIngredient();
            $ingredientBdc->setIdCommandeFournisseur($bdc->getId());
            $ingredientBdc->setIdIngredient($ingredient->getId());
            $ingredientBdc->setQuantiteCommandee($ingredient->getQuantiteStandardStockAuto() - $ingredient->getQuantiteStock());

            $daoIngredientBdc->create($ingredientBdc);

        }
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Ingredient[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredient = new Ingredient();

            // Remplissage de l'objet
            $this->fillObject($ingredient, $row);

            // Ajout de l'objet dans le tableau
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Ingredient[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredient = new Ingredient();

            // Remplissage de l'objet
            $this->fillObject($ingredient, $row);

            // Ajout de l'objet dans le tableau
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Ingredient|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient WHERE id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $ingredient = new Ingredient();

        // Remplissage de l'objet
        $this->fillObject($ingredient, $result);

        return $ingredient;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Ingredient $ingredient (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($ingredient, $row)
    {
        $ingredient->setId($row['id_ingredient']);
        $ingredient->setNom($row['nom']);
        $ingredient->setAfficherVueEclatee($row['afficher_vue_eclatee']);
        $ingredient->setQuantiteStock($row['quantite_stock']);
        $ingredient->setStockAuto($row['stock_auto']);
        $ingredient->setQuantiteStandardStockAuto($row['stock_auto_quantite_standard']);
        $ingredient->setQuantiteMinimaleStockAuto($row['stock_auto_quantite_minimum']);
        $ingredient->setPrixFournisseur($row['prix_fournisseur']);
        $ingredient->setDateDernierInventaire($row['date_inventaire']);
        $ingredient->setDateArchive($row['date_archive']);
        $ingredient->setIdUnite($row['id_unite_fk']);
        $ingredient->setIdFournisseur($row['id_fournisseur_fk']);
    }

    /**
     * Méthode permettant de récupérer tous les IngredientCommandeFournisseur d'une commande en fonction de l'id de la commande
     * 
     * @param int $idCommande (id de la commande)
     * @return array (tableau d'objets)
     */
    public function selectByIdCommandeForStock($idCommande)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient 
        LEFT JOIN burger_unite ON burger_ingredient.id_unite_fk = burger_unite.id_unite
        LEFT JOIN burger_constituer ON burger_ingredient.id_ingredient = burger_constituer.id_ingredient_fk
        WHERE burger_constituer.id_commande = :id_commande";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande', $idCommande, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
