<?php

/**
 * Objet Emballage
 */
class Emballage
{
    /**
     * Identifiant de l'emballage
     * 
     * @var int
     */
    private $id;

    /**
     * Nom de l'emballage
     *
     * @var string
     */
    private $nom;

    /**
     * Date d'archivage de l'emballage
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Méthode permettant de récupérer l'identifiant de l'emballage
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom de l'emballage
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage de l'emballage
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'emballage
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le nom de l'emballage
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier la date d'archivage de l'emballage
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }
}
