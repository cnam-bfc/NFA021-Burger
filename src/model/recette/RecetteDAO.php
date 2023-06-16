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
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();

            // Remplissage de l'objet
            $this->fillObject($recette, $row);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }

        return $recettes;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Recette[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();

            // Remplissage de l'objet
            $this->fillObject($recette, $row);

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

        // Remplissage de l'objet
        $this->fillObject($recette, $result);

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
        $sqlQuery = "SELECT br.* 
                    FROM burger_recette AS br
                    LEFT JOIN burger_recette_finale AS brf ON br.id_recette = brf.id_recette_fk
                    LEFT JOIN burger_commande_client AS bcc ON brf.id_commande_client_fk = bcc.id_commande_client
                    WHERE date_commande BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()
                    AND br.date_archive IS NULL OR br.date_archive > NOW()
                    GROUP BY id_recette 
                    ORDER BY COUNT(id_recette) 
                    DESC LIMIT 3";
        $statement = $this->pdo->query($sqlQuery);
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

            // Remplissage de l'objet
            $this->fillObject($recette, $row);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }
        return $recettes;
    }

    /**
     * Méthode permettant de récupérer les recettes de façon personnalisée.
     * $archive : -1 => non archivé , 0 => tous, 1 => archivées
     * $order : -1 => ordre décroissant, 0 => pas d'ordre, 1 => ordre croissant
     *
     * @param integer $archive
     * @param integer $order
     * @return Recette[] (tableau d'objets)
     */
    public function selectAllForSelectStats($archive = 0, $order = 0)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette";
        // On ajoute la clause WHERE en fonction des paramètres
        if ($archive < 0) {
            $sqlQuery .= " WHERE date_archive IS NULL OR date_archive > NOW()";
        } elseif ($archive > 0) {
            $sqlQuery .= " WHERE date_archive IS NOT NULL AND date_archive <= NOW()";
        }
        // On ajoute la clause ORDER BY en fonction des paramètres
        if ($order > 0) {
            $sqlQuery .= " ORDER BY nom ASC";
        } elseif ($order < 0) {
            $sqlQuery .= " ORDER BY nom DESC";
        }

        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();

            // Remplissage de l'objet
            $this->fillObject($recette, $row);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }

        return $recettes;
    }

    /**
     * Méthodes pour récupérer les recettes les plus vendus sur une période donnée
     *
     * @param string $dateDebut
     * @param string $dateFin
     * @param array[$id] $burgers
     * @return Recette[] (tableau d'objets)
     */
    public function selectAllForStatsVenteBurgerTotal($dateDebut = null, $dateFin = null, $recettes = null)
    {
        // Requête
        $sqlQuery = "SELECT *
                    FROM burger_recette AS BR
                    LEFT JOIN burger_recette_finale AS BRF ON BR.id_recette = BRF.id_recette_fk
                    LEFT JOIN burger_commande_client AS BCC ON BRF.id_commande_client_fk = BCC.id_commande_client
                    WHERE BCC.date_archive IS NOT NULL
                    AND BCC.date_pret IS NOT NULL";
        if ($dateDebut !== null) {
            $sqlQuery .= " AND BCC.date_commande > :dateDebut";
        }
        if ($dateFin !== null) {
            $sqlQuery .= " AND BCC.date_commande < :dateFin";
        }
        if ($recettes !== null) {
            $sqlQuery .= " AND BR.id_recette IN (";
            foreach ($recettes as $key => $recette) {
                $sqlQuery .= ":id_recette_$key,";
            }
            $sqlQuery = substr($sqlQuery, 0, -1);
            $sqlQuery .= ")";
        }
        $sqlQuery .= " ORDER BY BR.nom ASC";
        $statement = $this->pdo->prepare($sqlQuery);
        if ($dateDebut !== null) {
            $statement->bindValue(':dateDebut', $dateDebut, PDO::PARAM_STR);
        }
        if ($dateFin !== null) {
            $statement->bindValue(':dateFin', $dateFin, PDO::PARAM_STR);
        }
        if ($recettes !== null) {
            foreach ($recettes as $key => $recette) {
                $statement->bindValue(":id_recette_$key", $recette, PDO::PARAM_INT);
            }
        }
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recette = new Recette();

            // Remplissage de l'objet
            $this->fillObject($recette, $row);

            // Ajout de l'objet dans le tableau
            $recettes[] = $recette;
        }
        return $recettes;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Recette $recette (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($recette, $row)
    {
        $recette->setId($row['id_recette']);
        $recette->setNom($row['nom']);
        $recette->setDescription($row['description']);
        $recette->setPrix($row['prix']);
        $recette->setDateArchive($row['date_archive']);
    }
}
