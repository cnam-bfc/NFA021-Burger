<?php

/**
 * Objet Employe
 */
class Employe extends Compte
{
    /**
     * Matricule de l'employé
     *
     * @var string
     */
    private $matricule;

    /**
     * Nom de l'employé
     * 
     * @var string
     */
    private $nom;

    /**
     * Prénom de l'employé
     * 
     * @var string
     */
    private $prenom;

    /**
     * Méthode permettant de récupérer le matricule de l'employé
     * 
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Méthode permettant de récupérer le nom de l'employé
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Méthode permettant de récupérer le prénom de l'employé
     * 
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Méthode permettant de modifier le matricule de l'employé
     * 
     * @return string
     * @return void
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    /**
     * Méthode permettant de modifier le nom de l'employé
     * 
     * @param string $nom
     * @return void
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Méthode permettant de modifier le prénom de l'employé
     * 
     * @param string $prenom
     * @return void
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
}
