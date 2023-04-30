<?php

/**
 * DAO Client
 */
class ClientDAO extends DAO
{
    /**
     * DAO des comptes (DAO parent)
     */
    private $compteDAO;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        $this->compteDAO = new CompteDAO();
    }

    /**
     * Méthode permettant de créer un objet
     * 
     * @param Client $client (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($client)
    {
        // Si l'objet n'a pas d'id, on le crée dans la DAO Compte
        if ($client->getId() === null) {
            $this->compteDAO->create($client);
        }

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($client->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_client (id_compte,
                                                nom,
                                                prenom,
                                                telephone,
                                                adresse_osm_type,
                                                adresse_osm_id,
                                                adresse_code_postal,
                                                adresse_ville,
                                                adresse_rue,
                                                adresse_numero
                                                ) VALUES (
                                                :id_compte,
                                                :nom,
                                                :prenom,
                                                :telephone,
                                                :adresse_osm_type,
                                                :adresse_osm_id,
                                                :adresse_code_postal,
                                                :adresse_ville,
                                                :adresse_rue,
                                                :adresse_numero
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $client->getId(), PDO::PARAM_INT);
        $statement->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);
        $statement->bindValue(':telephone', $client->getTelephone(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_type', $client->getAdresseOsmType(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_id', $client->getAdresseOsmId(), PDO::PARAM_INT);
        $statement->bindValue(':adresse_code_postal', $client->getAdresseCodePostal(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_ville', $client->getAdresseVille(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_rue', $client->getAdresseRue(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_numero', $client->getAdresseNumero(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Client $client (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($client)
    {
        // Vérification que l'objet a un id
        if ($client->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_client WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $client->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression du compte associé
        $this->compteDAO->delete($client);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Client $client (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($client)
    {
        // Vérification que l'objet a un id
        if ($client->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_client SET nom = :nom,
                                            prenom = :prenom,
                                            telephone = :telephone,
                                            adresse_osm_type = :adresse_osm_type,
                                            adresse_osm_id = :adresse_osm_id,
                                            adresse_code_postal = :adresse_code_postal,
                                            adresse_ville = :adresse_ville,
                                            adresse_rue = :adresse_rue,
                                            adresse_numero = :adresse_numero
                                            WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);
        $statement->bindValue(':telephone', $client->getTelephone(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_type', $client->getAdresseOsmType(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_osm_id', $client->getAdresseOsmId(), PDO::PARAM_INT);
        $statement->bindValue(':adresse_code_postal', $client->getAdresseCodePostal(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_ville', $client->getAdresseVille(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_rue', $client->getAdresseRue(), PDO::PARAM_STR);
        $statement->bindValue(':adresse_numero', $client->getAdresseNumero(), PDO::PARAM_STR);
        $statement->bindValue(':id_compte', $client->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Mise à jour du compte associé
        $this->compteDAO->update($client);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Client[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_client WHERE burger_compte.id_compte = burger_client.id_compte";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $clients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $client = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $clients[] = $client;
        }

        return $clients;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Client[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_client WHERE burger_compte.id_compte = burger_client.id_compte AND (burger_compte.date_archive IS NULL OR burger_compte.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $clients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $client = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $clients[] = $client;
        }

        return $clients;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Client|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_client WHERE burger_compte.id_compte = burger_client.id_compte AND burger_compte.id_compte = :id_client";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_client', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $client = $this->convertTableRowToObject($result);

        return $client;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau
     * 
     * @param array $row (tableau contenant les données)
     * @return Client
     */
    protected function convertTableRowToObject($row)
    {
        // Création d'un nouvel objet
        $client = new Client();
        $client->setId($row['id_compte']);
        $client->setLogin($row['login']);
        $client->setHashedPassword($row['password']);
        $client->setDateArchive($row['date_archive']);
        $client->setNom($row['nom']);
        $client->setPrenom($row['prenom']);
        $client->setTelephone($row['telephone']);
        $client->setAdresseOsmType($row['adresse_osm_type']);
        $client->setAdresseOsmId($row['adresse_osm_id']);
        $client->setAdresseCodePostal($row['adresse_code_postal']);
        $client->setAdresseVille($row['adresse_ville']);
        $client->setAdresseRue($row['adresse_rue']);
        $client->setAdresseNumero($row['adresse_numero']);

        return $client;
    }
}
