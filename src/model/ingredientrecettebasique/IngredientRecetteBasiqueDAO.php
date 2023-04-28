<?php

/**
 * DAO IngredientRecetteBasique
 */
class IngredientRecetteBasiqueDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param IngredientRecetteBasique $ingredientRecetteBasique (objet à créer)
     * @throws Exception (si l'objet ne possède pas les id nécessaire à sa création)
     */
    public function create(&$ingredientRecetteBasique)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($ingredientRecetteBasique->getIdRecette() === null || $ingredientRecetteBasique->getIdIngredient() === null) {
            throw new Exception("L'objet à créer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_ingredient_basique (
                                                id_recette,
                                                id_ingredient,
                                                quantite
                                                ) VALUES (
                                                :id_recette,
                                                :id_ingredient,
                                                :quantite
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $ingredientRecetteBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredientRecetteBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $ingredientRecetteBasique->getQuantite(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param IngredientRecetteBasique $ingredientRecetteBasique (objet à supprimer)
     * @throws Exception (si l'objet n'a pas les id nécessaire à sa suppression)
     */
    public function delete($ingredientRecetteBasique)
    {
        // Vérification que l'objet possède les id nécessaire à sa suppression
        if ($ingredientRecetteBasique->getIdRecette() === null || $ingredientRecetteBasique->getIdIngredient() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_ingredient_basique WHERE id_recette = :id_recette AND id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $ingredientRecetteBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredientRecetteBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer tous les objets d'une recette
     * 
     * @param int $idRecette (id de la recette des objets à supprimer)
     * @throws Exception (si l'id de la recette n'est pas renseigné)
     */
    public function deleteAllByIdRecette($idRecette)
    {
        // Vérification que l'id de la recette est renseigné
        if ($idRecette === null) {
            throw new Exception("L'id de la recette doit être renseigné");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_ingredient_basique WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $idRecette, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param IngredientRecetteBasique $ingredientRecetteBasique (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas les id nécessaire à sa mise à jour)
     */
    public function update($ingredientRecetteBasique)
    {
        // Vérification que l'objet possède les id nécessaire à sa mise à jour
        if ($ingredientRecetteBasique->getIdRecette() === null || $ingredientRecetteBasique->getIdIngredient() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "UPDATE burger_ingredient_basique SET quantite = :quantite WHERE id_recette = :id_recette AND id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $ingredientRecetteBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredientRecetteBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $ingredientRecetteBasique->getQuantite(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return IngredientRecetteBasique[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_basique";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientRecetteBasiques = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientRecetteBasique = new IngredientRecetteBasique();
            $ingredientRecetteBasique->setIdRecette($row['id_recette']);
            $ingredientRecetteBasique->setIdIngredient($row['id_ingredient']);
            $ingredientRecetteBasique->setQuantite($row['quantite']);

            // Ajout de l'objet dans le tableau
            $ingredientRecetteBasiques[] = $ingredientRecetteBasique;
        }

        return $ingredientRecetteBasiques;
    }

    /**
     * Méthode permettant de récupérer tous les objets par id de recette
     * 
     * @param int $idRecette (id de la recette des objets à récupérer)
     * @return IngredientRecetteBasique[] (tableau d'objets)
     */
    public function selectAllByIdRecette($idRecette)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_basique WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $idRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientRecetteBasiques = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientRecetteBasique = new IngredientRecetteBasique();
            $ingredientRecetteBasique->setIdRecette($row['id_recette']);
            $ingredientRecetteBasique->setIdIngredient($row['id_ingredient']);
            $ingredientRecetteBasique->setQuantite($row['quantite']);

            // Ajout de l'objet dans le tableau
            $ingredientRecetteBasiques[] = $ingredientRecetteBasique;
        }

        return $ingredientRecetteBasiques;
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
     * Méthode permettant de récupérer un objet par son id de recette et son id d'ingredient
     * 
     * @param int $idRecette (id de la recette de l'objet à récupérer)
     * @param int $idIngredient (id de l'ingredient de l'objet à récupérer)
     * @return IngredientRecetteBasique (objet récupéré)
     */
    public function selectByIdRecetteAndIdIngredient($idRecette, $idIngredient)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_basique WHERE id_recette = :id_recette AND id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $idRecette, PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $idIngredient, PDO::PARAM_INT);
        $statement->execute();

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $ingredientRecetteBasique = new IngredientRecetteBasique();
        $ingredientRecetteBasique->setIdRecette($result['id_recette']);
        $ingredientRecetteBasique->setIdIngredient($result['id_ingredient']);
        $ingredientRecetteBasique->setQuantite($result['quantite']);

        return $ingredientRecetteBasique;
    }
}
