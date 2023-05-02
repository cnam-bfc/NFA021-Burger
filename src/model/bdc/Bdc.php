<?php

/**
 * Objet Fournisseur
 */
class Bdc
{
    /**
     * Identifiant du bdc
     *
     * @var int
     */
    private $idBdc;

    /**
     * Etat du bdc
     *
     * @var boolean
     */
    private $etatBdc;

    /**
     * Date de création du bdc
     * 
     * @var string
     */
    private $dateCreationBdc;

    /**
     * Date de création du bdc
     * 
     * @var string
     */
    private $dateArchiveBdc;

    /**
     * Date de création du bdc
     * 
     * @var int
     */
    private $idFournisseurFK;

    /**
     * Méthode permettant de récupérer l'identifiant du bdc
     *
     * @return int
     */
    public function getIdBdc()
    {
        return $this->idBdc;
    }

    /**
     * Méthode permettant de récupérer l'etat du bdc
     *
     * @return int
     */
    public function getEtatBdc()
    {
        return $this->etatBdc;
    }

    /**
     * Méthode permettant de récupérer le nom du bdc
     *
     * @return string
     */
    public function getDateCreationBdc()
    {
        return $this->dateCreationBdc;
    }

    /**
     * Méthode permettant de récupérer le nom du bdc
     *
     * @return string
     */
    public function getDateArchiveBdc()
    {
        return $this->dateArchiveBdc;
    }

    /**
     * Méthode permettant de récupérer le nom du bdc
     *
     * @return string
     */
    public function getIdFournisseurFK()
    {
        return $this->idFournisseurFK;
    }

    /**
     * Méthode permettant de modifier l'identifiant du bdc
     *
     * @param int $idBdc
     * @return void
     */
    public function setIdBdc($idBdc)
    {
        $this->idBdc = $idBdc;
    }

    /**
     * Méthode permettant de modifier l'etat du bdc
     *
     * @param int $etatBdc
     * @return void
     */
    public function setEtatBdc($etatBdc)
    {
        $this->etatBdc = $etatBdc;
    }

    /**
     * Méthode permettant de modifier la date création du bdc
     *
     * @param string $dateCreationBdc
     * @return void
     */
    public function setDateCreationBdc($dateCreationBdc)
    {
        $this->dateCreationBdc = $dateCreationBdc;
    }

    /**
     * Méthode permettant de modifier le nom du bdc
     *
     * @param string $dateArchiveBdc
     * @return void
     */
    public function setDateArchiveBdc($dateArchiveBdc)
    {
        $this->dateCreationBdc = $dateArchiveBdc;
    }

    /**
     * Méthode permettant de modifier le nom du bdc
     *
     * @param string $idFournisseurFK
     * @return void
     */
    public function setIdFournisseurFK($idFournisseurFK)
    {
        $this->idFournisseurFK = $idFournisseurFK;
    }
}
