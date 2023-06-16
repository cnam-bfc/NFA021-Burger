<?php
class Configuration
{
    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::createInstance();
        }
        return self::$instance;
    }

    public static function createInstance()
    {
        self::$instance = new Configuration();
    }

    const CATEGORY_BDD = 'bdd';
    const CATEGORY_API_ROUTEXL = 'api_route_xl';

    private $config = array();

    private function __construct()
    {
        if (file_exists(DATA_FOLDER . 'config.json')) {
            $this->config = json_decode(file_get_contents(DATA_FOLDER . 'config.json'), true);
        }
    }

    /**************************
     *** DEBUT - GÉNÉRALITÉ ***
     **************************/
    /**
     * Fonction permettant de savoir si une valeur de configuration existe
     * 
     * @param string $category (catégorie de la valeur de configuration)
     * @param string $key (clé de la valeur de configuration)
     * @return bool (true si la clé existe, false sinon)
     */
    private function has($category, $key)
    {
        return isset($this->config[$category][$key]);
    }

    /**
     * Fonction permettant de récupérer une valeur de configuration
     * 
     * @param string $category (catégorie de la valeur de configuration)
     * @param string $key (clé de la valeur de configuration)
     * @return mixed (valeur de configuration)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    private function get($category, $key)
    {
        if (!$this->has($category, $key)) {
            throw new Exception('La valeur de configuration \'' . $key . '\' n\'existe pas dans la catégorie \'' . $category . '\'');
        }
        return $this->config[$category][$key];
    }

    /**
     * Fonction permettant de définir une valeur de configuration
     * 
     * @param string $category (catégorie de la valeur de configuration)
     * @param string $key (clé de la valeur de configuration)
     * @param mixed $value (valeur de configuration)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    private function set($category, $key, $value)
    {
        $this->config[$category][$key] = $value;
        $config_json = json_encode($this->config, JSON_PRETTY_PRINT);
        $success = file_put_contents(DATA_FOLDER . 'config.json', $config_json);
        if (!$success) {
            throw new Exception('Une erreur est survenue lors de l\'écriture dans le fichier de configuration');
        }
    }

    /*******************************
     *** DEBUT - BASE DE DONNEES ***
     ******************************/
    /**
     * Méthode permettant de récupérer l'hôte de la base de données
     * 
     * @return string (hôte de la base de données)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getBddHost()
    {
        return $this->get(self::CATEGORY_BDD, 'host');
    }

    /**
     * Méthode permettant de récupérer le port de la base de données
     * 
     * @return string (port de la base de données)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getBddPort()
    {
        return $this->get(self::CATEGORY_BDD, 'port');
    }

    /**
     * Méthode permettant de récupérer le nom de la base de données
     * 
     * @return string (nom de la base de données)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getBddName()
    {
        return $this->get(self::CATEGORY_BDD, 'database');
    }

    /**
     * Méthode permettant de récupérer l'utilisateur de la base de données
     * 
     * @return string (utilisateur de la base de données)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getBddUser()
    {
        return $this->get(self::CATEGORY_BDD, 'user');
    }

    /**
     * Méthode permettant de récupérer le mot de passe de la base de données
     * 
     * @return string (mot de passe de la base de données)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getBddPassword()
    {
        return $this->get(self::CATEGORY_BDD, 'password');
    }

    /**
     * Méthode permettant de modifier l'hôte de la base de données
     * 
     * @param string $host (hôte de la base de données)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setBddHost($host)
    {
        $this->set(self::CATEGORY_BDD, 'host', $host);
    }

    /**
     * Méthode permettant de modifier le port de la base de données
     * 
     * @param string $port (port de la base de données)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setBddPort($port)
    {
        $this->set(self::CATEGORY_BDD, 'port', $port);
    }

    /**
     * Méthode permettant de modifier le nom de la base de données
     * 
     * @param string $database (nom de la base de données)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setBddName($database)
    {
        $this->set(self::CATEGORY_BDD, 'database', $database);
    }

    /**
     * Méthode permettant de modifier l'utilisateur de la base de données
     * 
     * @param string $user (utilisateur de la base de données)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setBddUser($user)
    {
        $this->set(self::CATEGORY_BDD, 'user', $user);
    }

    /**
     * Méthode permettant de modifier le mot de passe de la base de données
     * 
     * @param string $password (mot de passe de la base de données)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setBddPassword($password)
    {
        $this->set(self::CATEGORY_BDD, 'password', $password);
    }

    /*****************************
     *** FIN - BASE DE DONNEES ***
     ****************************/

    /***************************
     *** DEBUT - API ROUTEXL ***
     ***************************/
    /**
     * Méthode permettant de récupérer le nom d'utilisateur de l'API RouteXL
     * 
     * @return string (nom d'utilisateur de l'API RouteXL)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getRouteXLUsername()
    {
        return $this->get(self::CATEGORY_API_ROUTEXL, 'username');
    }

    /**
     * Méthode permettant de récupérer le mot de passe de l'API RouteXL
     * 
     * @return string (mot de passe de l'API RouteXL)
     * @throws Exception (si la valeur de configuration n'existe pas)
     */
    public function getRouteXLPassword()
    {
        return $this->get(self::CATEGORY_API_ROUTEXL, 'password');
    }

    /**
     * Méthode permettant de modifier le nom d'utilisateur de l'API RouteXL
     * 
     * @param string $username (nom d'utilisateur de l'API RouteXL)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setRouteXLUsername($username)
    {
        $this->set(self::CATEGORY_API_ROUTEXL, 'username', $username);
    }

    /**
     * Méthode permettant de modifier le mot de passe de l'API RouteXL
     * 
     * @param string $password (mot de passe de l'API RouteXL)
     * @throws Exception (si une erreur survient lors de l'écriture dans le fichier de configuration)
     */
    public function setRouteXLPassword($password)
    {
        $this->set(self::CATEGORY_API_ROUTEXL, 'password', $password);
    }

    /*************************
     *** FIN - API ROUTEXL ***
     ************************/
}
