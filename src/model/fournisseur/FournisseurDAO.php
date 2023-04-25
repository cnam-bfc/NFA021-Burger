<?php

/**
 * DAO Ingredient
 */
class FournisseurDAO extends DAO
{
    /**
     * Méthode permettant d'ajouter en base de données un Fournisseur
     * 
     * @param Fournisseur $fournisseur (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create(&$fournisseur)
    {
        // Vérification que l'objet n'a pas d'id
        if ($fournisseur->getIdFournisseur() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_fournisseur (
                                                nom_fournisseur
                                                ) VALUES (
                                                :nom_fournisseur
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_fournisseur', $fournisseur->getNomFournisseur(), PDO::PARAM_STR);
        $statement->execute();

        // Récupération de l'id généré par l'auto-increment de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $fournisseur->setIdFournisseur($id);
    }

    /**
     * Méthode permettant de supprimer de la base de données un Fournisseur
     * 
     * @param Fournisseur $fournisseur (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($fournisseur)
    {
        // Vérification que l'objet a un id
        if ($fournisseur->getIdFournisseur() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_fournisseur WHERE id_fournisseur = :id_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_fournisseur', $fournisseur->getIdFournisseur(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un Fournisseur en base de données
     * 
     * @param Fournisseur $fournisseur (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($fournisseur)
    {
        // Vérification que l'objet a un id
        if ($fournisseur->getIdFournisseur() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_fournisseur SET nom_fournisseur = :nom_fournisseur,
                                            WHERE id_fournisseur = :id_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_fournisseur', $fournisseur->getNomFournisseur(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les Fournisseur dans la base de données
     * 
     * @return array (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $fournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $fournisseur = new Fournisseur();
            $fournisseur->setIdFournisseur($row['id_fournisseur']);
            $fournisseur->setNomFournisseur($row['nom_fournisseur']);

            // Ajout de l'objet dans le tableau
            $fournisseurs[] = $fournisseur;
        }

        return $fournisseurs;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Fournisseur|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_fournisseur WHERE id_fournisseur = :id_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_fournisseur', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $fournisseur = new Fournisseur();
        $fournisseur->setIdFournisseur($result['id_fournisseur']);
        $fournisseur->setNomFournisseur($result['nom_fournisseur']);

        return $fournisseur;
    }
}
