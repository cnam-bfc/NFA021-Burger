<?php

/**
 * Objet Ingredient
 */
class Ingredient
{
    /**
     * Identifiant de l'ingredient
     * 
     * @var int
     */
    private $id;

    /**
     * Nom de l'ingredient
     *
     * @var string
     */
    private $nom;

    /**
     * Afficher dans la vue éclatée
     * 
     * @var bool
     */
    private $afficherVueEclatee;

    /**
     * Quantité en stock de l'ingredient
     * 
     * @var int
     */
    private $quantiteStock;

    /**
     * Stock automatique de l'ingredient
     * 
     * @var bool
     */
    private $stockAuto;

    /**
     * Quanité standard du stock automatique de l'ingredient
     * 
     * @var int
     */
    private $quantiteStandardStockAuto;

    /**
     * Quantité minimale du stock automatique de l'ingredient
     * 
     * @var int
     */
    private $quantiteMinimaleStockAuto;

    /**
     * Prix de l'ingredient auprès du fournisseur
     * 
     * @var float
     */
    private $prixFournisseur;

    /**
     * Date du dernier inventaire de l'ingredient
     * 
     * @var string
     */
    private $dateDernierInventaire;

    /**
     * Date d'archivage de l'ingredient
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Identifiant de l'unite de l'ingredient
     * 
     * @var int
     */
    private $idUnite;

    /**
     * Identifiant du fournisseur de l'ingredient
     * 
     * @var int
     */
    private $idFournisseur;

    /**
     * Méthode permettant de récupérer l'identifiant de l'ingredient
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom de l'ingredient
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer si l'ingredient doit être affiché dans la vue éclatée
     * 
     * @return bool
     */
    public function isAfficherVueEclatee()
    {
        return $this->afficherVueEclatee;
    }

    /**
     * Méthode permettant de récupérer la quantité en stock de l'ingredient
     * 
     * @return int
     */
    public function getQuantiteStock()
    {
        return $this->quantiteStock;
    }

    /**
     * Méthode permettant de récupérer si le stock de l'ingredient est géré de façon automatique
     * 
     * @return bool
     */
    public function isStockAuto()
    {
        return $this->stockAuto;
    }

    /**
     * Méthode permettant de récupérer la quantité standard du stock automatique de l'ingredient
     * 
     * @return int
     */
    public function getQuantiteStandardStockAuto()
    {
        return $this->quantiteStandardStockAuto;
    }

    /**
     * Méthode permettant de récupérer la quantité minimale du stock automatique de l'ingredient
     * 
     * @return int
     */
    public function getQuantiteMinimaleStockAuto()
    {
        return $this->quantiteMinimaleStockAuto;
    }

    /**
     * Méthode permettant de récupérer le prix de l'ingredient auprès du fournisseur
     * 
     * @return float
     */
    public function getPrixFournisseur()
    {
        return $this->prixFournisseur;
    }

    /**
     * Méthode permettant de récupérer la date du dernier inventaire de l'ingredient
     * 
     * @return string
     */
    public function getDateDernierInventaire()
    {
        return $this->dateDernierInventaire;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage de l'ingredient
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de l'unite de l'ingredient
     * 
     * @return int
     */
    public function getIdUnite()
    {
        return $this->idUnite;
    }

    /**
     * Méthode permettant de récupérer l'identifiant du fournisseur de l'ingredient
     *
     * @return int
     */
    public function getIdFournisseur()
    {
        return $this->idFournisseur;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'ingredient
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le nom de l'ingredient
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier si l'ingredient doit être affiché dans la vue éclatée
     * 
     * @param bool $afficherVueEclatee
     * @return void
     */
    public function setAfficherVueEclatee($afficherVueEclatee)
    {
        $this->afficherVueEclatee = (bool) $afficherVueEclatee;
    }

    /**
     * Méthode permettant de modifier la quantité en stock de l'ingredient
     * 
     * @param int $quantiteStock
     * @return void
     */
    public function setQuantiteStock($quantiteStock)
    {
        $this->quantiteStock = (int) $quantiteStock;
    }

    /**
     * Méthode permettant de modifier si le stock de l'ingredient est géré de façon automatique
     * 
     * @param bool $stockAuto
     * @return void
     */
    public function setStockAuto($stockAuto)
    {
        $this->stockAuto = (bool) $stockAuto;
    }

    /**
     * Méthode permettant de modifier la quantité standard du stock automatique de l'ingredient
     * 
     * @param int $quantiteStandardStockAuto
     * @return void
     */
    public function setQuantiteStandardStockAuto($quantiteStandardStockAuto)
    {
        $this->quantiteStandardStockAuto = (int) $quantiteStandardStockAuto;
    }

    /**
     * Méthode permettant de modifier la quantité minimale du stock automatique de l'ingredient
     * 
     * @param int $quantiteMinimaleStockAuto
     * @return void
     */
    public function setQuantiteMinimaleStockAuto($quantiteMinimaleStockAuto)
    {
        $this->quantiteMinimaleStockAuto = (int) $quantiteMinimaleStockAuto;
    }

    /**
     * Méthode permettant de modifier le prix de l'ingredient auprès du fournisseur
     * 
     * @param float $prixFournisseur
     * @return void
     */
    public function setPrixFournisseur($prixFournisseur)
    {
        $this->prixFournisseur = (float) $prixFournisseur;
    }

    /**
     * Méthode permettant de modifier la date du dernier inventaire de l'ingredient
     * 
     * @param string $dateDernierInventaire
     * @return void
     */
    public function setDateDernierInventaire($dateDernierInventaire)
    {
        $this->dateDernierInventaire = $dateDernierInventaire;
    }

    /**
     * Méthode permettant de modifier la date d'archivage de l'ingredient
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'unite de l'ingredient
     * 
     * @param int $idUnite
     * @return void
     */
    public function setIdUnite($idUnite)
    {
        $this->idUnite = (int) $idUnite;
    }

    /**
     * Méthode permettant de modifier l'identifiant du fournisseur de l'ingredient
     * 
     * @param int $idFournisseur
     * @return void
     */
    public function setIdFournisseur($idFournisseur)
    {
        $this->idFournisseur = (int) $idFournisseur;
    }
}
