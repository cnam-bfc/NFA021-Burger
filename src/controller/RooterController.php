<?php
/**
 * Class Routeur
 * 
 * Classe permettant de générer un objet routeur afin de faire le lien entre les différentes pages du site
 */
class RooterController
{
    private $request;
    // tableau contenant les routes
    private $routes = [
        'accueil' => ["controller" => "AccueilController", "method" => "renderView"],
        'gerant/livraison' => ["controller" => "TestController", "method" => "renderView"]
    ];

    /**
     * Constructeur de la classe Routeur
     * 
     * @param string $request (page demandée)
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Méthode permettant de charger le contrôleur correspondant à la page demandée
     * Si on ne trouve pas de contrôleur correspondant, on affiche une page d'erreur
     *
     * @return void
     */
    public function renderController()
    {
        if (array_key_exists($this->request, $this->routes)) {
            // On récupère le nom qu'aura la classe du contrôleur
            $controller = $this->routes[$this->request]["controller"];
            // On récupère le nom de la méthode à appeler
            $method = $this->routes[$this->request]["method"];
            // On instancie le contrôleur
            $currentController = new $controller();
            // On appelle la méthode du contrôleur
            $currentController->$method();
        } else {
            echo "Erreur : 404";
            // require_once CONTROLLER . '404.php'; // si quelqu'un à le temps 
        }
    }
}
