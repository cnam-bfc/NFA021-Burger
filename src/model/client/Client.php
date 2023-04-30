<?php

/**
 * Objet Client
 */
class Client extends Compte
{
    /**
     * Nom du client
     * 
     * @var string
     */
    private $nom;

    /**
     * Prénom du client
     * 
     * @var string
     */
    private $prenom;

    /**
     * Téléphone du client
     * 
     * @var string
     */
    private $telephone;

    /**
     * Adresse OpenStreetMap type Nominatim du client
     * 
     * @var string
     */
    private $adresseOsmType;

    /**
     * Adresse OpenStreetMap id Nominatim du client
     * 
     * @var int
     */
    private $adresseOsmId;

    /**
     * Code postal du client
     * 
     * @var string
     */
    private $adresseCodePostal;

    /**
     * Ville du client
     * 
     * @var string
     */
    private $adresseVille;

    /**
     * Rue du client
     * 
     * @var string
     */
    private $adresseRue;

    /**
     * Numéro de rue du client
     * 
     * @var string
     */
    private $adresseNumero;

    /**
     * Méthode permettant de récupérer le nom du client
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer le prénom du client
     * 
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Méthode permettant de récupérer le téléphone du client
     * 
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Méthode permettant de récupérer l'adresse OpenStreetMap type Nominatim du client
     * 
     * @return string
     */
    public function getAdresseOsmType()
    {
        return $this->adresseOsmType;
    }

    /**
     * Méthode permettant de récupérer l'adresse OpenStreetMap id Nominatim du client
     * 
     * @return int
     */
    public function getAdresseOsmId()
    {
        return $this->adresseOsmId;
    }

    /**
     * Méthode permettant de récupérer le code postal du client
     * 
     * @return string
     */
    public function getAdresseCodePostal()
    {
        return $this->adresseCodePostal;
    }

    /**
     * Méthode permettant de récupérer la ville du client
     * 
     * @return string
     */
    public function getAdresseVille()
    {
        return $this->adresseVille;
    }

    /**
     * Méthode permettant de récupérer la rue du client
     * 
     * @return string
     */
    public function getAdresseRue()
    {
        return $this->adresseRue;
    }

    /**
     * Méthode permettant de récupérer le numéro de rue du client
     * 
     * @return string
     */
    public function getAdresseNumero()
    {
        return $this->adresseNumero;
    }

    /**
     * Méthode permettant de modifier le nom du client
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier le prénom du client
     * 
     * @param string $prenom
     * @return void
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Méthode permettant de modifier le téléphone du client
     * 
     * @param string $telephone
     * @return void
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Méthode permettant de modifier l'adresse OpenStreetMap type Nominatim du client
     * 
     * @param string $adresseOsmType
     * @return void
     */
    public function setAdresseOsmType($adresseOsmType)
    {
        $this->adresseOsmType = $adresseOsmType;
    }

    /**
     * Méthode permettant de modifier l'adresse OpenStreetMap id Nominatim du client
     * 
     * @param int $adresseOsmId
     * @return void
     */
    public function setAdresseOsmId($adresseOsmId)
    {
        $this->adresseOsmId = $adresseOsmId;
    }

    /**
     * Méthode permettant de modifier le code postal du client
     * 
     * @param string $adresseCodePostal
     * @return void
     */
    public function setAdresseCodePostal($adresseCodePostal)
    {
        $this->adresseCodePostal = $adresseCodePostal;
    }

    /**
     * Méthode permettant de modifier la ville du client
     * 
     * @param string $adresseVille
     * @return void
     */
    public function setAdresseVille($adresseVille)
    {
        $this->adresseVille = $adresseVille;
    }

    /**
     * Méthode permettant de modifier la rue du client
     * 
     * @param string $adresseRue
     * @return void
     */
    public function setAdresseRue($adresseRue)
    {
        $this->adresseRue = $adresseRue;
    }

    /**
     * Méthode permettant de modifier le numéro de rue du client
     * 
     * @param string $adresseNumero
     * @return void
     */
    public function setAdresseNumero($adresseNumero)
    {
        $this->adresseNumero = $adresseNumero;
    }
}
