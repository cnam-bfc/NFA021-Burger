<?php

/**
 * Objet CommandeFournisseurIngredient
 */
class CommandeFournisseurIngredient
{
    /**
     * Identifiant de l'ingrédient
     * 
     * @var int
     */
    private $idIngredient;

    /**
     * Identifiant de la commande fournisseur
     * 
     * @var int
     */
    private $idCommandeFournisseur;

    /**
     * Quantité de l'ingrédient commandé auprès du fournisseur
     * 
     * @var int
     */
    private $quantiteCommandee;

    /**
     * Quantité de l'ingrédient reçue du fournisseur
     * 
     * @var int
     */
    private $quantiteRecue;

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
     * Méthode permettant de récupérer l'identifiant de la commande fournisseur
     * 
     * @return int
     */
    public function getIdCommandeFournisseur()
    {
        return $this->idCommandeFournisseur;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingrédient commandé auprès du fournisseur
     * 
     * @return int
     */
    public function getQuantiteCommandee()
    {
        return $this->quantiteCommandee;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingrédient reçue du fournisseur
     * 
     * @return int
     */
    public function getQuantiteRecue()
    {
        return $this->quantiteRecue;
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
     * Méthode permettant de modifier l'identifiant de la commande fournisseur
     * 
     * @param int $idCommandeFournisseur
     * @return void
     */
    public function setIdCommandeFournisseur($idCommandeFournisseur)
    {
        $this->idCommandeFournisseur = (int) $idCommandeFournisseur;
    }

    /**
     * Méthode permettant de modifier la quantité de l'ingrédient commandé auprès du fournisseur
     * 
     * @param int $quantiteCommandee
     * @return void
     */
    public function setQuantiteCommandee($quantiteCommandee)
    {
        $this->quantiteCommandee = (int) $quantiteCommandee;
    }

    /**
     * Méthode permettant de modifier la quantité de l'ingrédient reçue du fournisseur
     * 
     * @param int $quantiteRecue
     * @return void
     */
    public function setQuantiteRecue($quantiteRecue)
    {
        $this->quantiteRecue = (int) $quantiteRecue;
    }
}
