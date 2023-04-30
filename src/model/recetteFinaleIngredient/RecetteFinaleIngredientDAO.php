<?php

/**
 * DAO RecetteFinaleIngredient
 */
class RecetteFinaleIngredientDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param RecetteFinaleIngredient $recetteFinaleIngredient (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($recetteFinaleIngredient)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($recetteFinaleIngredient->getIdIngredient() === null || $recetteFinaleIngredient->getIdRecetteFinale() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de recette finale");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette_finale_ingredient (
                                                id_ingredient_fk,
                                                id_recette_finale_fk,
                                                quantite
                                                ) VALUES (
                                                :id_ingredient_fk,
                                                :id_recette_finale_fk,
                                                :quantite
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $recetteFinaleIngredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_finale_fk', $recetteFinaleIngredient->getIdRecetteFinale(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteFinaleIngredient->getQuantite(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param RecetteFinaleIngredient $recetteFinaleIngredient (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($recetteFinaleIngredient)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($recetteFinaleIngredient->getIdIngredient() === null || $recetteFinaleIngredient->getIdRecetteFinale() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de recette finale");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette_finale_ingredient WHERE id_ingredient_fk = :id_ingredient_fk AND id_recette_finale_fk = :id_recette_finale_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $recetteFinaleIngredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_finale_fk', $recetteFinaleIngredient->getIdRecetteFinale(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param RecetteFinaleIngredient $recetteFinaleIngredient (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($recetteFinaleIngredient)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($recetteFinaleIngredient->getIdIngredient() === null || $recetteFinaleIngredient->getIdRecetteFinale() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de recette finale");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette_finale_ingredient SET quantite = :quantite
                                            WHERE id_ingredient_fk = :id_ingredient_fk AND id_recette_finale_fk = :id_recette_finale_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':quantite', $recetteFinaleIngredient->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $recetteFinaleIngredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_finale_fk', $recetteFinaleIngredient->getIdRecetteFinale(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return RecetteFinaleIngredient[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_finale_ingredient";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesFinalesIngredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteFinaleIngredient = new RecetteFinaleIngredient();

            // Remplissage de l'objet
            $this->fillObject($recetteFinaleIngredient, $row);

            // Ajout de l'objet dans le tableau
            $recettesFinalesIngredients[] = $recetteFinaleIngredient;
        }

        return $recettesFinalesIngredients;
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
        $sqlQuery = "SELECT * FROM burger_recette_finale_ingredient WHERE id_recette_finale_fk = :id_recette_finale_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_finale_fk', $idRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesFinalesIngredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteFinaleIngredient = new RecetteFinaleIngredient();

            // Remplissage de l'objet
            $this->fillObject($recetteFinaleIngredient, $row);

            // Ajout de l'objet dans le tableau
            $recettesFinalesIngredients[] = $recetteFinaleIngredient;
        }

        return $recettesFinalesIngredients;
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
     * Méthode permettant de récupérer un objet par son id d'ingredient et son id de recette finale
     * 
     * @param int $idIngredient (id de l'ingredient de l'objet à récupérer)
     * @param int $idRecetteFinale (id de la recette finale de l'objet à récupérer)
     * @return IngredientRecetteBasique (objet récupéré)
     */
    public function selectByIdIngredientAndIdRecetteFinale($idIngredient, $idRecetteFinale)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_finale_ingredient WHERE id_ingredient_fk = :id_ingredient_fk AND id_recette_finale_fk = :id_recette_finale_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $idIngredient, PDO::PARAM_INT);
        $statement->bindValue(':id_recette_finale_fk', $idRecetteFinale, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $recetteFinaleIngredient = new RecetteFinaleIngredient();

        // Remplissage de l'objet
        $this->fillObject($recetteFinaleIngredient, $row);

        return $recetteFinaleIngredient;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param RecetteFinaleIngredient $recetteFinaleIngredient (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($recetteFinaleIngredient, $row)
    {
        $recetteFinaleIngredient->setIdIngredient($row['id_ingredient_fk']);
        $recetteFinaleIngredient->setIdRecetteFinale($row['id_recette_finale_fk']);
        $recetteFinaleIngredient->setQuantite($row['quantite']);
    }
}
