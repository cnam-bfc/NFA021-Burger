<?php

/**
 * Objet Compte
 */
class Compte
{
    /**
     * Identifiant du compte
     * 
     * @var int
     */
    private $id;

    /**
     * Login du compte
     * 
     * @var string
     */
    private $login;

    /**
     * Mot de passe (hashé) du compte
     * 
     * @var string
     */
    private $hashedPassword;

    /**
     * Date d'archivage du compte
     * 
     * @var string
     */
    private $dateArchive;

    /**
     * Méthode permettant de récupérer l'identifiant du compte
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le login du compte
     * 
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Méthode permettant de récupérer le mot de passe (hashé) du compte
     * 
     * @return string
     */
    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    /**
     * Méthode permettant de récupérer la date d'archivage du compte
     * 
     * @return string
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Méthode permettant de modifier l'identifiant du compte
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier le login du compte
     * 
     * @param string $login
     * @return void
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Méthode permettant de modifier le mot de passe (hashé) du compte
     * 
     * @param string $hashedPassword
     * @return void
     */
    public function setHashedPassword($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Méthode permettant de modifier la date d'archivage du compte
     * 
     * @param string $dateArchive
     * @return void
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;
    }
}
