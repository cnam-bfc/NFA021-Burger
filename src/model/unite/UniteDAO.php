<?php

/**
 * DAO Unite
 */
class UniteDAO extends DAO
{

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return array (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $unites = array();
        foreach ($result as $row) {
            // Création d'un nouvel objet
            $unite = new Unite($row['id_unite'], $row['nom_unite'], $row['diminutif_unite']);

            // Ajout de l'objet dans le tableau
            $unites[] = $unite;
        }

        return $unites;
    }

    /**
     * Méthode abstraite qui permet de créer un objet
     * 
     * @param Unite $unite
     */
    public function create(&$unite)
    {
    }

    /**
     * Méthode abstraite qui permet de supprimer un objet
     * 
     * @param Unite $unite
     */
    public function delete($unite)
    {
    }

    /**
     * Méthode abstraite qui permet de mettre à jour un objet
     * 
     * @param Unite $unite
     */
    public function update($unite)
    {
    }


    /**
     * Méthode abstraite qui permet de récupérer un objet par son id
     * 
     * @param int $id
     * @return Object
     */
    public function selectById($id)
    {
    }


    public function selectByName($nom)
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_unite WHERE nom_unite = :nom_unite";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_unite', $nom, PDO::PARAM_STR);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Création d'un nouvel objet
        $unite = new Unite($result['id_unite'], $result['nom_unite'], $result['diminutif_unite']);

        return $unite;
    }
}