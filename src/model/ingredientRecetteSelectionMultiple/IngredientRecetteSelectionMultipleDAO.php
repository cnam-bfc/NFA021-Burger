<?php

/**
 * DAO IngredientRecetteSelectionMultiple
 */
class IngredientRecetteSelectionMultipleDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param IngredientRecetteSelectionMultiple $ingredientRecetteSelectionMultiple (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($ingredientRecetteSelectionMultiple)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($ingredientRecetteSelectionMultiple->getIdIngredient() === null || $ingredientRecetteSelectionMultiple->getIdSelectionMultipleRecette() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de la selection multiple de la recette");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_ingredient_recette_selection_multiple (
                                                id_ingredient_fk,
                                                id_recette_selection_multiple_fk,
                                                quantite
                                                ) VALUES (
                                                :id_ingredient_fk,
                                                :id_recette_selection_multiple_fk,
                                                :quantite
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $ingredientRecetteSelectionMultiple->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_selection_multiple_fk', $ingredientRecetteSelectionMultiple->getIdSelectionMultipleRecette(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $ingredientRecetteSelectionMultiple->getQuantite(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param IngredientRecetteSelectionMultiple $ingredientRecetteSelectionMultiple (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($ingredientRecetteSelectionMultiple)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($ingredientRecetteSelectionMultiple->getIdIngredient() === null || $ingredientRecetteSelectionMultiple->getIdSelectionMultipleRecette() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de la selection multiple de la recette");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_ingredient_recette_selection_multiple WHERE id_ingredient_fk = :id_ingredient_fk AND id_recette_selection_multiple_fk = :id_recette_selection_multiple_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $ingredientRecetteSelectionMultiple->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_selection_multiple_fk', $ingredientRecetteSelectionMultiple->getIdSelectionMultipleRecette(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param IngredientRecetteSelectionMultiple $ingredientRecetteSelectionMultiple (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($ingredientRecetteSelectionMultiple)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($ingredientRecetteSelectionMultiple->getIdIngredient() === null || $ingredientRecetteSelectionMultiple->getIdSelectionMultipleRecette() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de la selection multiple de la recette");
        }

        // Requête
        $sqlQuery = "UPDATE burger_ingredient_recette_selection_multiple SET quantite = :quantite
                                            WHERE id_ingredient_fk = :id_ingredient_fk AND id_recette_selection_multiple_fk = :id_recette_selection_multiple_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':quantite', $ingredientRecetteSelectionMultiple->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $ingredientRecetteSelectionMultiple->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_selection_multiple_fk', $ingredientRecetteSelectionMultiple->getIdSelectionMultipleRecette(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return IngredientRecetteSelectionMultiple[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_recette_selection_multiple";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientsRecettesSelectionsMultiples = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientRecetteSelectionMultiple = new IngredientRecetteSelectionMultiple();

            // Remplissage de l'objet
            $this->fillObject($ingredientRecetteSelectionMultiple, $row);

            // Ajout de l'objet dans le tableau
            $ingredientsRecettesSelectionsMultiples[] = $ingredientRecetteSelectionMultiple;
        }

        return $ingredientsRecettesSelectionsMultiples;
    }

    /**
     * Méthode permettant de récupérer tous les objets par id de sélection multiple d'une recette
     * 
     * @param int $idSelectionMultipleRecette (id de la sélection multiple d'une recette)
     * @return IngredientRecetteBasique[] (tableau d'objets)
     */
    public function selectAllByIdSelectionMultipleRecette($idSelectionMultipleRecette)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_recette_selection_multiple WHERE id_recette_selection_multiple_fk = :id_recette_selection_multiple_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_selection_multiple_fk', $idSelectionMultipleRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientsRecetteSelectionMultiple = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientRecetteSelectionMultiple = new IngredientRecetteSelectionMultiple();

            // Remplissage de l'objet
            $this->fillObject($ingredientRecetteSelectionMultiple, $row);

            // Ajout de l'objet dans le tableau
            $ingredientsRecetteSelectionMultiple[] = $ingredientRecetteSelectionMultiple;
        }

        return $ingredientsRecetteSelectionMultiple;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @throws Exception (impossible de récupérer un objet par son id)
     */
    public function selectById($id)
    {
        throw new Exception("Impossible de récupérer un objet par son id");
    }

    /**
     * Méthode permettant de récupérer un objet par son id d'ingredient et son id de sélection multiple d'une recette
     * 
     * @param int $idIngredient (id de l'ingredient de l'objet à récupérer)
     * @param int $idSelectionMultipleRecette (id de la sélection multiple d'une recette de l'objet à récupérer)
     * @return IngredientRecetteBasique (objet récupéré)
     */
    public function selectByIdIngredientAndIdSelectionMultipleRecette($idIngredient, $idSelectionMultipleRecette)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_recette_selection_multiple WHERE id_ingredient_fk = :id_ingredient_fk AND id_recette_selection_multiple_fk = :id_recette_selection_multiple_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $idIngredient, PDO::PARAM_INT);
        $statement->bindValue(':id_recette_selection_multiple_fk', $idSelectionMultipleRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $ingredientRecetteSelectionMultiple = new IngredientRecetteSelectionMultiple();

        // Remplissage de l'objet
        $this->fillObject($ingredientRecetteSelectionMultiple, $row);

        return $ingredientRecetteSelectionMultiple;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param IngredientRecetteSelectionMultiple $ingredientRecetteSelectionMultiple (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($ingredientRecetteSelectionMultiple, $row)
    {
        $ingredientRecetteSelectionMultiple->setIdIngredient($row['id_ingredient_fk']);
        $ingredientRecetteSelectionMultiple->setIdSelectionMultipleRecette($row['id_recette_selection_multiple_fk']);
        $ingredientRecetteSelectionMultiple->setQuantite($row['quantite']);
    }
}
