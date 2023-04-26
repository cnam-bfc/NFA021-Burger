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
    public function create(&$ingredient)
    {
        // Vérification que l'objet n'a pas d'id
        if ($ingredient->getIdIngredient() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_ingredient (
                                                nom_ingredient,
                                                quantite_stock_ingredient,
                                                photo_ingredient,
                                                photo_eclatee_ingredient,
                                                date_inventaire_ingredient,
                                                stock_auto_ingredient,
                                                quantite_standard,
                                                quantite_minimum,
                                                date_archive_ingredient,
                                                id_fournisseur_fk,
                                                id_unite_fk
                                                ) VALUES (
                                                :nom_ingredient,
                                                :quantite_stock_ingredient,
                                                :photo_ingredient,
                                                :photo_eclatee_ingredient,
                                                :date_inventaire_ingredient,
                                                :stock_auto_ingredient,
                                                :quantite_standard,
                                                :quantite_minimum,
                                                :date_archive_ingredient,
                                                :id_fournisseur_fk,
                                                :id_unite_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_ingredient', $ingredient->getNomIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':quantite_stock_ingredient', $ingredient->getQuantiteStockIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':photo_ingredient', $ingredient->getPhotoIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':photo_eclatee_ingredient', $ingredient->getPhotoEclateeIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':date_inventaire_ingredient', $ingredient->getDateInventaireIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':stock_auto_ingredient', $ingredient->getStockAutoIngredient(), PDO::PARAM_BOOL);
        $statement->bindValue(':quantite_standard', $ingredient->getQuantiteStandard(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_minimum', $ingredient->getQuantiteMinimum(), PDO::PARAM_INT);
        $statement->bindValue(':date_archive_ingredient', $ingredient->getDateArchiveIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':id_fournisseur_fk', $ingredient->getIdFournisseurFk(), PDO::PARAM_INT);
        $statement->bindValue(':id_unite_fk', $ingredient->getIdUniteFk(), PDO::PARAM_INT);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $ingredient->setIdIngredient($id);
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
        if ($ingredient->getIdIngredient() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_ingredient WHERE id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient', $ingredient->getIdIngredient(), PDO::PARAM_INT);
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
        if ($ingredient->getIdIngredient() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_ingredient SET nom_ingredient = :nom_ingredient,
                                            quantite_stock_ingredient = :quantite_stock_ingredient,
                                            photo_ingredient = :photo_ingredient,
                                            photo_eclatee_ingredient = :photo_eclatee_ingredient,
                                            date_inventaire_ingredient = :date_inventaire_ingredient,
                                            stock_auto_ingredient = :stock_auto_ingredient,
                                            quantite_standard = :quantite_standard,
                                            quantite_minimum = :quantite_minimum,
                                            date_archive_ingredient = :date_archive_ingredient,
                                            id_fournisseur_fk = :id_fournisseur_fk,
                                            id_unite_fk = :id_unite_fk
                                            WHERE id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_ingredient', $ingredient->getNomIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':quantite_stock_ingredient', $ingredient->getQuantiteStockIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':photo_ingredient', $ingredient->getPhotoIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':photo_eclatee_ingredient', $ingredient->getPhotoEclateeIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':date_inventaire_ingredient', $ingredient->getDateInventaireIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':stock_auto_ingredient', $ingredient->getStockAutoIngredient(), PDO::PARAM_BOOL);
        $statement->bindValue(':quantite_standard', $ingredient->getQuantiteStandard(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_minimum', $ingredient->getQuantiteMinimum(), PDO::PARAM_INT);
        $statement->bindValue(':date_archive_ingredient', $ingredient->getDateArchiveIngredient(), PDO::PARAM_STR);
        $statement->bindValue(':id_fournisseur_fk', $ingredient->getIdFournisseurFk(), PDO::PARAM_INT);
        $statement->bindValue(':id_unite_fk', $ingredient->getIdUniteFk(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->execute();
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
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredient = new Ingredient();
            $ingredient->setIdIngredient($row['id_ingredient']);
            $ingredient->setNomIngredient($row['nom_ingredient']);
            $ingredient->setQuantiteStockIngredient($row['quantite_stock_ingredient']);
            $ingredient->setPhotoIngredient($row['photo_ingredient']);
            $ingredient->setPhotoEclateeIngredient($row['photo_eclatee_ingredient']);
            $ingredient->setDateInventaireIngredient($row['date_inventaire_ingredient']);
            $ingredient->setStockAutoIngredient($row['stock_auto_ingredient']);
            $ingredient->setQuantiteStandard($row['quantite_standard']);
            $ingredient->setQuantiteMinimum($row['quantite_minimum']);
            $ingredient->setDateArchiveIngredient($row['date_archive_ingredient']);
            $ingredient->setIdFournisseurFk($row['id_fournisseur_fk']);
            $ingredient->setIdUniteFk($row['id_unite_fk']);

            // Ajout de l'objet dans le tableau
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    /**
     * Méthode permettant de récupérer les ingrédients nécessaire pour l'inventaire et également l'unité associée
     * 
     * Note : voir si on tri en SQL ou en PHP
     * Note 2 : pour le moment on renvoi un tableau et pas un objet, voir comment faire avec M. Martinez
     */
    public function selectAllForInventaire()
    {
        // Requête
        $sqlQuery = "SELECT id_ingredient, nom_ingredient, photo_ingredient, quantite_stock_ingredient, diminutif_unite 
        FROM `burger_ingredient`
        LEFT JOIN burger_unite ON burger_ingredient.id_unite_fk = burger_unite.id_unite
        WHERE date_archive_ingredient IS NULL ;";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
        $ingredient->setIdIngredient($result['id_ingredient']);
        $ingredient->setNomIngredient($result['nom_ingredient']);
        $ingredient->setQuantiteStockIngredient($result['quantite_stock_ingredient']);
        $ingredient->setPhotoIngredient($result['photo_ingredient']);
        $ingredient->setPhotoEclateeIngredient($result['photo_eclatee_ingredient']);
        $ingredient->setDateInventaireIngredient($result['date_inventaire_ingredient']);
        $ingredient->setStockAutoIngredient($result['stock_auto_ingredient']);
        $ingredient->setQuantiteStandard($result['quantite_standard']);
        $ingredient->setQuantiteMinimum($result['quantite_minimum']);
        $ingredient->setDateArchiveIngredient($result['date_archive_ingredient']);
        $ingredient->setIdFournisseurFk($result['id_fournisseur_fk']);
        $ingredient->setIdUniteFk($result['id_unite_fk']);

        return $ingredient;
    }

    /**
     * Méthode permettant de récupérer un objet par son nom
     * 
     * @param string $nom (nom de l'objet à récupérer)
     * @return Ingredient|null (objet ou null si aucun objet trouvé)
     */
    public function selectByName($nom)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient WHERE nom_ingredient = :nom_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_ingredient', $nom, PDO::PARAM_STR);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $ingredient = new Ingredient();
        $ingredient->setIdIngredient($result['id_ingredient']);
        $ingredient->setNomIngredient($result['nom_ingredient']);
        $ingredient->setQuantiteStockIngredient($result['quantite_stock_ingredient']);
        $ingredient->setPhotoIngredient($result['photo_ingredient']);
        $ingredient->setPhotoEclateeIngredient($result['photo_eclatee_ingredient']);
        $ingredient->setDateInventaireIngredient($result['date_inventaire_ingredient']);
        $ingredient->setStockAutoIngredient($result['stock_auto_ingredient']);
        $ingredient->setQuantiteStandard($result['quantite_standard']);
        $ingredient->setQuantiteMinimum($result['quantite_minimum']);
        $ingredient->setDateArchiveIngredient($result['date_archive_ingredient']);
        $ingredient->setIdFournisseurFk($result['id_fournisseur_fk']);
        $ingredient->setIdUniteFk($result['id_unite_fk']);

        return $ingredient;
    }


}
