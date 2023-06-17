<?php

/**
 * Objet StatsAchatFournisseur
 */
class StatsAchatFournisseur
{
    /**
     * Identifiant du fournisseur
     * 
     * @var int
     */
    private $id;

    /**
     * Nom du fournisseur
     * 
     * @var string
     */
    private $nom;

    /**
     * quantité de commande passée au fournisseur
     * 
     * @var int
     */
    private $quantite;

    /**
     * Méthode permettant de récupérer l'identifiant du fournisseur
     * 
     * @return void
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de modifier l'identifiant du fournisseur
     * 
     * @param int $id Identifiant du fournisseur
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Méthode permettant de récupérer le nom du fournisseur
     * 
     * @return void
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de modifier le nom du fournisseur
     * 
     * @param string $nom Nom du fournisseur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de récupérer la quantité de commande passée au fournisseur
     * 
     * @return void
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Méthode permettant de modifier la quantité de commande passée au fournisseur
     * 
     * @param int $quantite Quantité de commande passée au fournisseur
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }
}
