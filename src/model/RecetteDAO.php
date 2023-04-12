<?php 

class RecetteDAO extends DAO {
    
    /**
     * Constructeur de la classe DAO
     *
     * @param PDO $db
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Méthode abstraite qui permet de créer un objet
     * 
     * @param Recette $recette
     */
    public function create(&$recette) {
        // requête
        $query = "INSERT INTO burger_recette (
                                                nom_recette, 
                                                photo_recette, 
                                                date_archive_recette, 
                                                prix_recette )
                                                VALUES (
                                                :nom_recette, 
                                                :photo_recette, 
                                                :date_archive_recette, 
                                                :prix_recette)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom_recette', $recette->getNomRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':photo_recette', $recette->getPhotoRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':date_archive_recette', $recette->getDateArchiveRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':prix_recette', $recette->getPrixRecette(), PDO::PARAM_STR);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        $recette -> setIdRecette($id);
    }

    /**
     * Méthode abstraite qui permet de supprimer un objet
     * 
     * @param Recette $recette
     */
    public function delete($recette) {
        $query = "DELETE FROM burger_recette WHERE id_recette = :id_recette";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_recette', $recette->getIdRecette(), PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Méthode abstraite qui permet de mettre à jour un objet
     * 
     * @param Recette $recette
     */
    public function update($recette){
        // requête
        $query = "UPDATE burger_recette SET nom_recette = :nom_recette, 
                                            photo_recette = :photo_recette, 
                                            date_archive_recette = :date_archive_recette, 
                                            prix_recette = :prix_recette
                                            WHERE id_recette = :id_recette";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom_recette', $recette->getNomRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':photo_recette', $recette->getPhotoRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':date_archive_recette', $recette->getDateArchiveRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':prix_recette', $recette->getPrixRecette(), PDO::PARAM_STR);
        $stmt->bindValue(':id_recette', $recette->getIdRecette(), PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Méthode abstraite qui permet de récupérer tous les objets
     * 
     * @return array
     */
    public function selectAll(){
        // requête
        $query = "SELECT * FROM burger_recette";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // vérifie si on a des résultats 
        if ($stmt->rowCount() === 0) {
            return null;
        }

        // traitement des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            $recette = new Recette();
            $recette->setIdRecette($row['id_recette']);
            $recette->setNomRecette($row['nom_recette']);
            $recette->setPhotoRecette($row['photo_recette']);
            $recette->setDateArchiveRecette($row['date_archive_recette']);
            $recette->setPrixRecette($row['prix_recette']);
        }
        return $recettes;
    }

    /**
     * Méthode abstraite qui permet de récupérer un objet par son id
     * 
     * @param int $id
     * @return Recette
     */
    public function selectById($id){
        // requête
        $query = "SELECT * FROM burger_recette WHERE id_recette = :id_recette";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_recette', $id, PDO::PARAM_INT);
        $stmt->execute();

        // vérifie si on a des résultats 
        if ($stmt->rowCount() === 0) {
            return null;
        }

        // traitement du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $recette = new Recette();
        $recette->setIdRecette($result['id_recette']);
        $recette->setNomRecette($result['nom_recette']);
        $recette->setPhotoRecette($result['photo_recette']);
        $recette->setDateArchiveRecette($result['date_archive_recette']);
        $recette->setPrixRecette($result['prix_recette']);
        return $recette;
    }

    /**
     * Les 3 recettes les plus vendus de la au cours de la dernière semaine
     */
    public function selectTop3Recette(){
        /*
        // requête
        $query = "SELECT * FROM burger_recette ORDER BY id_recette IN(SELECT id_recette FROM burger_recette_finale WHERE id_commande IN (SELECT id_commande FROM burger_commande_client WHERE date_commande BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW())GROUP BY id_recette ORDER BY COUNT(id_recette) DESC LIMIT 3)";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // vérifie si on a des résultats 
        if ($stmt->rowCount() === 0) {
            return null;
        }

        // traitement des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $recettes = array();
        foreach ($result as $row) {
            $recette = new Recette();
            $recette->setIdRecette($row['id_recette']);
            $recette->setNomRecette($row['nom_recette']);
            $recette->setPhotoRecette($row['photo_recette']);
            $recette->setPrixRecette($row['prix_recette']);
            $recettes[] = $recette;
        }
        return $recettes;
        */
        return null;
    }
        
}