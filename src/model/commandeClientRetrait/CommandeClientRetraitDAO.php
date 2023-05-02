<?php

/**
 * DAO CommandeClientRetrait
 */
class CommandeClientRetraitDAO extends DAO
{
    /**
     * DAO des commandes client (DAO parent)
     */
    private $commandeClientDAO;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        $this->commandeClientDAO = new CommandeClientDAO();
    }

    /**
     * Méthode permettant de créer un objet
     * 
     * @param CommandeClientRetrait $commandeClientRetrait (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($commandeClientRetrait)
    {
        // Si l'objet n'a pas d'id, on le crée dans la DAO commande client
        if ($commandeClientRetrait->getId() === null) {
            $this->commandeClientDAO->create($commandeClientRetrait);
        }

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($commandeClientRetrait->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_commande_client_retrait (id_commande_client,
                                                heure_retrait
                                                ) VALUES (
                                                :id_commande_client,
                                                :heure_retrait
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client', $commandeClientRetrait->getId(), PDO::PARAM_INT);
        $statement->bindValue(':heure_retrait', $commandeClientRetrait->getHeureRetrait(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param CommandeClientRetrait $commandeClientRetrait (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($commandeClientRetrait)
    {
        // Vérification que l'objet a un id
        if ($commandeClientRetrait->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_commande_client_retrait WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client', $commandeClientRetrait->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression de la commande client associée
        $this->commandeClientDAO->delete($commandeClientRetrait);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param CommandeClientRetrait $commandeClientRetrait (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($commandeClientRetrait)
    {
        // Vérification que l'objet a un id
        if ($commandeClientRetrait->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_commande_client_retrait SET heure_retrait = :heure_retrait
                                            WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':heure_retrait', $commandeClientRetrait->getHeureRetrait(), PDO::PARAM_STR);
        $statement->bindValue(':id_commande_client', $commandeClientRetrait->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Mise à jour de la commande client associée
        $this->commandeClientDAO->update($commandeClientRetrait);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return CommandeClientRetrait[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_client, burger_commande_client_retrait WHERE burger_commande_client.id_commande_client = burger_commande_client_retrait.id_commande_client";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesClientsRetraits = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeClientRetrait = new CommandeClientRetrait();

            // Remplissage de l'objet
            $this->fillObject($commandeClientRetrait, $row);

            // Ajout de l'objet dans le tableau
            $commandesClientsRetraits[] = $commandeClientRetrait;
        }

        return $commandesClientsRetraits;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return CommandeClientRetrait[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_client, burger_commande_client_retrait WHERE burger_commande_client.id_commande_client = burger_commande_client_retrait.id_commande_client AND (burger_commande_client.date_archive IS NULL OR burger_commande_client.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesClientsRetraits = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeClientRetrait = new CommandeClientRetrait();

            // Remplissage de l'objet
            $this->fillObject($commandeClientRetrait, $row);

            // Ajout de l'objet dans le tableau
            $commandesClientsRetraits[] = $commandeClientRetrait;
        }

        return $commandesClientsRetraits;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return CommandeClientRetrait|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_client, burger_commande_client_retrait WHERE burger_commande_client.id_commande_client = burger_commande_client_retrait.id_commande_client AND burger_commande_client.id_commande_client = :id_commande_client";
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
        $commandeClientRetrait = new CommandeClientRetrait();

        // Remplissage de l'objet
        $this->fillObject($commandeClientRetrait, $result);

        return $commandeClientRetrait;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param CommandeClientRetrait $commandeClientRetrait (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($commandeClientRetrait, $row)
    {
        // Remplissage des attributs de la commande client
        $this->commandeClientDAO->fillObject($commandeClientRetrait, $row);

        // Remplissage des attributs de la commande client retrait
        $commandeClientRetrait->setHeureRetrait($row['heure_retrait']);
    }
}
