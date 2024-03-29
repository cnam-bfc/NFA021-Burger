<?php

/**
 * Objet IngredientRecetteSelectionMultiple
 */
class IngredientRecetteSelectionMultiple
{
    /**
     * Identifiant de l'ingrédient
     * 
     * @var int
     */
    private $idIngredient;

    /**
     * Identifiant de la sélection multiple de la recette
     * 
     * @var int
     */
    private $idSelectionMultipleRecette;

    /**
     * Quantité de l'ingrédient
     * 
     * @var int
     */
    private $quantite;

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
     * Méthode permettant de récupérer l'identifiant de la sélection multiple de la recette
     * 
     * @return int
     */
    public function getIdSelectionMultipleRecette()
    {
        return $this->idSelectionMultipleRecette;
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
     * Méthode permettant de modifier l'identifiant de la sélection multiple de la recette
     * 
     * @param int $idSelectionMultipleRecette
     * @return void
     */
    public function setIdSelectionMultipleRecette($idSelectionMultipleRecette)
    {
        $this->idSelectionMultipleRecette = (int) $idSelectionMultipleRecette;
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
}
