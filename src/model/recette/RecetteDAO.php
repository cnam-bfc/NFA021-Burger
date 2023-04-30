<?php

/**
 * DAO Recette
 */
class RecetteDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Recette $recette (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($recette)
    {
        // Vérification que l'objet n'a pas d'id
        if ($recette->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette (
                                                nom,
                                                description,
                                                prix,
                                                date_archive
                                                ) VALUES (
                                                :nom,
                                                :description,
                                                :prix,
                                                :date_archive
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $recette->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':description', $recette->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(':prix', $recette->getPrix(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $recette->getDateArchive(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $recette->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Recette $recette (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($recette)
    {
        // Vérification que l'objet a un id
        if ($recette->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $recette->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Recette $recette (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($recette)
    {
        // Vérification que l'objet a un id
        if ($recette->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette SET nom = :nom,
                                            description = :description,
                                            prix = :prix,
                                            date_archive = :date_archive
                                            WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $recette->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':description', $recette->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(':prix', $recette->getPrix(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $recette->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_recette', $recette->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Recette[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();
            $recette->setId($row['id_recette']);
            $recette->setNom($row['nom']);
            $recette->setDescription($row['description']);
            $recette->setPrix($row['prix']);
            $recette->setDateArchive($row['date_archive']);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }

        return $recettes;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Recette|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $recette = new Recette();
        $recette->setId($result['id_recette']);
        $recette->setNom($result['nom']);
        $recette->setDescription($result['description']);
        $recette->setPrix($result['prix']);
        $recette->setDateArchive($result['date_archive']);

        return $recette;
    }

    /**
     * Méthode permettant de récupérer les 3 recettes les plus vendus au cours de la dernière semaine
     * 
     * @return Recette[] (tableau d'objets)
     */
    public function selectTop3Recette()
    {
        // Requête
        $sqlQuery = "SELECT * 
                    FROM burger_recette AS br
                    LEFT JOIN burger_recette_finale AS brf ON br.id_recette = brf.id_recette_fk
                    LEFT JOIN burger_commande_client AS bcc ON brf.id_commande_fk = bcc.id_commande
                    WHERE date_commande BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()
                    GROUP BY id_recette 
                    ORDER BY COUNT(id_recette) 
                    DESC LIMIT 3";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() < 3) {
            return null;
        }

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();
            $recette->setId($row['id_recette']);
            $recette->setNom($row['nom']);
            $recette->setDescription($row['description']);
            $recette->setPrix($row['prix']);
            $recette->setDateArchive($row['date_archive']);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }

        return $recettes;
    }

    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();
            $recette->setId($row['id_recette']);
            $recette->setNom($row['nom']);
            $recette->setDescription($row['description']);
            $recette->setPrix($row['prix']);
            $recette->setDateArchive($row['date_archive']);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }

        return $recettes;
    }
}
