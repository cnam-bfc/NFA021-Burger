<?php

/**
 * DAO RecetteIngredientBasique
 */
class RecetteIngredientBasiqueDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param RecetteIngredientBasique $recetteIngredientBasique (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($recetteIngredientBasique)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($recetteIngredientBasique->getIdRecette() === null || $recetteIngredientBasique->getIdIngredient() === null) {
            throw new Exception("L'objet à créer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette_ingredient_basique (
                                                id_recette_fk,
                                                id_ingredient_fk,
                                                quantite,
                                                ordre
                                                ) VALUES (
                                                :id_recette_fk,
                                                :id_ingredient_fk,
                                                :quantite,
                                                :ordre
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $recetteIngredientBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteIngredientBasique->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':ordre', $recetteIngredientBasique->getOrdre(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param RecetteIngredientBasique $recetteIngredientBasique (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($recetteIngredientBasique)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($recetteIngredientBasique->getIdRecette() === null || $recetteIngredientBasique->getIdIngredient() === null) {
            throw new Exception("L'objet à créer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette_ingredient_basique WHERE id_recette_fk = :id_recette_fk AND id_ingredient_fk = :id_ingredient_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $recetteIngredientBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientBasique->getIdIngredient(), PDO::PARAM_INT);
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
        $sqlQuery = "DELETE FROM burger_recette_ingredient_basique WHERE id_recette_fk = :id_recette_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param RecetteIngredientBasique $recetteIngredientBasique (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($recetteIngredientBasique)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($recetteIngredientBasique->getIdRecette() === null || $recetteIngredientBasique->getIdIngredient() === null) {
            throw new Exception("L'objet à créer doit avoir un id de recette et un id d'ingredient");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette_ingredient_basique SET quantite = :quantite,
                                            ordre = :ordre
                                            WHERE id_recette_fk = :id_recette_fk AND id_ingredient_fk = :id_ingredient_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':quantite', $recetteIngredientBasique->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':ordre', $recetteIngredientBasique->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteIngredientBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return RecetteIngredientBasique[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_basique";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesIngredientsBasiques = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteIngredientBasique = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $recettesIngredientsBasiques[] = $recetteIngredientBasique;
        }

        return $recettesIngredientsBasiques;
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
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_basique WHERE id_recette_fk = :id_recette_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesIngredientsBasiques = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteIngredientBasique = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $recettesIngredientsBasiques[] = $recetteIngredientBasique;
        }

        return $recettesIngredientsBasiques;
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
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_basique WHERE id_recette_fk = :id_recette_fk AND id_ingredient_fk = :id_ingredient_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $idIngredient, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $recetteIngredientBasique = $this->convertTableRowToObject($row);

        return $recetteIngredientBasique;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau
     * 
     * @param array $row (tableau contenant les données)
     * @return RecetteIngredientBasique
     */
    protected function convertTableRowToObject($row)
    {
        // Création d'un nouvel objet
        $recetteIngredientBasique = new RecetteIngredientBasique();
        $recetteIngredientBasique->setIdRecette($row['id_recette_fk']);
        $recetteIngredientBasique->setIdIngredient($row['id_ingredient_fk']);
        $recetteIngredientBasique->setQuantite($row['quantite']);
        $recetteIngredientBasique->setOrdre($row['ordre']);

        return $recetteIngredientBasique;
    }
}
