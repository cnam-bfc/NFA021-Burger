<?php

/**
 * DAO CommandeClientLivraison
 */
class CommandeClientLivraisonDAO extends DAO
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
     * @param CommandeClientLivraison $commandeClientLivraison (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($commandeClientLivraison)
    {
        // Si l'objet n'a pas d'id, on le crée dans la DAO commande client
        if ($commandeClientLivraison->getId() === null) {
            $this->commandeClientDAO->create($commandeClientLivraison);
        }

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($commandeClientLivraison->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_commande_client_livraison (id_commande_client,
                                                heure_livraison,
                                                adresse_osm_type,
                                                adresse_osm_id,
                                                adresse_code_postal,
                                                adresse_ville,
                                                adresse_rue,
                                                adresse_numero,
                                                id_compte_fk
                                                ) VALUES (
                                                :id_commande_client,
                                                :heure_livraison,
                                                :adresse_osm_type,
                                                :adresse_osm_id,
                                                :adresse_code_postal,
                                                :adresse_ville,
                                                :adresse_rue,
                                                :adresse_numero,
                                                :id_compte_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client', $commandeClientLivraison->getId(), PDO::PARAM_INT);
        $statement->bindValue(':heure_livraison', $commandeClientLivraison->getHeureLivraison(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_type', $commandeClientLivraison->getAdresseOsmType(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_id', $commandeClientLivraison->getAdresseOsmId(), PDO::PARAM_INT);
        $statement->bindValue(':adresse_code_postal', $commandeClientLivraison->getAdresseCodePostal(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_ville', $commandeClientLivraison->getAdresseVille(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_rue', $commandeClientLivraison->getAdresseRue(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_numero', $commandeClientLivraison->getAdresseNumero(), PDO::PARAM_STR);
        $statement->bindValue(':id_compte_fk', $commandeClientLivraison->getIdLivreur(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param CommandeClientLivraison $commandeClientLivraison (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($commandeClientLivraison)
    {
        // Vérification que l'objet a un id
        if ($commandeClientLivraison->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_commande_client_livraison WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client', $commandeClientLivraison->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression de la commande client associée
        $this->commandeClientDAO->delete($commandeClientLivraison);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param CommandeClientLivraison $commandeClientLivraison (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($commandeClientLivraison)
    {
        // Vérification que l'objet a un id
        if ($commandeClientLivraison->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_commande_client_livraison SET heure_livraison = :heure_livraison,
                                            adresse_osm_type = :adresse_osm_type,
                                            adresse_osm_id = :adresse_osm_id,
                                            adresse_code_postal = :adresse_code_postal,
                                            adresse_ville = :adresse_ville,
                                            adresse_rue = :adresse_rue,
                                            adresse_numero = :adresse_numero,
                                            id_compte_fk = :id_compte_fk
                                            WHERE id_commande_client = :id_commande_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':heure_livraison', $commandeClientLivraison->getHeureLivraison(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_type', $commandeClientLivraison->getAdresseOsmType(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_id', $commandeClientLivraison->getAdresseOsmId(), PDO::PARAM_INT);
        $statement->bindValue(':adresse_code_postal', $commandeClientLivraison->getAdresseCodePostal(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_ville', $commandeClientLivraison->getAdresseVille(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_rue', $commandeClientLivraison->getAdresseRue(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_numero', $commandeClientLivraison->getAdresseNumero(), PDO::PARAM_STR);
        $statement->bindValue(':id_compte_fk', $commandeClientLivraison->getIdLivreur(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_client', $commandeClientLivraison->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Mise à jour de la commande client associée
        $this->commandeClientDAO->update($commandeClientLivraison);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return CommandeClientLivraison[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT *, burger_commande_client_livraison.id_compte_fk AS 'id_livreur_fk' FROM burger_commande_client, burger_commande_client_livraison WHERE burger_commande_client.id_commande_client = burger_commande_client_livraison.id_commande_client";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesClientsLivraisons = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeClientLivraison = new CommandeClientLivraison();

            // Remplissage de l'objet
            $this->fillObject($commandeClientLivraison, $row);

            // Ajout de l'objet dans le tableau
            $commandesClientsLivraisons[] = $commandeClientLivraison;
        }

        return $commandesClientsLivraisons;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return CommandeClientLivraison[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT *, burger_commande_client_livraison.id_compte_fk AS 'id_livreur_fk' FROM burger_commande_client, burger_commande_client_livraison WHERE burger_commande_client.id_commande_client = burger_commande_client_livraison.id_commande_client AND (burger_commande_client.date_archive IS NULL OR burger_commande_client.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesClientsLivraisons = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeClientLivraison = new CommandeClientLivraison();

            // Remplissage de l'objet
            $this->fillObject($commandeClientLivraison, $row);

            // Ajout de l'objet dans le tableau
            $commandesClientsLivraisons[] = $commandeClientLivraison;
        }

        return $commandesClientsLivraisons;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return CommandeClientLivraison|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT *, burger_commande_client_livraison.id_compte_fk AS 'id_livreur_fk' FROM burger_commande_client, burger_commande_client_livraison WHERE burger_commande_client.id_commande_client = burger_commande_client_livraison.id_commande_client AND burger_commande_client.id_commande_client = :id_commande_client";
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
        $commandeClientLivraison = new CommandeClientLivraison();

        // Remplissage de l'objet
        $this->fillObject($commandeClientLivraison, $result);

        return $commandeClientLivraison;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param CommandeClientLivraison $commandeClientLivraison (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($commandeClientLivraison, $row)
    {
        // Remplissage des attributs de la commande client
        $this->commandeClientDAO->fillObject($commandeClientLivraison, $row);

        // Remplissage des attributs de la commande client livraison
        $commandeClientLivraison->setHeureLivraison($row['heure_livraison']);
        $commandeClientLivraison->setAdresseOsmType($row['adresse_osm_type']);
        $commandeClientLivraison->setAdresseOsmId($row['adresse_osm_id']);
        $commandeClientLivraison->setAdresseCodePostal($row['adresse_code_postal']);
        $commandeClientLivraison->setAdresseVille($row['adresse_ville']);
        $commandeClientLivraison->setAdresseRue($row['adresse_rue']);
        $commandeClientLivraison->setAdresseNumero($row['adresse_numero']);
        $commandeClientLivraison->setIdLivreur($row['id_livreur_fk']);
    }
}
