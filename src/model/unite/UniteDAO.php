<?php

/**
 * DAO Unite
 */
class UniteDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Unite $unite (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($unite)
    {
        // Vérification que l'objet n'a pas d'id
        if ($unite->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_unite (
                                                nom,
                                                diminutif,
                                                date_archive
                                                ) VALUES (
                                                :nom,
                                                :diminutif,
                                                :date_archive
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $unite->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':diminutif', $unite->getDiminutif(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $unite->getDateArchive(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $unite->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Unite $unite (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($unite)
    {
        // Vérification que l'objet a un id
        if ($unite->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_unite WHERE id_unite = :id_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_unite', $unite->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Unite $unite (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($unite)
    {
        // Vérification que l'objet a un id
        if ($unite->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_unite SET nom = :nom,
                                            diminutif = :diminutif,
                                            date_archive = :date_archive
                                            WHERE id_unite = :id_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $unite->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':diminutif', $unite->getDiminutif(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $unite->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_unite', $unite->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Unite[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_unite";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $unites = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $unite = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $unites[] = $unite;
        }

        return $unites;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Unite[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_unite WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $unites = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $unite = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $unites[] = $unite;
        }

        return $unites;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Unite|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_unite WHERE id_unite = :id_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_unite', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $unite = $this->convertTableRowToObject($result);

        return $unite;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau
     * 
     * @param array $row (tableau contenant les données)
     * @return Unite
     */
    protected function convertTableRowToObject($row)
    {
        // Création d'un nouvel objet
        $unite = new Unite();
        $unite->setId($row['id_unite']);
        $unite->setNom($row['nom']);
        $unite->setDiminutif($row['diminutif']);
        $unite->setDateArchive($row['date_archive']);

        return $unite;
    }
}
