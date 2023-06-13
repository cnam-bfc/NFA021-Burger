<?php

/**
 * DAO RecetteFinale
 */
class RecetteFinaleDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param RecetteFinale $recetteFinale (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($recetteFinale)
    {
        // Vérification que l'objet n'a pas d'id
        if ($recetteFinale->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // Requête
        $sqlQuery = "INSERT INTO burger_recette_finale (
                                                quantite,
                                                id_commande_client_fk,
                                                id_recette_fk
                                                ) VALUES (
                                                :quantite,
                                                :id_commande_client_fk,
                                                :id_recette_fk
                                                )";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':quantite', $recetteFinale->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_client_fk', $recetteFinale->getIdCommandeClient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteFinale->getIdRecette(), PDO::PARAM_INT);
        $statement->execute();

        // Récupération de l'id généré par l'autoincrement de la base de données
        $id = $this->pdo->lastInsertId();

        // Affectation de l'id à l'objet
        $recetteFinale->setId($id);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param RecetteFinale $recetteFinale (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($recetteFinale)
    {
        // Vérification que l'objet a un id
        if ($recetteFinale->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // Requête
        $sqlQuery = "DELETE FROM burger_recette_finale WHERE id_recette_finale = :id_recette_finale";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_finale', $recetteFinale->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param RecetteFinale $recetteFinale (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($recetteFinale)
    {
        // Vérification que l'objet a un id
        if ($recetteFinale->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // Requête
        $sqlQuery = "UPDATE burger_recette_finale SET quantite = :quantite,
                                            id_commande_client_fk = :id_commande_client_fk,
                                            id_recette_fk = :id_recette_fk
                                            WHERE id_recette_finale = :id_recette_finale";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':quantite', $recetteFinale->getQuantite(), PDO::PARAM_INT);
        $statement->bindValue(':id_commande_client_fk', $recetteFinale->getIdCommandeClient(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_fk', $recetteFinale->getIdRecette(), PDO::PARAM_INT);
        $statement->bindValue(':id_recette_finale', $recetteFinale->getId(), PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return RecetteFinale[] (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_finale";
        $statement = $this->pdo->query($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recetteFinales = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteFinale = new RecetteFinale();

            // Remplissage de l'objet
            $this->fillObject($recetteFinale, $row);

            // Ajout de l'objet dans le tableau
            $recetteFinales[] = $recetteFinale;
        }

        return $recetteFinales;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param int $id (id de l'objet à récupérer)
     * @return RecetteFinale|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_finale WHERE id_commande_client_fk = :id_commande_client_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_finale', $id, PDO::PARAM_INT);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $recetteFinale = new RecetteFinale();

        // Remplissage de l'objet
        $this->fillObject($recetteFinale, $result);

        return $recetteFinale;
    }

    public function selectAllByIdCommandeClient($idCommandeClient) {

        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_finale WHERE id_commande_client_fk = :id_commande_client_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_commande_client_fk', $idCommandeClient, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesFinales = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteFinale = new RecetteFinale();

            // Remplissage de l'objet
            $this->fillObject($recetteFinale, $row);

            // Ajout de l'objet dans le tableau
            $recettesFinales[] = $recetteFinale;
        }

        return $recettesFinales;

    }

    public function selectAllByIdRecetteAndIdComClient($idRecette, $idCommandeClient) {

        // Requête
        $sqlQuery = "SELECT * FROM burger_recette_finale WHERE id_recette_fk = :id_recette_fk AND id_commande_client_fk = :id_commande_client_fk";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':id_recette_fk', $idRecette, PDO::PARAM_INT);
        $statement->bindValue(':id_commande_client_fk', $idCommandeClient, PDO::PARAM_INT);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $recettesFinales = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $recetteFinale = new RecetteFinale();

            // Remplissage de l'objet
            $this->fillObject($recetteFinale, $row);

            // Ajout de l'objet dans le tableau
            $recettesFinales[] = $recetteFinale;
        }

        return $recettesFinales;

    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param RecetteFinale $recetteFinale (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($recetteFinale, $row)
    {
        $recetteFinale->setId($row['id_recette_finale']);
        $recetteFinale->setQuantite($row['quantite']);
        $recetteFinale->setIdCommandeClient($row['id_commande_client_fk']);
        $recetteFinale->setIdRecette($row['id_recette_fk']);
    }
}
