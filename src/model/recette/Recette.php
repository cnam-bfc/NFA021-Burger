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
    private $idRecette;

    /**
     * Nom de la recette
     *
     * @var string
     */
    private $nomRecette;

    /**
     * Description de la recette
     * 
     * @var string
     */
    private $descriptionRecette;

    /**
     * Chemin vers la photo de la recette
     *
     * @var string
     */
    private $photoRecette;

    /**
     * Date d'archivage de la recette
     * 
     * @var string
     */
    private $dateArchiveRecette;

    /**
     * Prix de la recette
     * 
     * @var double
     */
    private $prixRecette;

    /**
     * Méthode permettant de récupérer l'identifiant de la recette
     * 
     * @return int
     */
    public function getIdRecette()
    {
        return $this->idRecette;
    }

    /**
     * Méthode permettant de récupérer le nom de la recette
     * 
     * @return string
     */
    public function getNomRecette()
    {
        return $this->nomRecette;
    }

    /**
     * Méthode permettant de récupérer la description de la recette
     * 
     * @return string
     */
    public function getDescriptionRecette()
    {
        return $this->descriptionRecette;
    }

    /**
     * Méthode permettant de récupérer le chemin vers la photo de la recette
     * 
     * @return string
     */
    public function getPhotoRecette()
    {
        return $this->photoRecette;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage de la recette
     * 
     * @return string
     */
    public function getDateArchiveRecette()
    {
        return $this->dateArchiveRecette;
    }

    /**
     * Méthode permettant de récupérer le prix de la recette
     * 
     * @return double
     */
    public function getPrixRecette()
    {
        return $this->prixRecette;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette
     * 
     * @param int $idRecette
     * @return void
     */
    public function setIdRecette($idRecette)
    {
        $this->idRecette = $idRecette;
    }

    /**
     * Méthode permettant de modifier le nom de la recette
     * 
     * @param string $nomRecette
     * @return void
     */
    public function setNomRecette($nomRecette)
    {
        $this->nomRecette = $nomRecette;
    }

    /**
     * Méthode permettant de modifier la description de la recette
     * 
     * @param string $descriptionRecette
     * @return void
     */
    public function setDescriptionRecette($descriptionRecette)
    {
        $this->descriptionRecette = $descriptionRecette;
    }

    /**
     * Méthode permettant de modifier le chemin vers la photo de la recette
     * 
     * @param string $photoRecette
     * @return void
     */
    public function setPhotoRecette($photoRecette)
    {
        $this->photoRecette = $photoRecette;
    }

    /**
     * Méthode permettant de modifier la date d'archivage de la recette
     * 
     * @param string $dateArchiveRecette
     * @return void
     */
    public function setDateArchiveRecette($dateArchiveRecette)
    {
        $this->dateArchiveRecette = $dateArchiveRecette;
    }

    /**
     * Méthode permettant de modifier le prix de la recette
     * 
     * @param double $prixRecette
     * @return void
     */
    public function setPrixRecette($prixRecette)
    {
        $this->prixRecette = $prixRecette;
    }
}
