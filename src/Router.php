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
        // Installation
        'install' => ["controller" => "InstallController", "method" => "renderView"],
        'install/config_bdd' => ["controller" => "InstallController", "method" => "configBdd"],
        'install/install_bdd' => ["controller" => "InstallController", "method" => "installBdd"],
        'install/create_gerant' => ["controller" => "InstallController", "method" => "createGerant"],
        'install/install_unites' => ["controller" => "InstallController", "method" => "installUnites"],
        'install/install_emballages' => ["controller" => "InstallController", "method" => "installEmballages"],
        'install/install_fournisseurs' => ["controller" => "InstallController", "method" => "installFournisseurs"],
        'install/finish' => ["controller" => "InstallController", "method" => "finish"],

        // PARTIE CLIENT
        // Accueil client
        'accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilClient"],
        'accueil/refreshTopRecettes' => ["controller" => "AccueilController", "method" => "refreshTopRecetteAJAX"],

        // Carte des recettes
        'carte' => ["controller" => "CarteMenuController", "method" => "renderView"],

        // PARTIE EMPLOYÉ
        // Accueil employé
        'employe/accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilEmploye"],

        // Visu burger
        'visuModifsBurgers' => ["controller" => "ModifsBurgersController", "method" => "renderViewPimpBurgers"],
        'visuModifsBurgers/ingredients' => ["controller" => "ModifsBurgersController", "method" => "getIngredients"],

        // Choix entre Livraison et Click&Collect
        'CollectLivraison' => ["controller" => "CollectLivraisonController", "method" => "renderViewCollectORDelivery"],

        // PARTIE GÉRANT
        // Statistiques
        'gerant/statistiques' => ["controller" => "StatistiquesController", "method" => "renderViewStatistiques"],

        // Inventaire
        'gerant/inventaire' => ["controller" => "InventaireController", "method" => "renderViewInventaire"],
        'gerant/inventaire/refreshTableauInventaire' => ["controller" => "InventaireController", "method" => "refreshTableauInventaire"],
        'gerant/inventaire/miseAJourInventaire' => ["controller" => "InventaireController", "method" => "miseAJourInventaire"],

        // Stock
        'gerant/stock' => ["controller" => "StockController", "method" => "renderViewStock"],
        'gerant/stock/getBonsCommandesAJAX' => ["controller" => "StockController", "method" => "getBonsCommandesAJAX"],
        'gerant/stock/getFournisseursAJAX' => ["controller" => "StockController", "method" => "getFournisseursAJAX"],
        'gerant/stock/refreshTableauIngredientsAJAX' => ["controller" => "StockController", "method" => "refreshTableauIngredientsAJAX"],

        // Recettes
        'gerant/recettes' => ["controller" => "RecetteController", "method" => "renderViewRecettes"],
        'gerant/recettes/list/recettes' => ["controller" => "RecetteController", "method" => "listeRecettes"],
        'gerant/recettes/supprimer' => ["controller" => "RecetteController", "method" => "supprimerRecette"],
        'gerant/recettes/ajouter' => ["controller" => "RecetteEditController", "method" => "renderViewAjouterRecette"],
        'gerant/recettes/modifier' => ["controller" => "RecetteEditController", "method" => "renderViewModifierRecette"],
        'gerant/recettes/list/ingredients' => ["controller" => "RecetteEditController", "method" => "listeIngredients"],
        'gerant/recettes/enregistrer' => ["controller" => "RecetteEditController", "method" => "enregistrerRecette"],

        // BDC
        'gerant/listebdc' => ["controller" => "ListeBDCController", "method" => "renderView"],
        'gerant/listebdc/donnees' => ["controller" => "ListeBDCController", "method" => "donneesBdc"],
        'gerant/listebdc/valider' => ["controller" => "ListeBDCController", "method" => "validerBdc"],
        'gerant/nouveaubdc' => ["controller" => "NouveauBDCController", "method" => "renderView"],
        'gerant/nouveaubdc/listeProduits' => ["controller" => "NouveauBDCController", "method" => "listeProduits"],

        // Produits
        'gerant/nouveauproduit' => ["controller" => "NouveauProduitController", "method" => "renderView"],
        'gerant/listeproduits' => ["controller" => "ListeProduitsController", "method" => "renderView"],


        // PARTIE CUISINIER
        // Ecran de cuisine
        'cuisinier' => ["controller" => "EcranCuisineController", "method" => "renderView"],
        'cuisinier/recette' => ["controller" => "RecetteCuisineController", "method" => "renderView"],

        // PARTIE LIVREUR
        // Livraison
        'livreur/livraisons' => ["controller" => "LivraisonController", "method" => "renderViewLivraison"],
        'livreur/itineraire' => ["controller" => "LivraisonController", "method" => "renderViewItineraire"],

        // Exemples
        'exemple' => ["controller" => "ExempleController", "method" => "renderView"],
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
