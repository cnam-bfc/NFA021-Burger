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
        // Vérification que l'objet n'a pas d'id
        if ($recetteIngredientBasique->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette_ingredient_basique (
                                                ordre,
                                                quantite,
                                                id_ingredient_fk,
                                                id_recette_fk
                                                ) VALUES (
                                                :ordre,
                                                :quantite,
                                                :id_ingredient_fk,
                                                :id_recette_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':ordre', $recetteIngredientBasique->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteIngredientBasique->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteIngredientBasique->getIdRecette(), PDO::PARAM_INT);
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
        // Vérification que l'objet a un id
        if ($recetteIngredientBasique->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette_ingredient_basique WHERE id = :id";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id', $recetteIngredientBasique->getId(), PDO::PARAM_INT);
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
        // Vérification que l'objet a un id
        if ($recetteIngredientBasique->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette_ingredient_basique SET ordre = :ordre,
                                            quantite = :quantite,
                                            id_ingredient_fk = :id_ingredient_fk,
                                            id_recette_fk = :id_recette_fk
                                            WHERE id = :id";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':ordre', $recetteIngredientBasique->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteIngredientBasique->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientBasique->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteIngredientBasique->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id', $recetteIngredientBasique->getId(), PDO::PARAM_INT);
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
            $recetteIngredientBasique = new RecetteIngredientBasique();

            // Remplissage de l'objet
            $this->fillObject($recetteIngredientBasique, $row);

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
            $recetteIngredientBasique = new RecetteIngredientBasique();

            // Remplissage de l'objet
            $this->fillObject($recetteIngredientBasique, $row);

            // Ajout de l'objet dans le tableau
            $recettesIngredientsBasiques[] = $recetteIngredientBasique;
        }

        return $recettesIngredientsBasiques;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return IngredientRecetteBasique (objet récupéré)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_basique WHERE id = :id";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $recetteIngredientBasique = new RecetteIngredientBasique();
        $this->fillObject($recetteIngredientBasique, $row);

        return $recetteIngredientBasique;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param RecetteIngredientBasique $recetteIngredientBasique (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($recetteIngredientBasique, $row)
    {
        $recetteIngredientBasique->setId($row['id']);
        $recetteIngredientBasique->setOrdre($row['ordre']);
        $recetteIngredientBasique->setQuantite($row['quantite']);
        $recetteIngredientBasique->setIdIngredient($row['id_ingredient_fk']);
        $recetteIngredientBasique->setIdRecette($row['id_recette_fk']);
    }
}
