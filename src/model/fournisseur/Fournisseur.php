<?php

/**
 * Objet Fournisseur
 */
class Fournisseur
{
    /**
     * Identifiant du fournisseur
     *
     * @var int
     */
    private $idFournisseur;

    /**
     * Nom du fournisseur
     * 
     * @var string
     */
    private $nomFournisseur;

    /**
     * Méthode permettant d'instancier un objet de la classe Fournisseur
     *
     * @param int $idFournisseur @param string $nomFournisseur
     * @return void
     */
    function __construct ($idFournisseur, $nomFournisseur) {
        $this->setIdFournisseur($idFournisseur);
        $this->setNomFournisseur($nomFournisseur);
    }

    /**
     * Méthode permettant de récupérer l'identifiant du fournisseur
     *
     * @return int
     */
    public function getIdFournisseur()
    {
        return $this->idFournisseur;
    }

    /**
     * Méthode permettant de récupérer le nom du fournisseur
     *
     * @return string
     */
    public function getNomFournisseur()
    {
        return $this->nomFournisseur;
    }

    /**
     * Méthode permettant de modifier l'identifiant du fournisseur
     *
     * @param int $idFournisseur
     * @return void
     */
    public function setIdFournisseur($idFournisseur)
    {
        $this->idFournisseur = $idFournisseur;
    }

    /**
     * Méthode permettant de modifier le nom du fournisseur
     *
     * @param string $nomFournisseur
     * @return void
     */
    public function setNomFournisseur($nomFournisseur)
    {
        $this->nomFournisseur = $nomFournisseur;
    }
}
