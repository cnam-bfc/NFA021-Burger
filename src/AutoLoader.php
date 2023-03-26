<?php
// autoloader
class AutoLoader
{
    public static function start()
    {
        // Cette fonction sera appelée chaque fois qu'une classe sera instanciée et que PHP ne la trouvera pas dans le code actuel.
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }


    public static function autoload($class)
    {
        switch($class){
            case file_exists(MODEL . $class . '.php'):
                require_once MODEL . $class . '.php';
                break;
            case file_exists(CONTROLLER . $class . '.php'):
                require_once CONTROLLER . $class . '.php';
                break;
            case file_exists(VIEW . $class . '.php'):
                require_once VIEW . $class . '.php';
                break;
        }
    }
}
