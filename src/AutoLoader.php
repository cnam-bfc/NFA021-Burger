<?php

/**
 * Class AutoLoader
 * 
 * Cette classe permet de charger automatiquement les classes du projet.
 */
class AutoLoader
{
    /**
     * Méthode permettant de démarrer l'autoloader
     *
     * @return void
     */
    public static function start()
    {
        // Cette fonction sera appelée chaque fois qu'une classe sera instanciée et que PHP ne la trouvera pas dans le code actuel.
        spl_autoload_register(array(__CLASS__, 'autoload'));

        // Chargement des fichiers de base
        require_once SRC_FOLDER . 'Configuration.php'; // Gestion de la configuration
        require_once SRC_FOLDER . 'Router.php'; // Gestion des routes
        require_once SRC_FOLDER . 'Database.php'; // Gestion de la base de données
    }

    /**
     * Méthode permettant de charger automatiquement les classes du projet
     * Cette méthode est appelée par PHP à chaque fois qu'une classe est instanciée et que PHP ne la trouve pas dans le code actuel.
     * 
     * @param string $class (nom de la classe à charger)
     * @return void
     */
    public static function autoload($class)
    {
        switch ($class) {
            case file_exists(MODEL . $class . '.php'):
                require_once MODEL . $class . '.php';
                break;
            case file_exists(CONTROLLER . $class . '.php'):
                require_once CONTROLLER . $class . '.php';
                break;
            case file_exists(VIEW . $class . '.php'):
                require_once VIEW . $class . '.php';
                break;
            default:
                // Si une erreur est survenue, on affiche une page d'erreur
                header("HTTP/1.0 500 Internal Server Error");
                echo "Erreur 500 : Classe $class introuvable.";
                exit;
        }
    }
}
