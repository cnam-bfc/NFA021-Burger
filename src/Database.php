<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
    }

    public function connect()
    {
        $config = Configuration::getInstance();
        $this->pdo = new PDO('mysql:host=' . $config->getBddHost() . ';port=' . $config->getBddPort() . ';dbname=' . $config->getBddName() . ';charset=utf8', $config->getBddUser(), $config->getBddPassword());
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getPDO()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
            self::$instance->connect();
        }
        return self::$instance->pdo;
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
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
