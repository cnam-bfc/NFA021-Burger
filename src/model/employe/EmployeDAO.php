<?php

/**
 * DAO Employe
 */
class EmployeDAO extends DAO
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
     * @param Employe $employe (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($employe)
    {
        // Si l'objet n'a pas d'id, on le crée dans la DAO Compte
        if ($employe->getId() === null) {
            $this->compteDAO->create($employe);
        }

        // Si l'objet existe déjà dans la base de données, on ne le recrée pas
        if ($this->selectById($employe->getId()) !== null) {
            return;
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_employe (id_compte,
                                                matricule,
                                                nom,
                                                prenom
                                                ) VALUES (
                                                :id_compte,
                                                :matricule,
                                                :nom,
                                                :prenom
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $employe->getId(), PDO::PARAM_INT);
        $statement->bindValue(':matricule', $employe->getMatricule(), PDO::PARAM_STR);
        $statement->bindValue(':nom', $employe->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':prenom', $employe->getPrenom(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Employe $employe (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($employe)
    {
        // Vérification que l'objet a un id
        if ($employe->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_employe WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $employe->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Suppression du compte associé
        $this->compteDAO->delete($employe);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Employe $employe (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($employe)
    {
        // Vérification que l'objet a un id
        if ($employe->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_employe SET matricule = :matricule,
                                            nom = :nom,
                                            prenom = :prenom
                                            WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':matricule', $employe->getMatricule(), PDO::PARAM_STR);
        $statement->bindValue(':nom', $employe->getNom(), PDO::PARAM_STR);
        $statement->bindValue(':prenom', $employe->getPrenom(), PDO::PARAM_STR);
        $statement->bindValue(':id_compte', $employe->getId(), PDO::PARAM_INT);
        $statement->execute();

        // Mise à jour du compte associé
        $this->compteDAO->update($employe);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Employe[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe WHERE burger_compte.id_compte = burger_employe.id_compte";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $employes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $employe = new Employe();

            // Remplissage de l'objet
            $this->fillObject($employe, $row);

            // Ajout de l'objet dans le tableau
            $employes[] = $employe;
        }

        return $employes;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Employe[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe WHERE burger_compte.id_compte = burger_employe.id_compte AND (burger_compte.date_archive IS NULL OR burger_compte.date_archive > NOW())";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $employes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $employe = new Employe();

            // Remplissage de l'objet
            $this->fillObject($employe, $row);

            // Ajout de l'objet dans le tableau
            $employes[] = $employe;
        }

        return $employes;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Employe|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte, burger_employe WHERE burger_compte.id_compte = burger_employe.id_compte AND burger_compte.id_compte = :id_compte";
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
        $employe = new Employe();

        // Remplissage de l'objet
        $this->fillObject($employe, $result);

        return $employe;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Employe $employe (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($employe, $row)
    {
        // Remplissage des attributs du compte
        $this->compteDAO->fillObject($employe, $row);

        // Remplissage des attributs de l'employé
        $employe->setMatricule($row['matricule']);
        $employe->setNom($row['nom']);
        $employe->setPrenom($row['prenom']);
    }
}
