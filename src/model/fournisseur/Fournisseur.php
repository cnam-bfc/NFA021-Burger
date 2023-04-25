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
     * Méthode permettant de définir l'identifiant du fournisseur
     *
     * @param int $idFournisseur Identifiant du fournisseur
     * @return void
     */
    public function setIdFournisseur($idFournisseur)
    {
        $this->idFournisseur = $idFournisseur;
    }

    /**
     * Méthode permettant de définir le nom du fournisseur
     *
     * @param string $nomFournisseur Nom du fournisseur
     * @return void
     */
    public function setNomFournisseur($nomFournisseur)
    {
        $this->nomFournisseur = $nomFournisseur;
    }
}
