<?php

/**
 * Class Router
 * 
 * Classe permettant de faire le lien entre les routes et les contrôleurs
 */
class Router
{
    // Définition des routes (page demandée => contrôleur à charger)
    const ROUTES = [
        'accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilClient"],
        'gerant' => ["controller" => "AccueilController", "method" => "renderViewAccueilEmploye"],
        'gerant/' => ["controller" => "AccueilController", "method" => "renderViewAccueilEmploye"],
        'gerant/accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilEmploye"],
        'visuModifsBurgers' => ["controller" => "ModifsBurgersController" , "method" => "renderViewPimpBurgers"]
    ];

    /**
     * Méthode permettant de charger le contrôleur correspondant à la page demandée
     * Si on ne trouve pas la route demandée, on affiche une page d'erreur
     *
     * @param string $route (route demandée)
     * @return void
     */
    public static function route($route)
    {
        // Si la route n'existe pas, on retourne une erreur 404 au navigateur
        if (!array_key_exists($route, Router::ROUTES)) {
            header("HTTP/1.0 404 Not Found");
            echo "Erreur 404 : la page demandée n'existe pas.";
            exit;
        }

        // On récupère le nom qu'aura la classe du contrôleur
        $controller = Router::ROUTES[$route]["controller"];
        // On récupère le nom de la méthode à appeler
        $method = Router::ROUTES[$route]["method"];
        // On instancie le contrôleur
        $currentController = new $controller();
        // On appelle la méthode du contrôleur
        $currentController->$method();
    }
}
