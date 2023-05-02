<?php

/**
 * DAO Fournisseur
 */
class BdcDAO extends DAO
{

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return array (tableau d'objets)
     */
    public function selectAll()
    {
        // Requête
        $sqlQuery = "SELECT * FROM burger_commande_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute();

        // Traitement des résultats
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $bdc = array();
        foreach ($result as $ligne) {
            // Création d'un nouvel objet
            $bdc1 = new Bdc();
            $bdc1->setIdBdc($ligne['id_commande']);
            $bdc1->setEtatBdc($ligne['etat_commande']);
            $bdc1->setDateCreationBdc($ligne['date_commande']);
            $bdc1->setIdFournisseurFK($ligne['id_fournisseur_fk']);

            // Ajout de l'objet dans le tableau
            $bdc[] = $bdc1;
        }

        return $bdc;
    }

    /**
     * Méthode abstraite qui permet de créer un objet
     * 
     * @param Fournisseur $fournisseur
     */
    public function create(&$bdc)
    {
    }

    /**
     * Méthode abstraite qui permet de supprimer un objet
     * 
     * @param Fournisseur $fournisseur
     */
    public function delete($fournisseur)
    {
    }

    /**
     * Méthode abstraite qui permet de mettre à jour un objet
     * 
     * @param Fournisseur $fournisseur
     */
    public function update($fournisseur)
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
        $sqlQuery = "SELECT * FROM burger_fournisseur WHERE nom_fournisseur = :nom_fournisseur";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(':nom_fournisseur', $nom, PDO::PARAM_STR);
        $statement->execute();

        // Vérification que l'on a bien un résultat
        if ($statement->rowCount() === 0) {
            return null;
        }

        // Traitement du résultat
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Création d'un nouvel objet
        $fournisseur = new Fournisseur($result['id_fournisseur'], $result['nom_fournisseur']);

        return $fournisseur;
    }
}