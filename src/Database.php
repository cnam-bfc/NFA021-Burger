<?php

class Database
{
    private static $instance = null;

    /**
     * Méthode permettant de créer une instance de la classe Database
     *
     * @return bool (true si la connexion est réussie, false sinon)
     */
    public static function createInstance()
    {
        try {
            self::$instance = new Database();
            self::$instance->connect();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $success = self::createInstance();
            if (!$success) {
                throw new Exception('Impossible de se connecter à la base de données');
            }
        }
        return self::$instance;
    }

    public static function getPDO()
    {
        return self::getInstance()->pdo;
    }

    /**
     * Méthode permettant de tester la connexion à la base de données
     * 
     * @param string $ip (adresse IP de la base de données)
     * @param int $port (port de la base de données)
     * @param string $name (nom de la base de données)
     * @param string $user (nom d'utilisateur de la base de données)
     * @param string $password (mot de passe de la base de données)
     * @return bool (true si la connexion est réussie, false sinon)
     */
    public static function testConnectionBdd($ip, $port, $name, $user, $password)
    {
        try {
            $pdo = new PDO('mysql:host=' . $ip . ';port=' . $port . ';dbname=' . $name . ';charset=utf8', $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    private $pdo;

    public function connect()
    {
        $config = Configuration::getInstance();
        $this->pdo = new PDO('mysql:host=' . $config->getBddHost() . ';port=' . $config->getBddPort() . ';dbname=' . $config->getBddName() . ';charset=utf8', $config->getBddUser(), $config->getBddPassword());
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
