<?php

/**
 * DAO Compte
 */
class CompteDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param Compte $compte (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($compte)
    {
        // Vérification que l'objet n'a pas d'id
        if ($compte->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_compte (
                                                login,
                                                email,
                                                password,
                                                date_archive
                                                ) VALUES (
                                                :login,
                                                :email,
                                                :password,
                                                :date_archive
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':login', $compte->getLogin(), PDO::PARAM_STR);
        $statement->bindValue(':email', $compte->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':password', $compte->getHashedPassword(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $compte->getDateArchive(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $compte->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param Compte $compte (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($compte)
    {
        // Vérification que l'objet a un id
        if ($compte->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_compte WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_compte', $compte->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param Compte $compte (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($compte)
    {
        // Vérification que l'objet a un id
        if ($compte->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_compte SET login = :login,
                                            email = :email,
                                            password = :password,
                                            date_archive = :date_archive
                                            WHERE id_compte = :id_compte";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':login', $compte->getLogin(), PDO::PARAM_STR);
        $statement->bindValue(':email', $compte->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':password', $compte->getHashedPassword(), PDO::PARAM_STR);
        $statement->bindValue(':date_archive', $compte->getDateArchive(), PDO::PARAM_STR);
        $statement->bindValue(':id_compte', $compte->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return Compte[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $comptes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $compte = new Compte();

            // Remplissage de l'objet
            $this->fillObject($compte, $row);

            // Ajout de l'objet dans le tableau
            $comptes[] = $compte;
        }

        return $comptes;
    }

    /**
     * Méthode permettant de récupérer tous les objets non archivés
     *
     * @return Compte[] (tableau d'objets)
     */
    public function selectAllNonArchive()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte WHERE date_archive IS NULL OR date_archive > NOW()";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $comptes = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $compte = new Compte();

            // Remplissage de l'objet
            $this->fillObject($compte, $row);

            // Ajout de l'objet dans le tableau
            $comptes[] = $compte;
        }

        return $comptes;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Compte|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte WHERE id_compte = :id_compte";
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
        $compte = new Compte();

        // Remplissage de l'objet
        $this->fillObject($compte, $result);

        return $compte;
    }

    /**
     * Méthode permettant de récupérer un objet par son nom d'utilisateur
     * 
     * @param string $login (nom d'utilisateur de l'objet à récupérer)
     * @return Compte|null (objet ou null si aucun objet trouvé)
     */
    public function selectByLogin($login)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte WHERE login = :login";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':login', $login, PDO::PARAM_STR);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $compte = new Compte();

        // Remplissage de l'objet
        $this->fillObject($compte, $result);

        return $compte;
    }

    /**
     * Méthode permettant de récupérer un objet par son email
     *
     * @param string $email (email de l'objet à récupérer)
     * @return Compte|null (objet ou null si aucun objet trouvé)
     */
    public function selectByEmail($email)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_compte WHERE email = :email";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $compte = new Compte();

        // Remplissage de l'objet
        $this->fillObject($compte, $result);

        return $compte;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Compte $compte (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($compte, $row)
    {
        $compte->setId($row['id_compte']);
        $compte->setLogin($row['login']);
        $compte->setEmail($row['email']);
        $compte->setHashedPassword($row['password']);
        $compte->setDateArchive($row['date_archive']);
    }
}
