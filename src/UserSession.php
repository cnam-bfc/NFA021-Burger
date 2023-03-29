<?php

/**
 * Class UserSession
 * 
 * Cette classe permet de gérer les sessions d'un utilisateur connecté.
 */
class UserSession
{
    /**
     * Méthode permettant de savoir si un utilisateur est connecté
     * 
     * @return boolean
     */
    public static function isLogged(): bool
    {
        return Session::exists('user');
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté
     * 
     * @return UserSession
     */
    public static function getUserSession(): UserSession
    {
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
    public static function logout()
    {
        Session::delete('user');
    }

    private ClientUser $clientUser;
    private EmployeUser $employeUser;
    private GerantUser $gerantUser;
    private CuisinierUser $cuisinierUser;
    private LivreurUser $livreurUser;

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un client
     * 
     * @return boolean
     */
    public function isClient(): bool
    {
        return $this->clientUser !== null;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un employé
     * 
     * @return boolean
     */
    public function isEmploye(): bool
    {
        return $this->employeUser !== null;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un gérant
     * 
     * @return boolean
     */
    public function isGerant(): bool
    {
        return $this->gerantUser !== null;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un cuisinier
     * 
     * @return boolean
     */
    public function isCuisinier(): bool
    {
        return $this->cuisinierUser !== null;
    }

    /**
     * Méthode permettant de savoir si l'utilisateur connecté est un livreur
     * 
     * @return boolean
     */
    public function isLivreur(): bool
    {
        return $this->livreurUser !== null;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que client
     * 
     * @return ClientUser
     */
    public function getClientUser(): ClientUser
    {
        return $this->clientUser;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant qu'employé
     * 
     * @return EmployeUser
     */
    public function getEmployeUser(): EmployeUser
    {
        return $this->employeUser;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que gérant
     * 
     * @return GerantUser
     */
    public function getGerantUser(): GerantUser
    {
        return $this->gerantUser;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que cuisinier
     * 
     * @return CuisinierUser
     */
    public function getCuisinierUser(): CuisinierUser
    {
        return $this->cuisinierUser;
    }

    /**
     * Méthode permettant de récupérer l'utilisateur connecté en tant que livreur
     * 
     * @return LivreurUser
     */
    public function getLivreurUser(): LivreurUser
    {
        return $this->livreurUser;
    }
}
