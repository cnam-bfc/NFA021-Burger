<?php

/**
 * DAO StatsVenteBurgerDAO
 */
class StatsVenteBurgerDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * Pas possible ici car pas de table dans la base de données
     * @throws Exception
     */
    public function create($notPossible)
    {
        // Pas possible ici car pas de table dans la base de données
        throw new Exception("Opération impossible");
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * Pas possible ici car pas de table dans la base de données
     * @throws Exception
     */
    public function delete($notPossible)
    {
        // Pas possible ici car pas de table dans la base de données
        throw new Exception("Opération impossible");
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * Pas possible ici car pas de table dans la base de données
     * @throws Exception 
     */
    public function update($notPossible)
    {
        // Pas possible ici car pas de table dans la base de données
        throw new Exception("Opération impossible");
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return StatsVenteBurger[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "   SELECT br.nom,  COUNT(brf.quantite) AS qteTotal
                        FROM burger_recette AS br, burger_recette_finale AS brf, burger_commande_client AS bcc
                        WHERE br.id_recette = brf.id_recette_fk
                        AND brf.id_commande_client_fk = bcc.id_commande_client
                        GROUP BY br.id_recette
                        ORDER BY qteTotal DESC;";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statsVenteBurgers = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $statsVenteBurger = new StatsVenteBurger();

            // Remplissage de l'objet
            $this->fillObject($statsVenteBurger, $row);

            // Ajout de l'objet dans le tableau
            $statsVenteBurgers[] = $statsVenteBurger;
        }

        return $statsVenteBurgers;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return StatsVenteBurger|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "   SELECT br.nom,  COUNT(brf.quantite) AS qteTotal
                        FROM burger_recette AS br, burger_recette_finale AS brf, burger_commande_client AS bcc
                        WHERE br.id_recette = brf.id_recette_fk
                        AND brf.id_commande_client_fk = bcc.id_commande_client
                        AND br.id_recette = :id
                        GROUP BY br.id_recette
                        ORDER BY qteTotal DESC;";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $statsVenteBurger = new StatsVenteBurger();

        // Remplissage de l'objet
        $this->fillObject($statsVenteBurger, $result);

        return $statsVenteBurger;
    }

    /**
     * Méthode permettant de récupérer un tableau d'objets en fonction de la date de début et de la date de fin (si elle est fournie)
     * 
     * EXEMPLE DE REQUEST Avec tous les paramètres :
     * SELECT br.nom,  COUNT(brf.quantite) AS qteTotal
     * FROM burger_recette AS br, burger_recette_finale AS brf, burger_commande_client AS bcc
     * WHERE br.id_recette = brf.id_recette_fk
     * AND brf.id_commande_client_fk = bcc.id_commande_client
     * AND br.id_recette IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
     * AND bcc.date_commande_client BETWEEN '2021-01-01' AND '2023-12-31'
     * AND (date_archive IS NULL OR date_archive > NOW())
     * GROUP BY br.id_recette
     * ORDER BY qteTotal DESC, br.nom ASC
     * LIMIT 10;
     *
     * @param string[]|null $ids (tableau d'id)
     * @param string|null $dateDebut (date de début au format YYYY-MM-DD)
     * @param string|null $dateFin (date de fin au format YYYY-MM-DD)
     * @param int|null $archive (archive) 
     *  => -1 : Sans les recettes archivées
     *  => 0 : Toutes les recettes
     *  => 1 : Uniquement les recettes archivées
     * @return StatsVenteBurger[]|null (tableau d'objet ou null si aucun objet trouvé)
     */
    public function selectForStatisticsTotal($ids = null, $dateDebut = null, $dateFin = null, $archive = 0)
    {
        // Requête
        $sqlQuery = "   SELECT br.id_recette ,br.nom,  COUNT(brf.quantite) AS qteTotal
                        FROM burger_recette AS br, burger_recette_finale AS brf, burger_commande_client AS bcc
                        WHERE br.id_recette = brf.id_recette_fk
                        AND brf.id_commande_client_fk = bcc.id_commande_client";
        if ($ids !== null && count($ids) > 0) {
            $sqlQuery .= " AND br.id_recette IN (";
            foreach ($ids as $id) {
                $sqlQuery .= ":id" . $id . ", ";
            }
            $sqlQuery = substr($sqlQuery, 0, -2);
            $sqlQuery .= ")";
        }
        if ($dateDebut !== null) {
            $sqlQuery .= " AND bcc.date_commande >= :dateDebut";
        }
        if ($dateFin !== null) {
            $sqlQuery .= " AND bcc.date_commande <= :dateFin";
        }
        if ($archive < 0) {
            $sqlQuery .= " AND (br.date_archive IS NULL OR br.date_archive > NOW())";
        } elseif ($archive > 0) {
            $sqlQuery .= " AND br.date_archive IS NOT NULL AND br.date_archive <= NOW()";
        }
        $sqlQuery .= "  GROUP BY br.id_recette
                        ORDER BY qteTotal DESC, br.nom ASC
                        LIMIT 10;";
        $statement = $this->pdo->prepare($sqlQuery);
        if ($ids !== null && count($ids) > 0) {
            foreach ($ids as $id) {
                $statement->bindValue(':id' . $id, $id, PDO::PARAM_INT);
            }
        }
        if ($dateDebut !== null) {
            $statement->bindValue(':dateDebut', $dateDebut, PDO::PARAM_STR);
        }
        if ($dateFin !== null) {
            $statement->bindValue(':dateFin', $dateFin, PDO::PARAM_STR);
        }
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statsVenteBurgers = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $statsVenteBurger = new StatsVenteBurger();

            // Remplissage de l'objet
            $this->fillObject($statsVenteBurger, $row, $dateDebut, $dateFin);

            // Ajout de l'objet dans le tableau
            $statsVenteBurgers[] = $statsVenteBurger;
        }

        return $statsVenteBurgers;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param StatsVenteBurger $statsVenteBurger (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($statsVenteBurger, $row, $dateDebut = null, $dateFin = null)
    {
        $statsVenteBurger->setId($row['id_recette']);
        $statsVenteBurger->setNom($row['nom']);
        $statsVenteBurger->setQuantite($row['qteTotal']);
        $statsVenteBurger->setDateDebut($dateDebut);
        $statsVenteBurger->setDateFin($dateFin);
    }
}
