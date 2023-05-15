<?php

/**
 * Objet CommandeClient
 */
class CommandeClient
{
    /**
     * Identifiant d'une commande d'un client
     * 
     * @var int
     */
    private $id;

    /**
     * Prix d'une commande d'un client
     * 
     * @var float
     */
    private $prix;

    /**
     * Date d'une commande d'un client
     *
     * @var string
     */
    private $dateCommande;

    /**
     * Date à laquelle la commande d'un client est prête
     * 
     * @var string
     */
    private $datePret;

    /**
     * Date d'archivage d'une commande d'un client
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Identifiant de l'emballage d'une commande d'un client
     * 
     * @var int
     */
    private $idEmballage;

    /**
     * Identifiant du client d'une commande d'un client
     * 
     * @var int
     */
    private $idClient;

    /**
     * Méthode permettant de récupérer l'identifiant d'une commande d'un client
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le prix d'une commande d'un client
     * 
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Méthode permettant de récupérer la date d'une commande d'un client
     * 
     * @return string
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Méthode permettant de récupérer la date à laquelle la commande d'un client est prête
     * 
     * @return string
     */
    public function getDatePret()
    {
        return $this->datePret;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage d'une commande d'un client
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de l'emballage d'une commande d'un client
     * 
     * @return int
     */
    public function getIdEmballage()
    {
        return $this->idEmballage;
    }

    /**
     * Méthode permettant de récupérer l'identifiant du client d'une commande d'un client
     * 
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Méthode permettant de modifier l'identifiant d'une commande d'un client
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le prix d'une commande d'un client
     * 
     * @param float $prix
     * @return void
     */
    public function setPrix($prix)
    {
        $this->prix = (float) $prix;
    }

    /**
     * Méthode permettant de modifier la date d'une commande d'un client
     * 
     * @param string $dateCommande
     * @return void
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
    }

    /**
     * Méthode permettant de modifier la date à laquelle la commande d'un client est prête
     *
     * @param string $datePret
     * @return void
     */
    public function setDatePret($datePret)
    {
        $this->datePret = $datePret;
    }

    /**
     * Méthode permettant de modifier la date d'archivage d'une commande d'un client
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'emballage d'une commande d'un client
     * 
     * @param int $idEmballage
     * @return void
     */
    public function setIdEmballage($idEmballage)
    {
        $this->idEmballage = (int) $idEmballage;
    }

    /**
     * Méthode permettant de modifier l'identifiant du client d'une commande d'un client
     * 
     * @param int $idClient
     * @return void
     */
    public function setIdClient($idClient)
    {
        $this->idClient = (int) $idClient;
    }
}
