<?php

/**
 * Objet RecetteFinaleIngredient
 */
class RecetteFinaleIngredient
{
    /**
     * Identifiant
     *
     * @var int
     */
    private $id;

    /**
     * Ordre de l'ingrédient dans la recette
     * 
     * @var int
     */
    private $ordre;

    /**
     * Quantité de l'ingrédient
     * 
     * @var int
     */
    private $quantite;

    /**
     * Identifiant de la recette finale
     * 
     * @var int
     */
    private $idRecetteFinale;

    /**
     * Identifiant de l'ingrédient
     * 
     * @var int
     */
    private $idIngredient;

    /**
     * Méthode permettant de récupérer l'identifiant
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Méthode permettant de récupérer la quantité de l'ingrédient
     * 
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
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
     * Méthode permettant de récupérer l'identifiant de l'ingrédient
     * 
     * @return int
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Méthode permettant de modifier l'identifiant
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
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
     * Méthode permettant de modifier l'identifiant de l'ingrédient
     * 
     * @param int $idIngredient
     * @return void
     */
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = (int) $idIngredient;
    }
}
