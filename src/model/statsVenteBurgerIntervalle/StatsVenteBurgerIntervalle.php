<?php

/**
 * Objet StatsVenteBurgerIntervalle
 */
class StatsVenteBurgerIntervalle
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
     * Date de prise en compte de la statistiques
     * 
     * @var int
     */
    private $annee;

    /**
     * Date de prise en compte de la statistiques
     *
     * @var int
     */
    private $mois;

    /**
     * Date de prise en compte de la statistiques
     *
     * @var int
     */
    private $jour;

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
     * Méthode permettant de récupérer l'année de prise en compte de la statistiques
     * 
     * @return void
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Méthode permettant de modifier l'année de prise en compte de la statistiques
     * 
     * @param int $annee Année de prise en compte de la statistiques
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    /**
     * Méthode permettant de récupérer le mois de prise en compte de la statistiques
     * 
     * @return void
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Méthode permettant de modifier le mois de prise en compte de la statistiques
     * 
     * @param int $mois Mois de prise en compte de la statistiques
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    }

    /**
     * Méthode permettant de récupérer le jour de prise en compte de la statistiques
     * 
     * @return void
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Méthode permettant de modifier le jour de prise en compte de la statistiques
     * 
     * @param int $jour Jour de prise en compte de la statistiques
     */
    public function setJour($jour)
    {
        $this->jour = $jour;
    }

    /**
     * Retourne la date au format : 
     * yyyy ou yyyy-mm ou yyyy-mm-dd
     * on fait en sorte de bien respecter le format par exemple 2023-05 et non pas 2023-5
     *
     * @return void
     */
    public function getDate() {
        $date = $this->annee;
        if ($this->mois != null) {
            $date .= '-' . str_pad($this->mois, 2, '0', STR_PAD_LEFT);
        }
        if ($this->jour != null) {
            $date .= '-' . str_pad($this->jour, 2, '0', STR_PAD_LEFT);
        }
        return $date;
    }
}
