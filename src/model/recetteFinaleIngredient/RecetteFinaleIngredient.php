<?php

/**
 * Objet RecetteFinaleIngredient
 */
class RecetteFinaleIngredient
{
    /**
     * Identifiant de l'ingrédient
     * 
     * @var int
     */
    private $idIngredient;

    /**
     * Identifiant de la recette finale
     * 
     * @var int
     */
    private $idRecetteFinale;

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
     * Méthode permettant de récupérer l'identifiant de la recette finale
     * 
     * @return int
     */
    public function getIdRecetteFinale()
    {
        return $this->idRecetteFinale;
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
     * Méthode permettant de modifier l'identifiant de la recette finale
     * 
     * @param int $idRecetteFinale
     * @return void
     */
    public function setIdRecetteFinale($idRecetteFinale)
    {
        $this->idRecetteFinale = (int) $idRecetteFinale;
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
