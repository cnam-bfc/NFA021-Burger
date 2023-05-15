<?php

/**
 * DAO CommandeFournisseur
 */
class CommandeFournisseurDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param CommandeFournisseur $commandeFournisseur (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($commandeFournisseur)
    {
        // Vérification que l'objet n'a pas d'id
        if ($commandeFournisseur->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_commande_fournisseur (
                                                date_commande,
                                                date_archive,
                                                id_fournisseur_fk
                                                ) VALUES (
                                                :date_commande,
                                                :date_archive,
                                                :id_fournisseur_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':date_commande', $commandeFournisseur->getDateCommande(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $commandeFournisseur->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_fournisseur_fk', $commandeFournisseur->getIdFournisseur(), PDO::PARAM_INT);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $commandeFournisseur->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param CommandeFournisseur $commandeFournisseur (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($commandeFournisseur)
    {
        // Vérification que l'objet a un id
        if ($commandeFournisseur->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_commande_fournisseur WHERE id_commande_fournisseur = :id_commande_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_fournisseur', $commandeFournisseur->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param CommandeFournisseur $commandeFournisseur (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($commandeFournisseur)
    {
        // Vérification que l'objet a un id
        if ($commandeFournisseur->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_commande_fournisseur SET date_commande = :date_commande,
                                            date_archive = :date_archive,
                                            id_fournisseur_fk = :id_fournisseur_fk
                                            WHERE id_commande_fournisseur = :id_commande_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':date_commande', $commandeFournisseur->getDateCommande(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $commandeFournisseur->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_fournisseur_fk', $commandeFournisseur->getIdFournisseur(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fournisseur', $commandeFournisseur->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return CommandeFournisseur[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesFournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeFournisseur = new CommandeFournisseur();

            // Remplissage de l'objet
            $this->fillObject($commandeFournisseur, $row);

            // Ajout de l'objet dans le tableau
            $commandesFournisseurs[] = $commandeFournisseur;
        }

        return $commandesFournisseurs;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return CommandeFournisseur[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesFournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeFournisseur = new CommandeFournisseur();

            // Remplissage de l'objet
            $this->fillObject($commandeFournisseur, $row);

            // Ajout de l'objet dans le tableau
            $commandesFournisseurs[] = $commandeFournisseur;
        }

        return $commandesFournisseurs;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return CommandeFournisseur|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur WHERE id_commande_fournisseur = :id_commande_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_fournisseur', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $commandeFournisseur = new CommandeFournisseur();

        // Remplissage de l'objet
        $this->fillObject($commandeFournisseur, $result);

        return $commandeFournisseur;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param CommandeFournisseur $commandeFournisseur (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($commandeFournisseur, $row)
    {
        $commandeFournisseur->setId($row['id_commande_fournisseur']);
        $commandeFournisseur->setDateCommande($row['date_commande']);
        $commandeFournisseur->setDateArchive($row['date_archive']);
        $commandeFournisseur->setIdFournisseur($row['id_fournisseur_fk']);
    }
}
