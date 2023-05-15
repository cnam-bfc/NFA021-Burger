<?php

/**
 * Objet CommandeFournisseur
 */
class CommandeFournisseur
{
    /**
     * Identifiant d'une commande chez un fournisseur
     * 
     * @var int
     */
    private $id;

    /**
     * Date d'une commande chez un fournisseur
     *
     * @var int
     */
    private $etat;

    /**
     * Date d'une commande chez un fournisseur
     *
     * @var string
     */
    private $dateCommande;

    /**
     * Date d'archivage d'une commande chez un fournisseur
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Identifiant du fournisseur d'une commande chez un fournisseur
     * 
     * @var int
     */
    private $idFournisseur;

    /**
     * Méthode permettant de récupérer l'identifiant d'une commande chez un fournisseur
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer l'identifiant d'une commande chez un fournisseur
     * 
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Méthode permettant de récupérer la date d'une commande chez un fournisseur
     * 
     * @return string
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage d'une commande chez un fournisseur
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de récupérer l'identifiant du fournisseur d'une commande chez un fournisseur
     * 
     * @return int
     */
    public function getIdFournisseur()
    {
        return $this->idFournisseur;
    }

    /**
     * Méthode permettant de modifier l'identifiant d'une commande chez un fournisseur
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier l'identifiant d'une commande chez un fournisseur
     * 
     * @param int $id
     * @return void
     */
    public function setEtat($etat)
    {
        $this->id = (int) $etat;
    }

    /**
     * Méthode permettant de modifier la date d'une commande chez un fournisseur
     * 
     * @param string $dateCommande
     * @return void
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
    }

    /**
     * Méthode permettant de modifier la date d'archivage d'une commande chez un fournisseur
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant du fournisseur d'une commande chez un fournisseur
     * 
     * @param int $idFournisseur
     * @return void
     */
    public function setIdFournisseur($idFournisseur)
    {
        $this->idFournisseur = (int) $idFournisseur;
    }
}
