<?php

/**
 * Objet MoyenTransport
 */
class MoyenTransport
{
    /**
     * Identifiant du moyen de transport
     * 
     * @var int
     */
    private $id;

    /**
     * Nom du moyen de transport
     *
     * @var string
     */
    private $nom;

    /**
     * Profil Open Source Routing Machine du moyen de transport
     * 
     * @var string
     */
    private $osrmProfile;

    /**
     * RouteXL type du moyen de transport
     * 
     * @var string
     */
    private $routeXLType;

    /**
     * Date d'archivage du moyen de transport
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Méthode permettant de récupérer l'identifiant du moyen de transport
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom du moyen de transport
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer le profil Open Source Routing Machine du moyen de transport
     * 
     * @return string
     */
    public function getOsrmProfile()
    {
        return $this->osrmProfile;
    }

    /**
     * Méthode permettant de récupérer le type RouteXL du moyen de transport
     * 
     * @return string
     */
    public function getRouteXLType()
    {
        return $this->routeXLType;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage du moyen de transport
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant du moyen de transport
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le nom du moyen de transport
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier le profil Open Source Routing Machine du moyen de transport
     * 
     * @param string $osrmProfile
     * @return void
     */
    public function setOsrmProfile($osrmProfile)
    {
        $this->osrmProfile = $osrmProfile;
    }

    /**
     * Méthode permettant de modifier le type RouteXL du moyen de transport
     * 
     * @param string $routeXLType
     * @return void
     */
    public function setRouteXLType($routeXLType)
    {
        $this->routeXLType = $routeXLType;
    }

    /**
     * Méthode permettant de modifier la date d'archivage du moyen de transport
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }
}
