<?php

class RecetteDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Recette $recette (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create(&$recette)
    {
        // Vérification que l'objet n'a pas d'id
        if ($recette->getIdRecette() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette (
                                                nom_recette, 
                                                photo_recette, 
                                                date_archive_recette, 
                                                prix_recette )
                                                VALUES (
                                                :nom_recette, 
                                                :photo_recette, 
                                                :date_archive_recette, 
                                                :prix_recette)";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_recette', $recette->getNomRecette(), PDO::PARAM_STR);
        $statement->bindValue(':photo_recette', $recette->getPhotoRecette(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive_recette', $recette->getDateArchiveRecette(), PDO::PARAM_STR);
        $statement->bindValue(':prix_recette', $recette->getPrixRecette(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $recette->setIdRecette($id);
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
        if ($recette->getIdRecette() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette', $recette->getIdRecette(), PDO::PARAM_INT);
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
        if ($recette->getIdRecette() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette SET nom_recette = :nom_recette, 
                                            photo_recette = :photo_recette, 
                                            date_archive_recette = :date_archive_recette, 
                                            prix_recette = :prix_recette
                                            WHERE id_recette = :id_recette";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_recette', $recette->getNomRecette(), PDO::PARAM_STR);
        $statement->bindValue(':photo_recette', $recette->getPhotoRecette(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive_recette', $recette->getDateArchiveRecette(), PDO::PARAM_STR);
        $statement->bindValue(':prix_recette', $recette->getPrixRecette(), PDO::PARAM_STR);
        $statement->bindValue(':id_recette', $recette->getIdRecette(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return array (tableau d'objets)
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
            $recette->setIdRecette($row['id_recette']);
            $recette->setNomRecette($row['nom_recette']);
            $recette->setPhotoRecette($row['photo_recette']);
            $recette->setDateArchiveRecette($row['date_archive_recette']);
            $recette->setPrixRecette($row['prix_recette']);

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
        $recette->setIdRecette($result['id_recette']);
        $recette->setNomRecette($result['nom_recette']);
        $recette->setPhotoRecette($result['photo_recette']);
        $recette->setDateArchiveRecette($result['date_archive_recette']);
        $recette->setPrixRecette($result['prix_recette']);

        return $recette;
    }

    /**
     * Méthode permettant de récupérer les 3 recettes les plus vendus au cours de la dernière semaine
     * 
     * @return array (tableau d'objets)
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
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();
            $recette->setIdRecette($row['id_recette']);
            $recette->setNomRecette($row['nom_recette']);
            $recette->setPhotoRecette($row['photo_recette']);
            $recette->setDateArchiveRecette($row['date_archive_recette']);
            $recette->setPrixRecette($row['prix_recette']);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }

        return $recettes;
    }
}
