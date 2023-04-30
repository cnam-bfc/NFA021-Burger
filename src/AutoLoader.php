<?php

/**
 * Class AutoLoader
 * 
 * Cette classe permet de charger automatiquement les classes du projet.
 */
class AutoLoader
{
    /**
     * Tableau contenant les chemins vers les dossiers contenant les classes du projet
     */
    private static $paths = [
        'App' => 'App.php',
        'Configuration' => 'Configuration.php',
        'Form' => 'Form.php',
        'Session' => 'Session.php',
        'Router' => 'Router.php',
        'Security' => 'Security.php',
        'Database' => 'Database.php',
        'UserSession' => 'UserSession.php',
        'Controller' => 'controller' . DIRECTORY_SEPARATOR . 'Controller.php',
        'DAO' => 'model' . DIRECTORY_SEPARATOR . 'DAO.php',
        'View' => 'view' . DIRECTORY_SEPARATOR . 'View.php',
        'BaseTemplate' => 'view' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'BaseTemplate.php'
    ];

    /**
     * Méthode permettant de démarrer l'autoloader
     *
     * @return void
     */
    public static function start()
    {
        // Cette fonction sera appelée chaque fois qu'une classe sera instanciée et que PHP ne la trouvera pas dans le code actuel.
        spl_autoload_register(array(__CLASS__, 'autoload'));
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
        // On construit les chemins possibles vers la classe
        if (substr($class, -3) == 'DAO') {
            $modelFolder = lcfirst(substr($class, 0, -3));
        } else {
            $modelFolder = lcfirst($class);
        }
        $modelPath = MODEL . $modelFolder . DIRECTORY_SEPARATOR . $class . '.php';
        $controllerPath = CONTROLLER . $class . '.php';
        $viewPath = VIEW . $class . '.php';
        switch ($class) {
                // Si la classe est un modèle (DAO ou Objet)
            case file_exists($modelPath):
                require_once $modelPath;
                break;

                // Si la classe est un contrôleur
            case file_exists($controllerPath):
                require_once $controllerPath;
                break;

                // Si la classe est une vue
            case file_exists($viewPath):
                require_once $viewPath;
                break;

                // Si la classe est une classe du projet
            case array_key_exists($class, self::$paths):
                require_once self::$paths[$class];
                break;

                // Sinon on affiche une erreur
            default:
                // Si une erreur est survenue, on affiche une page d'erreur
                ErrorController::error(500, "Classe $class introuvable.");
                exit;
        }
    }
}
