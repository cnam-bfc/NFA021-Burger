<?php

/**
 * Objet RecetteSelectionMultiple
 */
class RecetteSelectionMultiple
{
    /**
     * Identifiant d'une sélection multiple d'une recette
     * 
     * @var int
     */
    private $id;

    /**
     * Ordre d'une sélection multiple d'une recette
     * 
     * @var int
     */
    private $ordre;

    /**
     * Quantité d'une sélection multiple d'une recette
     *
     * @var int
     */
    private $quantite;

    /**
     * Identifiant de la recette d'une sélection multiple d'une recette
     * 
     * @var int
     */
    private $idRecette;

    /**
     * Méthode permettant de récupérer l'identifiant d'une sélection multiple d'une recette
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer l'ordre d'une sélection multiple d'une recette
     * 
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Méthode permettant de récupérer la quantité d'une sélection multiple d'une recette
     * 
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de la recette d'une sélection multiple d'une recette
     * 
     * @return int
     */
    public function getIdRecette()
    {
        return $this->idRecette;
    }

    /**
     * Méthode permettant de modifier l'identifiant d'une sélection multiple d'une recette
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier l'ordre d'une sélection multiple d'une recette
     * 
     * @param int $ordre
     * @return void
     */
    public function setOrdre($ordre)
    {
        $this->ordre = (int) $ordre;
    }

    /**
     * Méthode permettant de modifier la quantité d'une sélection multiple d'une recette
     * 
     * @param int $quantite
     * @return void
     */
    public function setQuantite($quantite)
    {
        $this->quantite = (int) $quantite;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette d'une sélection multiple d'une recette
     * 
     * @param int $idRecette
     * @return void
     */
    public function setIdRecette($idRecette)
    {
        $this->idRecette = (int) $idRecette;
    }
}
