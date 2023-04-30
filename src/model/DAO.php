<?php

/**
 * DAO
 * 
 * Classe abstraite qui contient les méthodes de base pour les DAO
 */
abstract class DAO
{
    /**
     * PDO
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    /**
     * Méthode abstraite qui permet de créer un objet
     * 
     * @param Object $object
     */
    abstract public function create($object);

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
     * @return Object[]
     */
    abstract public function selectAll();

    /**
     * Méthode abstraite qui permet de récupérer un objet par son id
     * 
     * @param int $id
     * @return Object
     */
    abstract public function selectById($id);

    /**
     * Méthode abstraite qui permet de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param Object $object (objet à remplir)
     * @param array $array (tableau contenant les données, ligne issues de la base de données)
     */
    abstract public function fillObject($object, $array);
}
