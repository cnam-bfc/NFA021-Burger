<?php

/**
 * DAO StatsAchatFournisseurDAO
 */
class StatsAchatFournisseurDAO extends DAO
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
     * @return StatsAchatFournisseur[] (tableau d'objets)
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
     * @return StatsAchatFournisseur|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Exception, méthode non développée
        throw new Exception("Méthode non développée");
    }

    /**
     * Méthode permettant de récupérer un tableau d'objets en fonction de la date de début et de la date de fin (si elle est fournie)
     * 
     * Exemple de requête :
     * SELECT bf.nom,  COUNT(bcf.id_commande_fournisseur) AS qteTotal
     * FROM burger_fournisseur AS bf, burger_commande_fournisseur AS bcf
     * WHERE bf.id_fournisseur = bcf.id_fournisseur_fk
     * AND bf.id_fournisseur IN (1, 2, 3)
     * AND bcf.date_commande BETWEEN '2021-01-01' AND '2023-12-31'
     * AND (bf.date_archive IS NULL OR bf.date_archive > NOW())
     * AND (bcf.date_archive IS NULL OR bcf.date_archive > NOW())
     * GROUP BY bf.id_fournisseur
     * ORDER BY qteTotal DESC, bf.nom ASC
     * LIMIT 5;
     *
     * @param string[]|null $ids (tableau d'id)
     * @param string|null $dateDebut (date de début au format YYYY-MM-DD)
     * @param string|null $dateFin (date de fin au format YYYY-MM-DD)
     * @param int|null $archive (archive) 
     *  => -1 : Uniquement les fournisseurs non archivés
     *  => 0 : Tous les fournisseurs
     *  => 1 : Uniquement les fournisseurs archivés
     * @param int|null $archiveCommande (archive commande)
     * => -1 : Sans les commandes archivées
     * => 0 : Toutes les commandes
     * => 1 : Uniquement les commandes archivées LIVRÉES (important de noter que se sont les commandes livrés!)
     * @return StatsAchatFournisseur[]|null (tableau d'objet ou null si aucun objet trouvé)
     */
    public function selectForStatisticsTotal($ids = null, $dateDebut = null, $dateFin = null, $archive = 0, $archiveCommande = 0)
    {
        // Requête
        $sqlQuery = "SELECT bf.id_fournisseur, bf.nom,  COUNT(bcf.id_commande_fournisseur) AS qteTotal
                    FROM burger_fournisseur AS bf, burger_commande_fournisseur AS bcf
                    WHERE bf.id_fournisseur = bcf.id_fournisseur_fk";
        // les id des fournisseurs
        if ($ids !== null && count($ids) > 0) {
            $sqlQuery .= " AND bf.id_fournisseur IN (";
            foreach ($ids as $id) {
                $sqlQuery .= ":id" . $id . ", ";
            }
            $sqlQuery = substr($sqlQuery, 0, -2);
            $sqlQuery .= ")";
        }
        // les dates
        if ($dateDebut !== null) {
            $sqlQuery .= " AND bcf.date_commande >= :dateDebut";
        }
        if ($dateFin !== null) {
            $sqlQuery .= " AND bcf.date_commande <= :dateFin";
        }
        // Les archives
        if ($archive < 0) {
            $sqlQuery .= " AND (bf.date_archive IS NULL OR bf.date_archive > NOW())";
        } elseif ($archive > 0) {
            $sqlQuery .= " AND bf.date_archive IS NOT NULL AND bf.date_archive <= NOW()";
        }
        // Les archives des bons de commandes
        if ($archiveCommande < 0) {
            $sqlQuery .= " AND ((bcf.date_archive IS NULL OR bcf.date_archive > NOW()) AND (bcf.date_commande IS NOT NULL OR bcf.date_commande > NOW()))";
        } elseif ($archiveCommande > 0) {
            $sqlQuery .= " AND ((bcf.date_archive IS NOT NULL AND bcf.date_archive <= NOW()) AND (bcf.date_commande IS NOT NULL AND bcf.date_commande <= NOW()))";
        }
        $sqlQuery .= "  GROUP BY bf.id_fournisseur
                        ORDER BY qteTotal DESC, bf.nom ASC
                        LIMIT 5;";
        // Préparation de la requête
        $statement = $this->pdo->prepare($sqlQuery);
        // Les id des fournisseurs
        if ($ids !== null && count($ids) > 0) {
            foreach ($ids as $id) {
                $statement->bindValue(":id" . $id, $id, PDO::PARAM_INT);
            }
        }
        // Les dates
        if ($dateDebut !== null) {
            $statement->bindValue(":dateDebut", $dateDebut, PDO::PARAM_STR);
        }
        if ($dateFin !== null) {
            $statement->bindValue(":dateFin", $dateFin, PDO::PARAM_STR);
        }
        // Exécution de la requête
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statsAchatFournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $statsAchatFournisseur = new StatsAchatFournisseur();

            // Remplissage de l'objet
            $this->fillObject($statsAchatFournisseur, $row, $dateDebut, $dateFin);

            // Ajout de l'objet dans le tableau
            $statsAchatFournisseurs[] = $statsAchatFournisseur;
        }
        return $statsAchatFournisseurs;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param StatsAchatFournisseur $statsAchatFournisseur (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($statsAchatFournisseur, $row, $dateDebut = null, $dateFin = null)
    {
        $statsAchatFournisseur->setId($row['id_fournisseur']);
        $statsAchatFournisseur->setNom($row['nom']);
        $statsAchatFournisseur->setQuantite($row['qteTotal']);
    }
}
