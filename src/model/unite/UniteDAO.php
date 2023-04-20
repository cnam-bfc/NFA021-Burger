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
    public function create(&$unite)
    {
        // Vérification que l'objet n'a pas d'id
        if ($unite->getIdUnite() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_unite (
                                                nom_unite,
                                                diminutif_unite
                                                ) VALUES (
                                                :nom_unite,
                                                :diminutif_unite
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_unite', $unite->getNomUnite(), PDO::PARAM_STR);
        $statement->bindValue(':diminutif_unite', $unite->getDiminutifUnite(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $unite->setIdUnite($id);
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
        if ($unite->getIdUnite() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_unite WHERE id_unite = :id_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_unite', $unite->getIdUnite(), PDO::PARAM_INT);
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
        if ($unite->getIdUnite() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_unite SET nom_unite = :nom_unite,
                                            diminutif_unite = :diminutif_unite
                                            WHERE id_unite = :id_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_unite', $unite->getNomUnite(), PDO::PARAM_STR);
        $statement->bindValue(':diminutif_unite', $unite->getDiminutifUnite(), PDO::PARAM_STR);
        $statement->bindValue(':id_unite', $unite->getIdUnite(), PDO::PARAM_INT);
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
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $unites = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $unite = new Unite();
            $unite->setIdUnite($row['id_unite']);
            $unite->setNomUnite($row['nom_unite']);
            $unite->setDiminutifUnite($row['diminutif_unite']);

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
        $unite = new Unite();
        $unite->setIdUnite($result['id_unite']);
        $unite->setNomUnite($result['nom_unite']);
        $unite->setDiminutifUnite($result['diminutif_unite']);

        return $unite;
    }
}
