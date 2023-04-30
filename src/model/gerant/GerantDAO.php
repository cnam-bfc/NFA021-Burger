<?php

/**
 * DAO Gerant
 */
class GerantDAO extends DAO
{
    /**
     * DAO des employés (DAO parent)
     */
    private $employeDAO;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        $this->employeDAO = new EmployeDAO();
    }

    /**
     * Méthode permettant de créer un objet
     * 
     * @param Gerant $gerant (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($gerant)
    {
        // On le crée dans la DAO Employe
        $this->employeDAO->create($gerant);

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($gerant->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_gerant (id_compte
                                                ) VALUES (
                                                :id_compte
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $gerant->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Gerant $gerant (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($gerant)
    {
        // Vérification que l'objet a un id
        if ($gerant->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_gerant WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $gerant->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression de l'employé associé
        $this->employeDAO->delete($gerant);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Gerant $gerant (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($gerant)
    {
        // Vérification que l'objet a un id
        if ($gerant->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        /*
        Inutile de mettre à jour la table burger_gerant car elle ne contient aucun attribut
        $sqlQuery = "UPDATE burger_gerant SET 
                                            WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $gerant->getId(), PDO::PARAM_INT);
        $statement->execute();
        */

        // Mise à jour de l'employé associé
        $this->employeDAO->update($gerant);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Gerant[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_gerant WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_gerant.id_compte";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $gerants = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $gerant = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $gerants[] = $gerant;
        }

        return $gerants;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Gerant[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_gerant WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_gerant.id_compte AND (burger_compte.date_archive IS NULL OR burger_compte.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $gerants = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $gerant = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $gerants[] = $gerant;
        }

        return $gerants;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Gerant|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_gerant WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_gerant.id_compte AND burger_compte.id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $gerant = $this->convertTableRowToObject($result);

        return $gerant;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau
     * 
     * @param array $row (tableau contenant les données)
     * @return Gerant
     */
    protected function convertTableRowToObject($row)
    {
        // Création d'un nouvel objet
        $gerant = new Gerant();
        $gerant->setId($row['id_compte']);
        $gerant->setLogin($row['login']);
        $gerant->setHashedPassword($row['password']);
        $gerant->setDateArchive($row['date_archive']);
        $gerant->setMatricule($row['matricule']);
        $gerant->setNom($row['nom']);
        $gerant->setPrenom($row['prenom']);

        return $gerant;
    }
}
