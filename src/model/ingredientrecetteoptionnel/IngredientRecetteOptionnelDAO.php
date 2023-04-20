<?php

/**
 * DAO IngredientRecetteOptionnel
 */
class IngredientRecetteOptionnelDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param IngredientRecetteOptionnel $ingredientRecetteOptionnel (objet à créer)
     * @throws Exception (si l'objet ne possède pas les id nécessaire à sa création)
     */
    public function create(&$ingredientRecetteOptionnel)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($ingredientRecetteOptionnel->getIdRecette() === null || $ingredientRecetteOptionnel->getIdIngredient() === null) {
            throw new Exception("L'objet à créer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_ingredient_optionnel (
                                                id_recette,
                                                id_ingredient,
                                                quantite,
                                                prix
                                                ) VALUES (
                                                :id_recette,
                                                :id_ingredient,
                                                :quantite,
                                                :prix
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $ingredientRecetteOptionnel->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredientRecetteOptionnel->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $ingredientRecetteOptionnel->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':prix', $ingredientRecetteOptionnel->getPrix(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param IngredientRecetteOptionnel $ingredientRecetteOptionnel (objet à supprimer)
     * @throws Exception (si l'objet n'a pas les id nécessaire à sa suppression)
     */
    public function delete($ingredientRecetteOptionnel)
    {
        // Vérification que l'objet possède les id nécessaire à sa suppression
        if ($ingredientRecetteOptionnel->getIdRecette() === null || $ingredientRecetteOptionnel->getIdIngredient() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_ingredient_optionnel WHERE id_recette = :id_recette AND id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $ingredientRecetteOptionnel->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredientRecetteOptionnel->getIdIngredient(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param IngredientRecetteOptionnel $ingredientRecetteOptionnel (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas les id nécessaire à sa mise à jour)
     */
    public function update($ingredientRecetteOptionnel)
    {
        // Vérification que l'objet possède les id nécessaire à sa mise à jour
        if ($ingredientRecetteOptionnel->getIdRecette() === null || $ingredientRecetteOptionnel->getIdIngredient() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "UPDATE burger_ingredient_optionnel SET quantite = :quantite,
                                                            prix = :prix
                                                            WHERE id_recette = :id_recette AND id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $ingredientRecetteOptionnel->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $ingredientRecetteOptionnel->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $ingredientRecetteOptionnel->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':prix', $ingredientRecetteOptionnel->getPrix(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return IngredientRecetteOptionnel[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_optionnel";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientRecetteOptionnels = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientRecetteOptionnel = new IngredientRecetteOptionnel();
            $ingredientRecetteOptionnel->setIdRecette($row['id_recette']);
            $ingredientRecetteOptionnel->setIdIngredient($row['id_ingredient']);
            $ingredientRecetteOptionnel->setQuantite($row['quantite']);
            $ingredientRecetteOptionnel->setPrix($row['prix']);

            // Ajout de l'objet dans le tableau
            $ingredientRecetteOptionnels[] = $ingredientRecetteOptionnel;
        }

        return $ingredientRecetteOptionnels;
    }

    /**
     * Méthode permettant de récupérer tous les objets par id de recette
     * 
     * @param int $idRecette (id de la recette des objets à récupérer)
     * @return IngredientRecetteOptionnel[] (tableau d'objets)
     */
    public function selectAllByIdRecette($idRecette)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_optionnel WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $idRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientRecetteOptionnels = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientRecetteOptionnel = new IngredientRecetteOptionnel();
            $ingredientRecetteOptionnel->setIdRecette($row['id_recette']);
            $ingredientRecetteOptionnel->setIdIngredient($row['id_ingredient']);
            $ingredientRecetteOptionnel->setQuantite($row['quantite']);
            $ingredientRecetteOptionnel->setPrix($row['prix']);

            // Ajout de l'objet dans le tableau
            $ingredientRecetteOptionnels[] = $ingredientRecetteOptionnel;
        }

        return $ingredientRecetteOptionnels;
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
     * @return IngredientRecetteOptionnel (objet récupéré)
     */
    public function selectByIdRecetteAndIdIngredient($idRecette, $idIngredient)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_ingredient_optionnel WHERE id_recette = :id_recette AND id_ingredient = :id_ingredient";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $idRecette, PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient', $idIngredient, PDO::PARAM_INT);
        $statement->execute();

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $ingredientRecetteOptionnel = new IngredientRecetteOptionnel();
        $ingredientRecetteOptionnel->setIdRecette($result['id_recette']);
        $ingredientRecetteOptionnel->setIdIngredient($result['id_ingredient']);
        $ingredientRecetteOptionnel->setQuantite($result['quantite']);
        $ingredientRecetteOptionnel->setPrix($result['prix']);

        return $ingredientRecetteOptionnel;
    }
}
