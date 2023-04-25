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
     * Méthode permettant d'instancier un objet de la classe Bdc
     *
     * @param int $idBdc @param string $nomBdc
     * @return void
     */
    function __construct ($idBdc, $dateCreationBdc) {
        $this->setIdBdc($idBdc);
        $this->setDateCreationBdc($dateCreationBdc);
        $this->setDateCreationBdc($dateCreationBdc);
    }

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
        $this->dateCreationBdc = $idFournisseurFK;
    }
}
