<?php
class ConfigManager
{
    private static $instance = null;
    private $config = null;

    private function __construct()
    {
        $this->config = json_decode(file_get_contents(DATA_FOLDER . 'config.json'), true);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ConfigManager();
        }
        return self::$instance;
    }

    /*******************************
     *** DEBUT - BASE DE DONNEES ***
     ******************************/
    public function getBddHost()
    {
        return $this->config['bdd']['host'];
    }

    public function getBddName()
    {
        return $this->config['bdd']['database'];
    }

    public function getBddUser()
    {
        return $this->config['bdd']['user'];
    }

    public function getBddPassword()
    {
        return $this->config['bdd']['password'];
    }

    public function getBddPort()
    {
        if (isset($this->config['bdd']['port'])) {
            return $this->config['bdd']['port'];
        } else {
            return 3306;
        }
    }

    /*****************************
     *** FIN - BASE DE DONNEES ***
     ****************************/

    public function getVersion()
    {
        return $this->config['version'];
    }
}
