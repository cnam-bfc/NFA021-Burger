<?php

/**
 * Objet StatsVenteBurger
 */
class StatsVenteBurger
{
    /**
     * Identifiant de la recette
     * 
     * @var int
     */
    private $id;

    /**
     * Nom du burger
     * 
     * @var string
     */
    private $nom;

    /**
     * quantité de vente du burger
     * 
     * @var int
     */
    private $quantite;

    /**
     * quantite de vente du burger
     * (si null = pas de date de début)
     * 
     * @var string
     */
    private $dateDebut;

    /**
     * Date de fin de vente de la statistiques
     * (si null = pas de date de fin)
     *
     * @var string
     */
    private $dateFin;

    /**
     * Méthode permettant de récupérer l'identifiant de la recette
     * 
     * @return void
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette
     * 
     * @param int $id Identifiant de la recette
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Méthode permettant de récupérer le nom du burger
     * 
     * @return void
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de modifier le nom du burger
     * 
     * @param string $nom Nom du burger
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de récupérer la quantité de vente du burger
     * 
     * @return void
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Méthode permettant de modifier la quantité de vente du burger
     * 
     * @param int $quantite Quantité de vente du burger
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * Méthode permettant de récupérer la date de début de vente de la statistiques
     * 
     * @return void
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Méthode permettant de modifier la date de début de vente de la statistiques
     * 
     * @param string $dateDebut Date de début de vente de la statistiques
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * Méthode permettant de récupérer la date de fin de vente de la statistiques
     * 
     * @return void
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Méthode permettant de modifier la date de fin de vente de la statistiques
     * 
     * @param string $dateFin Date de fin de vente de la statistiques
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }
}
