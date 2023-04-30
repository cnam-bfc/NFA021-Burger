<?php

/**
 * DAO Livreur
 */
class LivreurDAO extends DAO
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
     * @param Livreur $livreur (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($livreur)
    {
        // On le crée dans la DAO Employe
        $this->employeDAO->create($livreur);

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($livreur->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_livreur (id_compte
                                                ) VALUES (
                                                :id_compte
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $livreur->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Livreur $livreur (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($livreur)
    {
        // Vérification que l'objet a un id
        if ($livreur->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_livreur WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $livreur->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression de l'employé associé
        $this->employeDAO->delete($livreur);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Livreur $livreur (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($livreur)
    {
        // Vérification que l'objet a un id
        if ($livreur->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        /*
        Inutile de mettre à jour la table burger_livreur car elle ne contient aucun attribut
        $sqlQuery = "UPDATE burger_livreur SET 
                                            WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $livreur->getId(), PDO::PARAM_INT);
        $statement->execute();
        */

        // Mise à jour de l'employé associé
        $this->employeDAO->update($livreur);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Livreur[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_livreur WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_livreur.id_compte";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $livreurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $livreur = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $livreurs[] = $livreur;
        }

        return $livreurs;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Livreur[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_livreur WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_livreur.id_compte AND (burger_compte.date_archive IS NULL OR burger_compte.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $livreurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $livreur = $this->convertTableRowToObject($row);

            // Ajout de l'objet dans le tableau
            $livreurs[] = $livreur;
        }

        return $livreurs;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Livreur|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_livreur WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_livreur.id_compte AND burger_compte.id_compte = :id_compte";
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
        $livreur = $this->convertTableRowToObject($result);

        return $livreur;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau
     * 
     * @param array $row (tableau contenant les données)
     * @return Livreur
     */
    protected function convertTableRowToObject($row)
    {
        // Création d'un nouvel objet
        $livreur = new Livreur();
        $livreur->setId($row['id_compte']);
        $livreur->setLogin($row['login']);
        $livreur->setHashedPassword($row['password']);
        $livreur->setDateArchive($row['date_archive']);
        $livreur->setMatricule($row['matricule']);
        $livreur->setNom($row['nom']);
        $livreur->setPrenom($row['prenom']);

        return $livreur;
    }
}
