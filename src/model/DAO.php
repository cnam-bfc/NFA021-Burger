<?php
/**
 * Description of DAO
 * Classe abstraite qui contient les méthodes de base pour les DAO
 */
abstract class DAO {
    protected $db;

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
     * @param Object $object
     */
    abstract public function create(&$object);

    /**
     * Méthode abstraite qui permet de supprimer un objet
     * 
     * @param Object $object
     */
    abstract public function delete($object);

    /**
     * Méthode abstraite qui permet de mettre à jour un objet
     * 
     * @param Object $object
     */
    abstract public function update($object);

    /**
     * Méthode abstraite qui permet de récupérer tous les objets
     * 
     * @return array[Object]
     */
    abstract public function selectAll();

    /**
     * Méthode abstraite qui permet de récupérer un objet par son id
     * 
     * @param int $id
     * @return Object
     */
    abstract public function selectById($id);
}