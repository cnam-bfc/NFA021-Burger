<?php

/**
 * Objet IngredientRecetteBasique
 */
class IngredientRecetteBasique
{
    /**
     * Identifiant de la recette
     * 
     * @var int
     */
    private $idRecette;

    /**
     * Identifiant de l'ingredient
     * 
     * @var int
     */
    private $idIngredient;

    /**
     * Quantité de l'ingredient dans la recette
     * 
     * @var int
     */
    private $quantite;

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
     * Méthode permettant de récupérer l'identifiant de l'ingredient
     * 
     * @return int
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingredient dans la recette
     * 
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
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
     * Méthode permettant de modifier l'identifiant de l'ingredient
     * 
     * @param int $idIngredient
     * @return void
     */
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = $idIngredient;
    }

    /**
     * Méthode permettant de modifier la quantité de l'ingredient dans la recette
     * 
     * @param int $quantite
     * @return void
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }
}
