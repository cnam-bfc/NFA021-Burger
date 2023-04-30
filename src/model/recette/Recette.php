<?php

/**
 * Objet Recette
 */
class Recette
{
    /**
     * Identifiant de la recette
     * 
     * @var int
     */
    private $id;

    /**
     * Nom de la recette
     *
     * @var string
     */
    private $nom;

    /**
     * Description de la recette
     * 
     * @var string
     */
    private $description;

    /**
     * Prix de la recette
     * 
     * @var double
     */
    private $prix;

    /**
     * Date d'archivage de la recette
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Méthode permettant de récupérer l'identifiant de la recette
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom de la recette
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer la description de la recette
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Méthode permettant de récupérer le prix de la recette
     * 
     * @return double
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage de la recette
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette
     * 
     * @param int $idRecette
     * @return void
     */
    public function setId($idRecette)
    {
        $this->id = $idRecette;
    }

    /**
     * Méthode permettant de modifier le nom de la recette
     * 
     * @param string $nomRecette
     * @return void
     */
    public function setNom($nomRecette)
    {
        $this->nom = $nomRecette;
    }

    /**
     * Méthode permettant de modifier la description de la recette
     * 
     * @param string $descriptionRecette
     * @return void
     */
    public function setDescription($descriptionRecette)
    {
        $this->description = $descriptionRecette;
    }

    /**
     * Méthode permettant de modifier le prix de la recette
     * 
     * @param double $prixRecette
     * @return void
     */
    public function setPrix($prixRecette)
    {
        $this->prix = $prixRecette;
    }

    /**
     * Méthode permettant de modifier la date d'archivage de la recette
     * 
     * @param string $dateArchiveRecette
     * @return void
     */
    public function setDateArchive($dateArchiveRecette)
    {
        $this->dateArchive = $dateArchiveRecette;
    }
}
