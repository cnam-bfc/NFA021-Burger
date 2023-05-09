<?php

/**
 * Objet Unite
 */
class Unite
{
    /**
     * Identifiant de l'unite
     * 
     * @var int
     */
    private $id;

    /**
     * Nom de l'unite
     *
     * @var string
     */
    private $nom;

    /**
     * Diminutif de l'unite
     * 
     * @var string
     */
    private $diminutif;

    /**
     * Date d'archivage de l'unite
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Méthode permettant de récupérer l'identifiant de l'unite
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom de l'unite
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer le diminutif de l'unite
     * 
     * @return string
     */
    public function getDiminutif()
    {
        return $this->diminutif;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage de l'unite
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'unite
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le nom de l'unite
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier le diminutif de l'unite
     * 
     * @param string $diminutif
     * @return void
     */
    public function setDiminutif($diminutif)
    {
        $this->diminutif = $diminutif;
    }

    /**
     * Méthode permettant de modifier la date d'archivage de l'unite
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }
}
