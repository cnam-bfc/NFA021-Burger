<?php

/**
 * Objet CommandeClientLivraison
 */
class CommandeClientLivraison extends CommandeClient
{
    /**
     * Heure de livraison d'une commande d'un client (date et heure, format Y-m-d H:i:s)
     * 
     * @var string
     */
    private $heureLivraison;

    /**
     * Adresse OpenStreetMap type Nominatim à laquelle la commande d'un client doit être livrée
     * 
     * @var string
     */
    private $adresseOsmType;

    /**
     * Adresse OpenStreetMap id Nominatim à laquelle la commande d'un client doit être livrée
     * 
     * @var int
     */
    private $adresseOsmId;

    /**
     * Code postal auquel la commande d'un client doit être livrée
     * 
     * @var string
     */
    private $adresseCodePostal;

    /**
     * Ville à laquelle la commande d'un client doit être livrée
     * 
     * @var string
     */
    private $adresseVille;

    /**
     * Rue à laquelle la commande d'un client doit être livrée
     * 
     * @var string
     */
    private $adresseRue;

    /**
     * Numéro de rue à laquelle la commande d'un client doit être livrée
     * 
     * @var string
     */
    private $adresseNumero;

    /**
     * Identifiant du livreur qui doit livrer la commande d'un client
     * 
     * @var int
     */
    private $idLivreur;

    /**
     * Méthode permettant de récupérer l'heure de livraison d'une commande d'un client
     * 
     * @return string
     */
    public function getHeureLivraison()
    {
        return $this->heureLivraison;
    }

    /**
     * Méthode permettant de récupérer l'adresse OpenStreetMap type Nominatim à laquelle la commande d'un client doit être livrée
     * 
     * @return string
     */
    public function getAdresseOsmType()
    {
        return $this->adresseOsmType;
    }

    /**
     * Méthode permettant de récupérer l'adresse OpenStreetMap id Nominatim à laquelle la commande d'un client doit être livrée
     * 
     * @return int
     */
    public function getAdresseOsmId()
    {
        return $this->adresseOsmId;
    }

    /**
     * Méthode permettant de récupérer le code postal auquel la commande d'un client doit être livrée
     * 
     * @return string
     */
    public function getAdresseCodePostal()
    {
        return $this->adresseCodePostal;
    }

    /**
     * Méthode permettant de récupérer la ville à laquelle la commande d'un client doit être livrée
     * 
     * @return string
     */
    public function getAdresseVille()
    {
        return $this->adresseVille;
    }

    /**
     * Méthode permettant de récupérer la rue à laquelle la commande d'un client doit être livrée
     * 
     * @return string
     */
    public function getAdresseRue()
    {
        return $this->adresseRue;
    }

    /**
     * Méthode permettant de récupérer le numéro de rue à laquelle la commande d'un client doit être livrée
     * 
     * @return string
     */
    public function getAdresseNumero()
    {
        return $this->adresseNumero;
    }

    /**
     * Méthode permettant de récupérer l'identifiant du livreur qui doit livrer la commande d'un client
     * 
     * @return int
     */
    public function getIdLivreur()
    {
        return $this->idLivreur;
    }

    /**
     * Méthode permettant de modifier l'heure de livraison d'une commande d'un client
     * 
     * @param string $heureLivraison (Date et heure au format Y-m-d H:i:s)
     * @return void
     */
    public function setHeureLivraison($heureLivraison)
    {
        $this->heureLivraison = $heureLivraison;
    }

    /**
     * Méthode permettant de modifier l'adresse OpenStreetMap type Nominatim à laquelle la commande d'un client doit être livrée
     * 
     * @param string $adresseOsmType
     * @return void
     */
    public function setAdresseOsmType($adresseOsmType)
    {
        $this->adresseOsmType = $adresseOsmType;
    }

    /**
     * Méthode permettant de modifier l'adresse OpenStreetMap id Nominatim à laquelle la commande d'un client doit être livrée
     * 
     * @param int $adresseOsmId
     * @return void
     */
    public function setAdresseOsmId($adresseOsmId)
    {
        $this->adresseOsmId = $adresseOsmId;
    }

    /**
     * Méthode permettant de modifier le code postal auquel la commande d'un client doit être livrée
     * 
     * @param string $adresseCodePostal
     * @return void
     */
    public function setAdresseCodePostal($adresseCodePostal)
    {
        $this->adresseCodePostal = $adresseCodePostal;
    }

    /**
     * Méthode permettant de modifier la ville à laquelle la commande d'un client doit être livrée
     * 
     * @param string $adresseVille
     * @return void
     */
    public function setAdresseVille($adresseVille)
    {
        $this->adresseVille = $adresseVille;
    }

    /**
     * Méthode permettant de modifier la rue à laquelle la commande d'un client doit être livrée
     * 
     * @param string $adresseRue
     * @return void
     */
    public function setAdresseRue($adresseRue)
    {
        $this->adresseRue = $adresseRue;
    }

    /**
     * Méthode permettant de modifier le numéro de rue à laquelle la commande d'un client doit être livrée
     * 
     * @param string $adresseNumero
     * @return void
     */
    public function setAdresseNumero($adresseNumero)
    {
        $this->adresseNumero = $adresseNumero;
    }

    /**
     * Méthode permettant de modifier l'identifiant du livreur qui doit livrer la commande d'un client
     * 
     * @param int $idLivreur
     * @return void
     */
    public function setIdLivreur($idLivreur)
    {
        $this->idLivreur = $idLivreur;
    }
}
