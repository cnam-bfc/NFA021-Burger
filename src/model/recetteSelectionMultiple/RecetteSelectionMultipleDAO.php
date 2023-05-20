<?php

/**
 * DAO RecetteSelectionMultiple
 */
class RecetteSelectionMultipleDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param RecetteSelectionMultiple $recetteSelectionMultiple (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($recetteSelectionMultiple)
    {
        // Vérification que l'objet n'a pas d'id
        if ($recetteSelectionMultiple->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette_selection_multiple (
                                                ordre,
                                                quantite,
                                                id_recette_fk
                                                ) VALUES (
                                                :ordre,
                                                :quantite,
                                                :id_recette_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':ordre', $recetteSelectionMultiple->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteSelectionMultiple->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteSelectionMultiple->getIdRecette(), PDO::PARAM_INT);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $recetteSelectionMultiple->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param RecetteSelectionMultiple $recetteSelectionMultiple (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($recetteSelectionMultiple)
    {
        // Vérification que l'objet a un id
        if ($recetteSelectionMultiple->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette_selection_multiple WHERE id_recette_selection_multiple = :id_recette_selection_multiple";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_selection_multiple', $recetteSelectionMultiple->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param RecetteSelectionMultiple $recetteSelectionMultiple (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($recetteSelectionMultiple)
    {
        // Vérification que l'objet a un id
        if ($recetteSelectionMultiple->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette_selection_multiple SET ordre = :ordre,
                                            quantite = :quantite,
                                            id_recette_fk = :id_recette_fk
                                            WHERE id_recette_selection_multiple = :id_recette_selection_multiple";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':ordre', $recetteSelectionMultiple->getOrdre(), PDO::PARAM_INT);
        $statement->bindValue(':quantite', $recetteSelectionMultiple->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteSelectionMultiple->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_selection_multiple', $recetteSelectionMultiple->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return RecetteSelectionMultiple[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_selection_multiple";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesSelectionsMultiples = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteSelectionMultiple = new RecetteSelectionMultiple();

            // Remplissage de l'objet
            $this->fillObject($recetteSelectionMultiple, $row);

            // Ajout de l'objet dans le tableau
            $recettesSelectionsMultiples[] = $recetteSelectionMultiple;
        }

        return $recettesSelectionsMultiples;
    }

    /**
     * Méthode permettant de récupérer tous les objets d'une recette
     * 
     * @param int $idRecette (id de la recette)
     * @return RecetteSelectionMultiple[] (tableau d'objets)
     */
    public function selectAllByIdRecette($idRecette)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_selection_multiple WHERE id_recette_fk = :id_recette_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesSelectionsMultiples = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteSelectionMultiple = new RecetteSelectionMultiple();

            // Remplissage de l'objet
            $this->fillObject($recetteSelectionMultiple, $row);

            // Ajout de l'objet dans le tableau
            $recettesSelectionsMultiples[] = $recetteSelectionMultiple;
        }

        return $recettesSelectionsMultiples;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return RecetteSelectionMultiple|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_selection_multiple WHERE id_recette_selection_multiple = :id_recette_selection_multiple";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_selection_multiple', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $recetteSelectionMultiple = new RecetteSelectionMultiple();

        // Remplissage de l'objet
        $this->fillObject($recetteSelectionMultiple, $result);

        return $recetteSelectionMultiple;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param RecetteSelectionMultiple $recetteSelectionMultiple (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($recetteSelectionMultiple, $row)
    {
        $recetteSelectionMultiple->setId($row['id_recette_selection_multiple']);
        $recetteSelectionMultiple->setOrdre($row['ordre']);
        $recetteSelectionMultiple->setQuantite($row['quantite']);
        $recetteSelectionMultiple->setIdRecette($row['id_recette_fk']);
    }
}
