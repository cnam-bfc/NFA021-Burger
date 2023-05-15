<?php

/**
 * Objet RecetteIngredientOptionnel
 */
class RecetteIngredientOptionnel
{
    /**
     * Identifiant de la recette
     * 
     * @var int
     */
    private $idRecette;

    /**
     * Identifiant de l'ingrédient
     * 
     * @var int
     */
    private $idIngredient;

    /**
     * Quantité de l'ingrédient
     * 
     * @var int
     */
    private $quantite;

    /**
     * Prix de l'ingrédient
     * 
     * @var float
     */
    private $prix;

    /**
     * Ordre de l'ingrédient dans la recette
     * 
     * @var int
     */
    private $ordre;

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
     * Méthode permettant de récupérer l'identifiant de l'ingrédient
     * 
     * @return int
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingrédient
     * 
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Méthode permettant de récupérer le prix de l'ingrédient
     * 
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Méthode permettant de récupérer l'ordre de l'ingrédient dans la recette
     * 
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette
     * 
     * @param int $idRecette
     * @return void
     */
    public function setIdRecette($idRecette)
    {
        $this->idRecette = (int) $idRecette;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'ingrédient
     * 
     * @param int $idIngredient
     * @return void
     */
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = (int) $idIngredient;
    }

    /**
     * Méthode permettant de modifier la quantité de l'ingrédient
     * 
     * @param int $quantite
     * @return void
     */
    public function setQuantite($quantite)
    {
        $this->quantite = (int) $quantite;
    }

    /**
     * Méthode permettant de modifier le prix de l'ingrédient
     *
     * @param float $prix
     * @return void
     */
    public function setPrix($prix)
    {
        $this->prix = (float) $prix;
    }

    /**
     * Méthode permettant de modifier l'ordre de l'ingrédient dans la recette
     * 
     * @param int $ordre
     * @return void
     */
    public function setOrdre($ordre)
    {
        $this->ordre = (int) $ordre;
    }
}
