<?php

/**
 * DAO Fournisseur
 */
class FournisseurDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Fournisseur $fournisseur (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($fournisseur)
    {
        // Vérification que l'objet n'a pas d'id
        if ($fournisseur->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_fournisseur (
                                                nom,
                                                date_archive
                                                ) VALUES (
                                                :nom,
                                                :date_archive
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $fournisseur->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $fournisseur->getDateArchive(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $fournisseur->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Fournisseur $fournisseur (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($fournisseur)
    {
        // Vérification que l'objet a un id
        if ($fournisseur->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_fournisseur WHERE id_fournisseur = :id_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_fournisseur', $fournisseur->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Fournisseur $fournisseur (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($fournisseur)
    {
        // Vérification que l'objet a un id
        if ($fournisseur->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_fournisseur SET nom = :nom,
                                            date_archive = :date_archive
                                            WHERE id_fournisseur = :id_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $fournisseur->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $fournisseur->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_fournisseur', $fournisseur->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Fournisseur[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_fournisseur";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $fournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $fournisseur = new Fournisseur();

            // Remplissage de l'objet
            $this->fillObject($fournisseur, $row);

            // Ajout de l'objet dans le tableau
            $fournisseurs[] = $fournisseur;
        }

        return $fournisseurs;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Fournisseur[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_fournisseur WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $fournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $fournisseur = new Fournisseur();

            // Remplissage de l'objet
            $this->fillObject($fournisseur, $row);

            // Ajout de l'objet dans le tableau
            $fournisseurs[] = $fournisseur;
        }

        return $fournisseurs;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Fournisseur|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_fournisseur WHERE id_fournisseur = :id_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_fournisseur', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $fournisseur = new Fournisseur();

        // Remplissage de l'objet
        $this->fillObject($fournisseur, $result);

        return $fournisseur;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Fournisseur $fournisseur (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($fournisseur, $row)
    {
        $fournisseur->setId($row['id_fournisseur']);
        $fournisseur->setNom($row['nom']);
        $fournisseur->setDateArchive($row['date_archive']);
    }
}
