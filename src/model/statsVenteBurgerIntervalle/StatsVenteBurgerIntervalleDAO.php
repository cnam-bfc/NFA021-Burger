<?php

/**
 * DAO StatsVenteBurgerIntervalleDAO
 */
class StatsVenteBurgerIntervalleDAO extends DAO
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
     * @return StatsVenteBurgerIntervalle[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Exception, méthode non développée
        throw new Exception("Méthode non développée");
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return StatsVenteBurgerIntervalle|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Exception, méthode non développée
        throw new Exception("Méthode non développée");
    }

    /**
     * Méthode permettant de récupérer un tableau d'objets en fonction de la date de début et de la date de fin (si elle est fournie)
     * 
     * EXEMPLE DE REQUEST Avec tous les paramètres :
     * SELECT br.id_recette, YEAR(bcc.date_commande) AS annee, MONTH(bcc.date_commande) AS mois, DAY(bcc.date_commande) AS jour br.nom, SUM(brf.quantite) AS qteTotal
     * FROM burger_recette AS br
     * INNER JOIN burger_recette_finale AS brf ON br.id_recette = brf.id_recette_fk
     * INNER JOIN burger_commande_client AS bcc ON brf.id_commande_client_fk = bcc.id_commande_client
     * WHERE bcc.date_commande BETWEEN '2023-01-01' AND '2023-12-31'
     * AND (bcc.date_archive IS NULL OR bcc.date_archive > NOW())
     * AND br.id_recette IN (2,3,4,5,6,7,8,9,10)
     * GROUP BY annee, mois, jour, br.id_recette
     * ORDER BY br.id_recette, annee, mois, jour;
     *
     * @param string[] $ids (tableau d'id)
     * @param int|null $intervalle (intervalle de temps)
     *  => 0 : Jour
     *  => 1 : Mois
     *  => 2 : Annee
     * @param string $dateDebut (date de début au format YYYY-MM-DD)
     * @param string $dateFin (date de fin au format YYYY-MM-DD)
     * @param int|null $archive (archive) 
     *  => -1 : Sans les recettes archivées
     *  => 0 : Toutes les recettes
     *  => 1 : Uniquement les recettes archivées
     * @return StatsVenteBurgerIntervalle[]|null (tableau d'objet ou null si aucun objet trouvé)
     */
    public function selectForStatisticsTemps($ids, $intervalle = 1, $dateDebut, $dateFin, $archive = 0)
    {
        // Requête
        // On prépare des morceaux de requête en fonction de l'intervalle
        $sqlQueryIntervalle = "";
        $sqlQueryIntervalle2 = "";
        if ($intervalle != 2) {
            $sqlQueryIntervalle = "MONTH(bcc.date_commande) AS mois, ";
            $sqlQueryIntervalle2 = ", mois";
            if ($intervalle == 0) {
                $sqlQueryIntervalle .= "DAY(bcc.date_commande) AS jour, ";
                $sqlQueryIntervalle2 .= ", jour";
            }
        }
        // On prépare le corps "fix" de la requête
        $sqlQuery = "   SELECT br.id_recette, br.nom, YEAR(bcc.date_commande) AS annee, " . $sqlQueryIntervalle . "SUM(brf.quantite) AS qteTotal
                        FROM burger_recette AS br
                        INNER JOIN burger_recette_finale AS brf ON br.id_recette = brf.id_recette_fk
                        INNER JOIN burger_commande_client AS bcc ON brf.id_commande_client_fk = bcc.id_commande_client";

        // On gère les dates
        $sqlQuery .= " WHERE bcc.date_commande BETWEEN :dateDebut AND :dateFin ";

        // On gère la date d'archivage
        if ($archive < 0) {
            $sqlQuery .= " AND (br.date_archive IS NULL OR br.date_archive > NOW())";
        } elseif ($archive > 0) {
            $sqlQuery .= " AND br.date_archive IS NOT NULL AND br.date_archive <= NOW()";
        }

        // On gère les id
        if (count($ids) > 0) {
            $sqlQuery .= " AND br.id_recette IN (";
            foreach ($ids as $id) {
                $sqlQuery .= ":id" . $id . ", ";
            }
            $sqlQuery = substr($sqlQuery, 0, -2);
            $sqlQuery .= ")";
        } else {
            throw new Exception("Aucun id fourni");
        }
        // On prépare la fin de la requête
        $sqlQuery .= "  GROUP BY br.id_recette, annee" . $sqlQueryIntervalle2 . "
                        ORDER BY br.id_recette, annee" . $sqlQueryIntervalle2 . ";";
        $statement = $this->pdo->prepare($sqlQuery);

        // On bind les dates
        $statement->bindValue(':dateDebut', $dateDebut, PDO::PARAM_STR);
        $statement->bindValue(':dateFin', $dateFin, PDO::PARAM_STR);
        

        // On bind les id
        foreach ($ids as $id) {
            $statement->bindValue(':id' . $id, $id, PDO::PARAM_INT);
        }

        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statsVenteBurgersIntervalle = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $statsVenteBurgerIntervalle = new StatsVenteBurgerIntervalle();

            // Remplissage de l'objet
            $this->fillObject($statsVenteBurgerIntervalle, $row);

            // Ajout de l'objet dans le tableau
            $statsVenteBurgersIntervalle[] = $statsVenteBurgerIntervalle;
        }
        return $statsVenteBurgersIntervalle;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param StatsVenteBurgerIntervalle $statsVenteBurgerIntervalle (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($statsVenteBurgerIntervalle, $row, $dateDebut = null, $dateFin = null)
    {
        $statsVenteBurgerIntervalle->setId($row['id_recette']);
        $statsVenteBurgerIntervalle->setNom($row['nom']);
        $statsVenteBurgerIntervalle->setQuantite($row['qteTotal']);
        $statsVenteBurgerIntervalle->setAnnee($row['annee']);
        if (isset($row['mois'])) {
            $statsVenteBurgerIntervalle->setMois($row['mois']);
        } else {
            $statsVenteBurgerIntervalle->setMois(null);
        }
        if (isset($row['jour'])) {
            $statsVenteBurgerIntervalle->setJour($row['jour']);
        } else {
            $statsVenteBurgerIntervalle->setJour(null);
        }
    }
}
