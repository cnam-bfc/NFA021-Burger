<?php

/**
 * DAO Emballage
 */
class EmballageDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Emballage $emballage (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($emballage)
    {
        // Vérification que l'objet n'a pas d'id
        if ($emballage->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_emballage (
                                                nom,
                                                date_archive
                                                ) VALUES (
                                                :nom,
                                                :date_archive
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $emballage->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $emballage->getDateArchive(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $emballage->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Emballage $emballage (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($emballage)
    {
        // Vérification que l'objet a un id
        if ($emballage->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_emballage WHERE id_emballage = :id_emballage";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_emballage', $emballage->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Emballage $emballage (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($emballage)
    {
        // Vérification que l'objet a un id
        if ($emballage->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_emballage SET nom = :nom,
                                            date_archive = :date_archive
                                            WHERE id_emballage = :id_emballage";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $emballage->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $emballage->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_emballage', $emballage->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Emballage[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_emballage";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $emballages = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $emballage = new Emballage();

            // Remplissage de l'objet
            $this->fillObject($emballage, $row);

            // Ajout de l'objet dans le tableau
            $emballages[] = $emballage;
        }

        return $emballages;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Emballage[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_emballage WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $emballages = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $emballage = new Emballage();

            // Remplissage de l'objet
            $this->fillObject($emballage, $row);

            // Ajout de l'objet dans le tableau
            $emballages[] = $emballage;
        }

        return $emballages;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Emballage|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_emballage WHERE id_emballage = :id_emballage";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_emballage', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $emballage = new Emballage();

        // Remplissage de l'objet
        $this->fillObject($emballage, $result);

        return $emballage;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Emballage $emballage (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($emballage, $row)
    {
        $emballage->setId($row['id_emballage']);
        $emballage->setNom($row['nom']);
        $emballage->setDateArchive($row['date_archive']);
    }
}
