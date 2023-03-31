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
        'install' => ["controller" => "InstallController", "method" => "renderView"],
        'accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilClient"],
        'employe/accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilEmploye"],
        'gerant/statistiques' => ["controller" => "StatistiquesController", "method" => "renderViewStatistiques"],
        'gerant/recettes' => ["controller" => "RecetteController", "method" => "renderViewRecettes"],
        'gerant/recettes/ajouter' => ["controller" => "EditRecetteController", "method" => "renderViewAjouterRecette"],
        'gerant/recettes/modifier' => ["controller" => "EditRecetteController", "method" => "renderViewModifierRecette"],
        'gerant/recettes/supprimer' => ["controller" => "EditRecetteController", "method" => "renderViewSupprimerRecette"],
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
        // Si la route demandée est vide, on charge la page d'accueil appropriée
        if ($route == "" || $route == "employe") {
            // Si l'utilisateur est connecté, on le redirige vers la page d'accueil de son profil
            if (UserSession::isLogged()) {
                $userSession = UserSession::getUserSession();

                // Si l'utilisateur est un cuisinier, on le redirige vers la page de cuisine
                if ($userSession->isCuisinier()) {
                    Router::redirect('cuisinier');
                    return;
                }
                // Si l'utilisateur est un livreur, on le redirige vers la page de livraison
                elseif ($userSession->isLivreur()) {
                    Router::redirect('livreur');
                    return;
                }
                // Si l'utilisateur est un employé, on le redirige vers la page d'accueil de l'employé
                elseif ($userSession->isEmploye()) {
                    Router::redirect('employe/accueil');
                    return;
                }
            }

            Router::redirect('accueil');
            return;
        }

        // Si la route n'existe pas, on retourne une erreur 404 au navigateur
        if (!array_key_exists($route, Router::ROUTES)) {
            ErrorController::error(404, "Page introuvable");
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

    /**
     * Méthode permettant de rediriger le navigateur vers une autre page
     * 
     * @param string $route (route vers laquelle on veut rediriger)
     * @return void
     */
    public static function redirect($route)
    {
        header("Location: " . PUBLIC_FOLDER . $route);
        exit;
    }
}
