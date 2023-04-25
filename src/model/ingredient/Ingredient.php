<?php

/**
 * Objet Ingredient
 */
class Ingredient
{
    /**
     * Identifiant de l'ingrédient
     *
     * @var int
     */
    private $idIngredient;

    /**
     * Nom de l'ingrédient
     * 
     * @var string
     */
    private $nomIngredient;

    /**
     * Quantité de l'ingrédient en stock
     *
     * @var int
     */
    private $quantiteStockIngredient;

    /**
     * Chemin vers la photo de l'ingrédient
     *
     * @var string
     */
    private $photoIngredient;

    /**
     * Chemin vers la photo éclatée de l'ingrédient
     *
     * @var string
     */
    private $photoEclateeIngredient;

    /**
     * Dernière date d'inventaire de l'ingrédient
     *
     * @var string
     */
    private $dateInventaireIngredient;

    /**
     * Indique si l'ingrédient est en stock automatique
     *
     * @var boolean
     */
    private $stockAutoIngredient;

    /**
     * Quantité standard de l'ingrédient
     *
     * @var int
     */
    private $quantiteStandard;

    /**
     * Quantité minimum de l'ingrédient
     *
     * @var int
     */
    private $quantiteMinimum;

    /**
     * Date d'archivage de l'ingrédient
     *
     * @var string
     */
    private $dateArchiveIngredient;

    /**
     * Identifiant du fournisseur de l'ingrédient (clé étrangère)
     * 
     * @var int
     */
    private $idFournisseurFK;

    /**
     * Identifiant de l'unité de l'ingrédient (clé étrangère)
     *
     * @var int
     */
    private $idUniteFK;

    /**
     * Méthode permettant de récupérer l'identifiant de l'ingrédient
     *
     * @return int
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Méthode permettant de récupérer le nom de l'ingrédient
     *
     * @return string
     */
    public function getNomIngredient()
    {
        return $this->nomIngredient;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingrédient en stock
     *
     * @return int
     */
    public function getQuantiteStockIngredient()
    {
        return $this->quantiteStockIngredient;
    }

    /**
     * Méthode permettant de récupérer le chemin vers la photo de l'ingrédient
     *
     * @return string
     */
    public function getPhotoIngredient()
    {
        return $this->photoIngredient;
    }

    /**
     * Méthode permettant de récupérer le chemin vers la photo éclatée de l'ingrédient
     *
     * @return string
     */
    public function getPhotoEclateeIngredient()
    {
        return $this->photoEclateeIngredient;
    }

    /**
     * Méthode permettant de récupérer la dernière date d'inventaire de l'ingrédient
     *
     * @return string
     */
    public function getDateInventaireIngredient()
    {
        return $this->dateInventaireIngredient;
    }

    /**
     * Méthode permettant de récupérer l'indicateur de stock automatique de l'ingrédient
     *
     * @return boolean
     */
    public function getStockAutoIngredient()
    {
        return $this->stockAutoIngredient;
    }

    /**
     * Méthode permettant de récupérer la quantité standard de l'ingrédient
     *
     * @return int
     */
    public function getQuantiteStandard()
    {
        return $this->quantiteStandard;
    }

    /**
     * Méthode permettant de récupérer la quantité minimum de l'ingrédient
     *
     * @return int
     */
    public function getQuantiteMinimum()
    {
        return $this->quantiteMinimum;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage de l'ingrédient
     *
     * @return string
     */
    public function getDateArchiveIngredient()
    {
        return $this->dateArchiveIngredient;
    }

    /**
     * Méthode permettant de récupérer l'identifiant du fournisseur de l'ingrédient
     *
     * @return int
     */
    public function getIdFournisseurFK()
    {
        return $this->idFournisseurFK;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de l'unité de l'ingrédient
     *
     * @return int
     */
    public function getIdUniteFK()
    {
        return $this->idUniteFK;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'ingrédient
     *
     * @param int $idIngredient
     * @return void
     */
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = $idIngredient;
    }

    /**
     * Méthode permettant de modifier le nom de l'ingrédient
     *
     * @param string $nomIngredient
     * @return void
     */
    public function setNomIngredient($nomIngredient)
    {
        $this->nomIngredient = $nomIngredient;
    }

    /**
     * Méthode permettant de modifier la quantité de l'ingrédient en stock
     *
     * @param int $quantiteStockIngredient
     * @return void
     */
    public function setQuantiteStockIngredient($quantiteStockIngredient)
    {
        $this->quantiteStockIngredient = $quantiteStockIngredient;
    }

    /**
     * Méthode permettant de modifier le chemin vers la photo de l'ingrédient
     *
     * @param string $photoIngredient
     * @return void
     */
    public function setPhotoIngredient($photoIngredient)
    {
        $this->photoIngredient = $photoIngredient;
    }

    /**
     * Méthode permettant de modifier le chemin vers la photo éclatée de l'ingrédient
     *
     * @param string $photoEclateeIngredient
     * @return void
     */
    public function setPhotoEclateeIngredient($photoEclateeIngredient)
    {
        $this->photoEclateeIngredient = $photoEclateeIngredient;
    }

    /**
     * Méthode permettant de modifier la dernière date d'inventaire de l'ingrédient
     *
     * @param string $dateInventaireIngredient
     * @return void
     */
    public function setDateInventaireIngredient($dateInventaireIngredient)
    {
        $this->dateInventaireIngredient = $dateInventaireIngredient;
    }

    /**
     * Méthode permettant de modifier l'indicateur de stock automatique de l'ingrédient
     *
     * @param boolean $stockAutoIngredient
     * @return void
     */
    public function setStockAutoIngredient($stockAutoIngredient)
    {
        $this->stockAutoIngredient = $stockAutoIngredient;
    }

    /**
     * Méthode permettant de modifier la quantité standard de l'ingrédient
     *
     * @param int $quantiteStandard
     * @return void
     */
    public function setQuantiteStandard($quantiteStandard)
    {
        $this->quantiteStandard = $quantiteStandard;
    }

    /**
     * Méthode permettant de modifier la quantité minimum de l'ingrédient
     *
     * @param int $quantiteMinimum
     * @return void
     */
    public function setQuantiteMinimum($quantiteMinimum)
    {
        $this->quantiteMinimum = $quantiteMinimum;
    }

    /**
     * Méthode permettant de modifier la date d'archivage de l'ingrédient
     *
     * @param string $dateArchiveIngredient
     * @return void
     */
    public function setDateArchiveIngredient($dateArchiveIngredient)
    {
        $this->dateArchiveIngredient = $dateArchiveIngredient;
    }

    /**
     * Méthode permettant de modifier l'identifiant du fournisseur de l'ingrédient
     *
     * @param int $idFournisseurFK
     * @return void
     */
    public function setIdFournisseurFK($idFournisseurFK)
    {
        $this->idFournisseurFK = $idFournisseurFK;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'unité de l'ingrédient
     *
     * @param int $idUniteFK
     * @return void
     */
    public function setIdUniteFK($idUniteFK)
    {
        $this->idUniteFK = $idUniteFK;
    }
}
