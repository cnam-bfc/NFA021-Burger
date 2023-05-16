<?php

/**
 * DAO RecetteIngredientOptionnel
 */
class RecetteIngredientOptionnelDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param RecetteIngredientOptionnel $recetteIngredientOptionnel (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($recetteIngredientOptionnel)
    {
        // Vérification que l'objet n'a pas d'id
        if ($recetteIngredientOptionnel->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette_ingredient_optionnel (
                                                ordre,
                                                quantite,
                                                prix,
                                                id_ingredient_fk,
                                                id_recette_fk
                                                ) VALUES (
                                                :ordre,
                                                :quantite,
                                                :prix,
                                                :id_ingredient_fk,
                                                :id_recette_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':ordre', $recetteIngredientOptionnel->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteIngredientOptionnel->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':prix', $recetteIngredientOptionnel->getPrix(), PDO::PARAM_STR);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientOptionnel->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteIngredientOptionnel->getIdRecette(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param RecetteIngredientOptionnel $recetteIngredientOptionnel (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($recetteIngredientOptionnel)
    {
        // Vérification que l'objet a un id
        if ($recetteIngredientOptionnel->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette_ingredient_optionnel WHERE id = :id";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id', $recetteIngredientOptionnel->getId(), PDO::PARAM_INT);
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
        $sqlQuery = "DELETE FROM burger_recette_ingredient_optionnel WHERE id_recette_fk = :id_recette_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param RecetteIngredientOptionnel $recetteIngredientOptionnel (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($recetteIngredientOptionnel)
    {
        // Vérification que l'objet a un id
        if ($recetteIngredientOptionnel->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette_ingredient_optionnel SET ordre = :ordre,
                                            quantite = :quantite,
                                            prix = :prix,
                                            id_ingredient_fk = :id_ingredient_fk,
                                            id_recette_fk = :id_recette_fk
                                            WHERE id = :id";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':ordre', $recetteIngredientOptionnel->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteIngredientOptionnel->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':prix', $recetteIngredientOptionnel->getPrix(), PDO::PARAM_STR);
        $statement->bindValue(':id_ingredient_fk', $recetteIngredientOptionnel->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteIngredientOptionnel->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id', $recetteIngredientOptionnel->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return RecetteIngredientOptionnel[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_optionnel";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesIngredientsOptionnels = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteIngredientOptionnel = new RecetteIngredientOptionnel();

            // Remplissage de l'objet
            $this->fillObject($recetteIngredientOptionnel, $row);

            // Ajout de l'objet dans le tableau
            $recettesIngredientsOptionnels[] = $recetteIngredientOptionnel;
        }

        return $recettesIngredientsOptionnels;
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
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_optionnel WHERE id_recette_fk = :id_recette_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesIngredientsOptionnels = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteIngredientOptionnel = new RecetteIngredientOptionnel();

            // Remplissage de l'objet
            $this->fillObject($recetteIngredientOptionnel, $row);

            // Ajout de l'objet dans le tableau
            $recettesIngredientsOptionnels[] = $recetteIngredientOptionnel;
        }

        return $recettesIngredientsOptionnels;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return IngredientRecetteOptionnel (objet récupéré)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_ingredient_optionnel WHERE id = :id";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $recetteIngredientOptionnel = new RecetteIngredientOptionnel();
        $this->fillObject($recetteIngredientOptionnel, $row);

        return $recetteIngredientOptionnel;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param RecetteIngredientOptionnel $recetteIngredientOptionnel (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($recetteIngredientOptionnel, $row)
    {
        $recetteIngredientOptionnel->setId($row['id']);
        $recetteIngredientOptionnel->setOrdre($row['ordre']);
        $recetteIngredientOptionnel->setQuantite($row['quantite']);
        $recetteIngredientOptionnel->setPrix($row['prix']);
        $recetteIngredientOptionnel->setIdIngredient($row['id_ingredient_fk']);
        $recetteIngredientOptionnel->setIdRecette($row['id_recette_fk']);
    }
}
