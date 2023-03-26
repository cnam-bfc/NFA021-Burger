<?php

class DatabaseManager
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
    }

    public function connect()
    {
        $config = ConfigManager::getInstance();
        $this->pdo = new PDO('mysql:host=' . $config->getBddHost() . ';port='. $config->getBddPort() .';dbname=' . $config->getBddName() . ';charset=utf8', $config->getBddUser(), $config->getBddPassword());
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getPDO()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DatabaseManager();
            self::$instance->connect();
        }
        return self::$instance->pdo;
    }
}