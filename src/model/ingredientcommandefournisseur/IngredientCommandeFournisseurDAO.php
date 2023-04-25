<?php

/**
 * DAO IngredientCommandeFournisseurDAO (table burger_ingredient_commande_fournisseur)
 * /!\ Attention, le nom à l'heure actuelle dans la bdd est burger_constitue
 */
class IngredientCommandeFournisseurDAO extends DAO
{
    /**
     * Méthode permettant d'ajouter en base de données un IngredientCommandeFournisseur
     * 
     * @param IngredientCommandeFournisseur $ingredientCommandeFournisseur (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create(&$ingredientCommandeFournisseur)
    {
        // Requête
        $sqlQuery = "INSERT INTO burger_constitue (
                                                id_ingredient,
                                                id_commande_fk,
                                                quantite_commandee,
                                                quantite_recue
                                                ) VALUES (
                                                :id_ingredient
                                                :id_commande_fk
                                                :quantite_commandee
                                                :quantite_recue
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient', $ingredientCommandeFournisseur->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fk', $ingredientCommandeFournisseur->getIdCommande(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_commandee', $ingredientCommandeFournisseur->getQuantiteCommandee(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_recue', $ingredientCommandeFournisseur->getQuantiteRecue(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de supprimer de la base de données un IngredientCommandeFournisseur
     * 
     * @param IngredientCommandeFournisseur $ingredientCommandeFournisseur (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($ingredientCommandeFournisseur)
    {
        // Vérification que l'objet a un id
        if ($ingredientCommandeFournisseur->getIdIngredient() === null || $ingredientCommandeFournisseur->getIdCommande() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_constitue WHERE id_ingredient = :id_ingredient AND id_commande_fk = :id_commande_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient', $ingredientCommandeFournisseur->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fk', $ingredientCommandeFournisseur->getIdCommande(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un IngredientCommandeFournisseur en base de données
     * 
     * @param IngredientCommandeFournisseur $ingredientCommandeFournisseur (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($ingredientCommandeFournisseur)
    {
        // Vérification que l'objet a un id
        if ($ingredientCommandeFournisseur->getIdIngredient() === null || $ingredientCommandeFournisseur->getIdCommande() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_constitue SET 
                                                quantite_commandee = :quantite_commandee,
                                                quantite_recue = :quantite_recue
                                            WHERE id_ingredient = :id_ingredient AND id_commande_fk = :id_commande_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_ingredient', $ingredientCommandeFournisseur->getIdIngredient(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_fk', $ingredientCommandeFournisseur->getIdCommande(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_commandee', $ingredientCommandeFournisseur->getQuantiteCommandee(), PDO::PARAM_INT);
        $statement->bindValue(':quantite_recue', $ingredientCommandeFournisseur->getQuantiteRecue(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les IngredientCommandeFournisseur dans la base de données
     * 
     * @return array (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_constitue";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientCommandeFournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientCommandeFournisseur = new IngredientCommandeFournisseur();
            $ingredientCommandeFournisseur->setIdIngredient($row['id_ingredient']);
            $ingredientCommandeFournisseur->setIdCommande($row['id_commande_fk']);
            $ingredientCommandeFournisseur->setQuantiteCommandee($row['quantite_commandee']);
            $ingredientCommandeFournisseur->setQuantiteRecue($row['quantite_recue']);

            // Ajout de l'objet dans le tableau
            $ingredientCommandeFournisseurs[] = $ingredientCommandeFournisseur;
        }

        return $ingredientCommandeFournisseurs;
    }

    /**
     * Attention cette méthode n'est pas utilisable pour cette DAO. 
     * Elle est présente pour respecter le contrat de la classe abstraite DAO
     * Cependant, les objets sont identifiés par deux clés primaires (id_commande et id_ingredient)
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return Exception (impossible de récupérer un objet par son id)
     */
    public function selectById($id)
    {
        throw new Exception("Impossible de récupérer un objet par son id");
    }

    /**
     * Méthode permettant de récupérer tous les IngredientCommandeFournisseur d'une commande en fonction de l'id de la commande
     * 
     * @param int $idCommande (id de la commande)
     * @return array (tableau d'objets)
     */
    public function selectByIdCommande($idCommande)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_constitue WHERE id_commande_fk = :id_commande_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_fk', $idCommande, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ingredientCommandeFournisseurs = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $ingredientCommandeFournisseur = new IngredientCommandeFournisseur();
            $ingredientCommandeFournisseur->setIdIngredient($row['id_ingredient']);
            $ingredientCommandeFournisseur->setIdCommande($row['id_commande_fk']);
            $ingredientCommandeFournisseur->setQuantiteCommandee($row['quantite_commandee']);
            $ingredientCommandeFournisseur->setQuantiteRecue($row['quantite_recue']);

            // Ajout de l'objet dans le tableau
            $ingredientCommandeFournisseurs[] = $ingredientCommandeFournisseur;
        }

        return $ingredientCommandeFournisseurs;
    }
}
