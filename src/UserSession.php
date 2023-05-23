<?php

/**
 * Class UserSession
 * 
 * Cette classe permet de gérer les sessions d'un utilisateur connecté.
 */
class UserSession
{
    /**
     * Méthode permettant de récupérer l'utilisateur connecté
     * 
     * @return UserSession
     */
    public static function getUserSession(): UserSession
    {
        // Si la session n'existe pas, on la crée
        if (!Session::exists('user')) {
            self::setUserSession(new UserSession());
        }

        return Session::get('user');
    }

    /**
     * Méthode permettant de définir l'utilisateur connecté
     * 
     * @param UserSession $userSession
     */
    public static function setUserSession(UserSession $userSession)
    {
        Session::set('user', $userSession);
    }

    /**
     * Méthode permettant de déconnecter un utilisateur
     */
    public static function destroy()
    {
        Session::delete('user');
    }

    private $compte;

    /**
     * Méthode permettant de récupérer le compte de l'utilisateur connecté
     * 
     * @return Compte
     * @throws Exception Si l'utilisateur connecté n'a pas de compte
     */
    public function getCompte(): Compte
    {
        if ($this->compte === null) {
            throw new Exception('L\'utilisateur connecté n\'a pas de compte');
        }

        return $this->compte;
    }

    /**
     * Méthode permettant de définir le compte de l'utilisateur connecté
     * 
     * @param Compte $compte
     */
    public function setCompte(Compte $compte)
    {
        $this->compte = $compte;
    }

    /**
     * Méthode permettant de savoir si un utilisateur est connecté
     * 
     * @return boolean
     */
    public function isLogged(): bool
    {
        return $this->compte !== null;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un client
     * 
     * @return boolean
     */
    public function isClient(): bool
    {
        return $this->compte instanceof Client;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un employé
     * 
     * @return boolean
     */
    public function isEmploye(): bool
    {
        return $this->compte instanceof Employe;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un gérant
     * 
     * @return boolean
     */
    public function isGerant(): bool
    {
        return $this->compte instanceof Gerant;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un cuisinier
     * 
     * @return boolean
     */
    public function isCuisinier(): bool
    {
        return $this->compte instanceof Cuisinier;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un livreur
     * 
     * @return boolean
     */
    public function isLivreur(): bool
    {
        return $this->compte instanceof Livreur;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que client
     * 
     * @return Client
     * @throws Exception Si l'utilisateur connecté n'est pas un client
     */
    public function getClientUser(): Client
    {
        if ($this->isClient() === false) {
            throw new Exception('L\'utilisateur connecté n\'est pas un client');
        }

        return $this->compte;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant qu'employé
     * 
     * @return Employe
     * @throws Exception Si l'utilisateur connecté n'est pas un employé
     */
    public function getEmployeUser(): Employe
    {
        if ($this->isEmploye() === false) {
            throw new Exception('L\'utilisateur connecté n\'est pas un employé');
        }

        return $this->compte;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que gérant
     * 
     * @return Gerant
     * @throws Exception Si l'utilisateur connecté n'est pas un gérant
     */
    public function getGerantUser(): Gerant
    {
        if ($this->isGerant() === false) {
            throw new Exception('L\'utilisateur connecté n\'est pas un gérant');
        }

        return $this->compte;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que cuisinier
     * 
     * @return Cuisinier
     * @throws Exception Si l'utilisateur connecté n'est pas un cuisinier
     */
    public function getCuisinierUser(): Cuisinier
    {
        if ($this->isCuisinier() === false) {
            throw new Exception('L\'utilisateur connecté n\'est pas un cuisinier');
        }

        return $this->compte;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que livreur
     * 
     * @return Livreur
     * @throws Exception Si l'utilisateur connecté n'est pas un livreur
     */
    public function getLivreurUser(): Livreur
    {
        if ($this->isLivreur() === false) {
            throw new Exception('L\'utilisateur connecté n\'est pas un livreur');
        }

        return $this->compte;
    }
}
