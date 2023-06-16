<?php

/**
 * DAO MoyenTransport
 */
class MoyenTransportDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param MoyenTransport $moyenTransport (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($moyenTransport)
    {
        // Vérification que l'objet n'a pas d'id
        if ($moyenTransport->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_moyen_transport (
                                                nom,
                                                osrm_profile,
                                                routexl_type,
                                                date_archive
                                                ) VALUES (
                                                :nom,
                                                :osrm_profile,
                                                :routexl_type,
                                                :date_archive
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $moyenTransport->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':osrm_profile', $moyenTransport->getOsrmProfile(), PDO::PARAM_STR);
        $statement->bindValue(':routexl_type', $moyenTransport->getRouteXLType(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $moyenTransport->getDateArchive(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $moyenTransport->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param MoyenTransport $moyenTransport (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($moyenTransport)
    {
        // Vérification que l'objet a un id
        if ($moyenTransport->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_moyen_transport WHERE id_moyen_transport = :id_moyen_transport";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_moyen_transport', $moyenTransport->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param MoyenTransport $moyenTransport (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($moyenTransport)
    {
        // Vérification que l'objet a un id
        if ($moyenTransport->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_moyen_transport SET nom = :nom,
                                            osrm_profile = :osrm_profile,
                                            routexl_type = :routexl_type,
                                            date_archive = :date_archive
                                            WHERE id_moyen_transport = :id_moyen_transport";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $moyenTransport->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':osrm_profile', $moyenTransport->getOsrmProfile(), PDO::PARAM_STR);
        $statement->bindValue(':routexl_type', $moyenTransport->getRouteXLType(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $moyenTransport->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_moyen_transport', $moyenTransport->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return MoyenTransport[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_moyen_transport";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $moyensTransport = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $moyenTransport = new MoyenTransport();

            // Remplissage de l'objet
            $this->fillObject($moyenTransport, $row);

            // Ajout de l'objet dans le tableau
            $moyensTransport[] = $moyenTransport;
        }

        return $moyensTransport;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return MoyenTransport[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_moyen_transport WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $moyensTransport = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $moyenTransport = new MoyenTransport();

            // Remplissage de l'objet
            $this->fillObject($moyenTransport, $row);

            // Ajout de l'objet dans le tableau
            $moyensTransport[] = $moyenTransport;
        }

        return $moyensTransport;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return MoyenTransport|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_moyen_transport WHERE id_moyen_transport = :id_moyen_transport";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_moyen_transport', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $moyenTransport = new MoyenTransport();

        // Remplissage de l'objet
        $this->fillObject($moyenTransport, $result);

        return $moyenTransport;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param MoyenTransport $moyenTransport (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($moyenTransport, $row)
    {
        $moyenTransport->setId($row['id_moyen_transport']);
        $moyenTransport->setNom($row['nom']);
        $moyenTransport->setOsrmProfile($row['osrm_profile']);
        $moyenTransport->setRouteXLType($row['routexl_type']);
        $moyenTransport->setDateArchive($row['date_archive']);
    }
}
