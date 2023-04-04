<?php

/**
 * Class Session
 * 
 * Classe permettant de gérer les sessions.
 */
class Session
{
    /**
     * Méthode permettant de démarrer une session
     */
    public static function start()
    {
        session_start();
    }

    /**
     * Méthode permettant de détruire une session
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Méthode permettant de définir une variable de session
     * 
     * @param string $key (nom de la variable)
     * @param mixed $value (valeur de la variable)
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Méthode permettant de récupérer une variable de session
     * 
     * @param string $key (nom de la variable)
     * @return mixed
     */
    public static function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Méthode permettant de savoir si une variable de session existe
     * 
     * @param string $key (nom de la variable)
     * @return boolean
     */
    public static function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Méthode permettant de supprimer une variable de session
     * 
     * @param string $key (nom de la variable)
     */
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }
}
