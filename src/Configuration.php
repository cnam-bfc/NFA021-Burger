<?php
class Configuration
{
    private static $instance = null;
    private $config = null;

    private function __construct()
    {
        if (!file_exists(DATA_FOLDER . 'config.json')) {
            throw new Exception('Le fichier de configuration n\'existe pas, veuillez copier le fichier config.exemple.json et le renommer en config.json dans le dossier data');
        }
        $this->config = json_decode(file_get_contents(DATA_FOLDER . 'config.json'), true);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Configuration();
        }
        return self::$instance;
    }

    public static function isInstalled()
    {
        return file_exists(DATA_FOLDER . 'config.json');
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
}
