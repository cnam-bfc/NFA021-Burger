<?php

/**
 * DAO CommandeClient
 */
class CommandeClientDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param CommandeClient $commandeClient (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($commandeClient)
    {
        // Vérification que l'objet n'a pas d'id
        if ($commandeClient->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_commande_client (
                                                prix,
                                                date_commande,
                                                date_pret,
                                                date_archive,
                                                id_emballage_fk,
                                                id_compte_fk
                                                ) VALUES (
                                                :prix,
                                                :date_commande,
                                                :date_pret,
                                                :date_archive,
                                                :id_emballage_fk,
                                                :id_compte_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':prix', $commandeClient->getPrix(), PDO::PARAM_STR);
        $statement->bindValue(':date_commande', $commandeClient->getDateCommande(), PDO::PARAM_STR);
        $statement->bindValue(':date_pret', $commandeClient->getDatePret(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $commandeClient->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_emballage_fk', $commandeClient->getIdEmballage(), PDO::PARAM_INT);
        $statement->bindValue(':id_compte_fk', $commandeClient->getIdClient(), PDO::PARAM_INT);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $commandeClient->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param CommandeClient $commandeClient (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($commandeClient)
    {
        // Vérification que l'objet a un id
        if ($commandeClient->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_commande_client WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client', $commandeClient->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param CommandeClient $commandeClient (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($commandeClient)
    {
        // Vérification que l'objet a un id
        if ($commandeClient->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_commande_client SET prix = :prix,
                                            date_commande = :date_commande,
                                            date_pret = :date_pret,
                                            date_archive = :date_archive,
                                            id_emballage_fk = :id_emballage_fk,
                                            id_compte_fk = :id_compte_fk
                                            WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':prix', $commandeClient->getPrix(), PDO::PARAM_STR);
        $statement->bindValue(':date_commande', $commandeClient->getDateCommande(), PDO::PARAM_STR);
        $statement->bindValue(':date_pret', $commandeClient->getDatePret(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $commandeClient->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_emballage_fk', $commandeClient->getIdEmballage(), PDO::PARAM_INT);
        $statement->bindValue(':id_compte_fk', $commandeClient->getIdClient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_client', $commandeClient->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return CommandeClient[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_client";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesClients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeClient = new CommandeClient();

            // Remplissage de l'objet
            $this->fillObject($commandeClient, $row);

            // Ajout de l'objet dans le tableau
            $commandesClients[] = $commandeClient;
        }

        return $commandesClients;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return CommandeClient[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_client WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesClients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeClient = new CommandeClient();

            // Remplissage de l'objet
            $this->fillObject($commandeClient, $row);

            // Ajout de l'objet dans le tableau
            $commandesClients[] = $commandeClient;
        }

        return $commandesClients;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return CommandeClient|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_client WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $commandeClient = new CommandeClient();

        // Remplissage de l'objet
        $this->fillObject($commandeClient, $result);

        return $commandeClient;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param CommandeClient $commandeClient (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($commandeClient, $row)
    {
        $commandeClient->setId($row['id_commande_client']);
        $commandeClient->setPrix($row['prix']);
        $commandeClient->setDateCommande($row['date_commande']);
        $commandeClient->setDatePret($row['date_pret']);
        $commandeClient->setDateArchive($row['date_archive']);
        $commandeClient->setIdEmballage($row['id_emballage_fk']);
        $commandeClient->setIdClient($row['id_compte_fk']);
    }
}
