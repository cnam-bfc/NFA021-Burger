<?php

/**
 * DAO CommandeFournisseurIngredient
 */
class CommandeFournisseurIngredientDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param CommandeFournisseurIngredient $commandeFournisseurIngredient (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($commandeFournisseurIngredient)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($commandeFournisseurIngredient->getIdIngredient() === null || $commandeFournisseurIngredient->getIdCommandeFournisseur() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de commande fournisseur");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_commande_fournisseur_ingredient (
                                                id_ingredient_fk,
                                                id_commande_fournisseur_fk,
                                                quantite_commandee,
                                                quantite_recue
                                                ) VALUES (
                                                :id_ingredient_fk,
                                                :id_commande_fournisseur_fk,
                                                :quantite_commandee,
                                                :quantite_recue
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $commandeFournisseurIngredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fournisseur_fk', $commandeFournisseurIngredient->getIdCommandeFournisseur(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_commandee', $commandeFournisseurIngredient->getQuantiteCommandee(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_recue', $commandeFournisseurIngredient->getQuantiteRecue(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param CommandeFournisseurIngredient $commandeFournisseurIngredient (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($commandeFournisseurIngredient)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($commandeFournisseurIngredient->getIdIngredient() === null || $commandeFournisseurIngredient->getIdCommandeFournisseur() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de commande fournisseur");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_commande_fournisseur_ingredient WHERE id_ingredient_fk = :id_ingredient_fk AND id_commande_fournisseur_fk = :id_commande_fournisseur_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $commandeFournisseurIngredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fournisseur_fk', $commandeFournisseurIngredient->getIdCommandeFournisseur(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param CommandeFournisseurIngredient $commandeFournisseurIngredient (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($commandeFournisseurIngredient)
    {
        // Vérification que l'objet possède les id nécessaire à sa création
        if ($commandeFournisseurIngredient->getIdIngredient() === null || $commandeFournisseurIngredient->getIdCommandeFournisseur() === null) {
            throw new Exception("L'objet à créer doit avoir un id de d'ingredient et un id de commande fournisseur");
        }

        // Requête
        $sqlQuery = "UPDATE burger_commande_fournisseur_ingredient SET quantite_commandee = :quantite_commandee,
                                            quantite_recue = :quantite_recue
                                            WHERE id_ingredient_fk = :id_ingredient_fk AND id_commande_fournisseur_fk = :id_commande_fournisseur_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $commandeFournisseurIngredient->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fournisseur_fk', $commandeFournisseurIngredient->getIdCommandeFournisseur(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_commandee', $commandeFournisseurIngredient->getQuantiteCommandee(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_recue', $commandeFournisseurIngredient->getQuantiteRecue(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return CommandeFournisseurIngredient[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur_ingredient";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandesFournisseursIngredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeFournisseurIngredient = new CommandeFournisseurIngredient();

            // Remplissage de l'objet
            $this->fillObject($commandeFournisseurIngredient, $row);

            // Ajout de l'objet dans le tableau
            $commandesFournisseursIngredients[] = $commandeFournisseurIngredient;
        }

        return $commandesFournisseursIngredients;
    }

    /**
     * Méthode permettant de récupérer tous les objets par id de commande fournisseur
     * 
     * @param int $idCommandeFournisseur (id de la commande fournisseur)
     * @return IngredientRecetteBasique[] (tableau d'objets)
     */
    public function selectAllByIdCommandeFournisseur($idCommandeFournisseur)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur_ingredient WHERE id_commande_fournisseur_fk = :id_commande_fournisseur_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_fournisseur_fk', $idCommandeFournisseur, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $commandeFournisseurIngredients = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $commandeFournisseurIngredient = new CommandeFournisseurIngredient();

            // Remplissage de l'objet
            $this->fillObject($commandeFournisseurIngredient, $row);

            // Ajout de l'objet dans le tableau
            $commandeFournisseurIngredients[] = $commandeFournisseurIngredient;
        }

        return $commandeFournisseurIngredients;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @throws Exception (impossible de récupérer un objet par son id)
     */
    public function selectById($id)
    {
        throw new Exception("Impossible de récupérer un objet par son id");
    }

    /**
     * Méthode permettant de récupérer un objet par son id d'ingredient et son id de commande fournisseur
     * 
     * @param int $idIngredient (id de l'ingredient de l'objet à récupérer)
     * @param int $idCommandeFournisseur (id de la commande fournisseur de l'objet à récupérer)
     * @return IngredientRecetteBasique (objet récupéré)
     */
    public function selectByIdIngredientAndIdCommandeFournisseur($idIngredient, $idCommandeFournisseur)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur_ingredient WHERE id_ingredient_fk = :id_ingredient_fk AND id_commande_fournisseur_fk = :id_commande_fournisseur_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient_fk', $idIngredient, PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fournisseur_fk', $idCommandeFournisseur, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement des résultats
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $commandeFournisseurIngredient = new CommandeFournisseurIngredient();

        // Remplissage de l'objet
        $this->fillObject($commandeFournisseurIngredient, $row);

        return $commandeFournisseurIngredient;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param CommandeFournisseurIngredient $commandeFournisseurIngredient (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($commandeFournisseurIngredient, $row)
    {
        $commandeFournisseurIngredient->setIdIngredient($row['id_ingredient_fk']);
        $commandeFournisseurIngredient->setIdCommandeFournisseur($row['id_commande_fournisseur_fk']);
        $commandeFournisseurIngredient->setQuantiteCommandee($row['quantite_commandee']);
        $commandeFournisseurIngredient->setQuantiteRecue($row['quantite_recue']);
    }
}
