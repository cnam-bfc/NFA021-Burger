<?php

/**
 * DAO Cuisinier
 */
class CuisinierDAO extends DAO
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
     * @param Cuisinier $cuisinier (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($cuisinier)
    {
        // On le crée dans la DAO Employe
        $this->employeDAO->create($cuisinier);

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($cuisinier->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_cuisinier (id_compte
                                                ) VALUES (
                                                :id_compte
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $cuisinier->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Cuisinier $cuisinier (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($cuisinier)
    {
        // Vérification que l'objet a un id
        if ($cuisinier->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_cuisinier WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $cuisinier->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression de l'employé associé
        $this->employeDAO->delete($cuisinier);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Cuisinier $cuisinier (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($cuisinier)
    {
        // Vérification que l'objet a un id
        if ($cuisinier->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        /*
        Inutile de mettre à jour la table burger_cuisinier car elle ne contient aucun attribut
        $sqlQuery = "UPDATE burger_cuisinier SET 
                                            WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $cuisinier->getId(), PDO::PARAM_INT);
        $statement->execute();
        */

        // Mise à jour de l'employé associé
        $this->employeDAO->update($cuisinier);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Cuisinier[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_cuisinier WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_cuisinier.id_compte";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $cuisiniers = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $cuisinier = new Cuisinier();

            // Remplissage de l'objet
            $this->fillObject($cuisinier, $row);

            // Ajout de l'objet dans le tableau
            $cuisiniers[] = $cuisinier;
        }

        return $cuisiniers;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Cuisinier[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_cuisinier WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_cuisinier.id_compte AND (burger_compte.date_archive IS NULL OR burger_compte.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $cuisiniers = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $cuisinier = new Cuisinier();

            // Remplissage de l'objet
            $this->fillObject($cuisinier, $row);

            // Ajout de l'objet dans le tableau
            $cuisiniers[] = $cuisinier;
        }

        return $cuisiniers;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Cuisinier|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe, burger_cuisinier WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = burger_cuisinier.id_compte AND burger_compte.id_compte = :id_compte";
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
        $cuisinier = new Cuisinier();

        // Remplissage de l'objet
        $this->fillObject($cuisinier, $result);

        return $cuisinier;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Cuisinier $cuisinier (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($cuisinier, $row)
    {
        // Remplissage des attributs de l'employé
        $this->employeDAO->fillObject($cuisinier, $row);

        // Remplissage des attributs du cuisinier
    }
}
