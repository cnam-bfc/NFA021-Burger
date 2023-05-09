<?php

/**
 * Objet Fournisseur
 */
class Fournisseur
{
    /**
     * Identifiant du fournisseur
     * 
     * @var int
     */
    private $id;

    /**
     * Nom du fournisseur
     *
     * @var string
     */
    private $nom;

    /**
     * Date d'archivage du fournisseur
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Méthode permettant de récupérer l'identifiant du fournisseur
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom du fournisseur
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage du fournisseur
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant du fournisseur
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le nom du fournisseur
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier la date d'archivage du fournisseur
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }
}
