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
        $this->pdo = new PDO('mysql:host=' . $config->getBddHost() . ';port='. $config->getBddPort() .';dbname=' . $config->getBddName() . ';charset=utf8', $config->getBddUser(), $config->getBddPassword());
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
}