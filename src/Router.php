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
        'install/api_routexl' => ["controller" => "InstallController", "method" => "apiRouteXL"],
        'install/create_gerant' => ["controller" => "InstallController", "method" => "createGerant"],
        'install/install_moyens_transport' => ["controller" => "InstallController", "method" => "installMoyensTransport"],
        'install/install_unites' => ["controller" => "InstallController", "method" => "installUnites"],
        'install/install_emballages' => ["controller" => "InstallController", "method" => "installEmballages"],
        'install/install_fournisseurs' => ["controller" => "InstallController", "method" => "installFournisseurs"],
        'install/finish' => ["controller" => "InstallController", "method" => "finish"],

        // Authentification
        'connexion' => ["controller" => "AuthentificationController", "method" => "renderViewConnexion"],
        'connexion/connexion' => ["controller" => "AuthentificationController", "method" => "connexion"],
        'mot_de_passe_oublie' => ["controller" => "AuthentificationController", "method" => "renderViewMotDePasseOublie"],
        'mot_de_passe_oublie/envoi_mail' => ["controller" => "AuthentificationController", "method" => "envoiMailMotDePasseOublie"],
        'deconnexion' => ["controller" => "AuthentificationController", "method" => "deconnexion"],
        'inscription' => ["controller" => "AuthentificationController", "method" => "renderViewInscription"],
        'inscription/inscription' => ["controller" => "AuthentificationController", "method" => "inscription"],

        // Profil
        'profil' => ["controller" => "ProfilController", "method" => "renderView"],

        // PARTIE CLIENT
        // Accueil client
        'accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilClient"],
        'accueil/refreshTopRecettes' => ["controller" => "AccueilController", "method" => "refreshTopRecetteAJAX"],
        'accueil/refreshTextAccueil' => ["controller" => "AccueilController", "method" => "refreshTextAccueil"],

        // Carte des recettes
        'carte' => ["controller" => "CarteBurgerController", "method" => "renderView"],
        'carte/listeBurgers' => ["controller" => "CarteBurgerController", "method" => "listeBurgers"],
        'carte/ajoutPanier' => ["controller" => "CarteBurgerController", "method" => "ajoutPanier"],


        // PARTIE EMPLOYÉ
        // Accueil employé
        'employe/accueil' => ["controller" => "AccueilController", "method" => "renderViewAccueilEmploye"],
        'employe/accueil/refreshCompte' => ["controller" => "AccueilController", "method" => "afficherEspaceAccueilEmploye"],

        // Visu burger
        'visuModifsBurgers' => ["controller" => "ModifsBurgersController", "method" => "renderViewPimpBurgers"],
        'visuModifsBurgers/ingredients' => ["controller" => "ModifsBurgersController", "method" => "getIngredients"],
        'visuModifsBurgers/ajouterAuPanier' => ["controller" => "ModifsBurgersController", "method" => "ajoutPanier"],
        'visuModifsBurgers/getSupplementsRecette' => ["controller" => "ModifsBurgersController", "method" => "getSupplements"],


        // Panier
        'panier' => ["controller" => "PanierController", "method" => "renderViewPanier"],
        'panier/getSessionPanier' => ["controller" => "PanierController", "method" => "getSessionPanier"],
        'panier/SupprimerElemPanier' => ["controller" => "PanierController", "method" => "suppElemPanier"],

        //Recap Commande
        'recap' => ["controller" => "RecapController", "method" => "renderViewRecap"],
        'recap/getInfos' => ["controller" => "RecapController", "method" => "getRecapInfos"],
        'recap/writeOnBDD' => ["controller" => "RecapController", "method" => "writeOnBDD"],


        // Choix entre Livraison et Click&Collect
        'collectLivraison' => ["controller" => "CollectLivraisonController", "method" => "renderViewCollectORDelivery"],
        'collectLivraison/valider' => ["controller" => "CollectLivraisonController", "method" => "validation"],

        // PARTIE GÉRANT
        // Statistiques
        'gerant/statistiques' => ["controller" => "StatistiquesController", "method" => "renderViewStatistiques"],
        'gerant/statistiques/getAllBurgers' => ["controller" => "StatistiquesController", "method" => "getAllBurgers"],
        'gerant/statistiques/getDataBurgerVenteTotal' => ["controller" => "StatistiquesController", "method" => "getDataBurgerVenteTotal"],
        'gerant/statistiques/getDataBurgerVenteTemps' => ["controller" => "StatistiquesController", "method" => "getDataBurgerVenteTemps"],
        'gerant/statistiques/getAllFournisseurs' => ["controller" => "StatistiquesController", "method" => "getAllFournisseurs"],
        'gerant/statistiques/getDataFournisseurAchatTotal' => ["controller" => "StatistiquesController", "method" => "getDataFournisseurAchatTotal"],

        // Inventaire
        'gerant/inventaire' => ["controller" => "InventaireController", "method" => "renderViewInventaire"],
        'gerant/inventaire/refreshTableauInventaire' => ["controller" => "InventaireController", "method" => "refreshTableauInventaire"],
        'gerant/inventaire/miseAJourInventaire' => ["controller" => "InventaireController", "method" => "miseAJourInventaire"],
        'gerant/inventaire/refreshListeIngredients' => ["controller" => "InventaireController", "method" => "refreshListeIngredients"],

        // Stock
        'gerant/stock' => ["controller" => "StockController", "method" => "renderViewStock"],
        'gerant/stock/getBonsCommandesAJAX' => ["controller" => "StockController", "method" => "getBonsCommandesAJAX"],
        'gerant/stock/getFournisseursAJAX' => ["controller" => "StockController", "method" => "getFournisseursAJAX"],
        'gerant/stock/refreshTableauIngredientsAJAX' => ["controller" => "StockController", "method" => "refreshTableauIngredientsAJAX"],
        'gerant/stock/validationBonCommandeAJAX' => ["controller" => "StockController", "method" => "validationBonCommandeAJAX"],
        'gerant/stock/refreshListeIngredients' => ["controller" => "StockController", "method" => "refreshListeIngredients"],

        // Recettes
        'gerant/recettes' => ["controller" => "RecetteController", "method" => "renderViewRecettes"],
        'gerant/recettes/list/recettes' => ["controller" => "RecetteController", "method" => "listeRecettes"],
        'gerant/recettes/supprimer' => ["controller" => "RecetteController", "method" => "supprimerRecette"],
        'gerant/recettes/ajouter' => ["controller" => "RecetteEditController", "method" => "renderViewAjouterRecette"],
        'gerant/recettes/modifier' => ["controller" => "RecetteEditController", "method" => "renderViewModifierRecette"],
        'gerant/recettes/list/ingredients' => ["controller" => "RecetteEditController", "method" => "listeIngredients"],
        'gerant/recettes/ingredients' => ["controller" => "RecetteEditController", "method" => "listeAllIngredients"],
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
        'gerant/listeproduits/archiver' => ["controller" => "ListeProduitsController", "method" => "archiver"],


        // PARTIE CUISINIER
        // Ecran de cuisine
        'cuisinier' => ["controller" => "EcranCuisineController", "method" => "renderView"],
        'cuisinier/recette' => ["controller" => "VisuBurgerCuisineController", "method" => "renderView"],
        'cuisinier/recette/afficheBurger' => ["controller" => "VisuBurgerCuisineController", "method" => "afficheBurger"],
        'cuisinier/listeCommandes' => ["controller" => "EcranCuisineController", "method" => "listeCommandes"],
        'cuisinier/supprimer' => ["controller" => "EcranCuisineController", "method" => "supprimerCommande"],



        // PARTIE LIVREUR
        // Livraison
        'livreur/livraisons' => ["controller" => "LivraisonController", "method" => "renderViewLivraison"],
        'livreur/livraisons/list' => ["controller" => "LivraisonController", "method" => "listeLivraisons"],
        'livreur/livraisons/prendre' => ["controller" => "LivraisonController", "method" => "prendreLivraison"],
        'livreur/itineraire' => ["controller" => "LivraisonController", "method" => "renderViewItineraire"],
        'livreur/itineraire/moyenstransport' => ["controller" => "LivraisonController", "method" => "listeMoyensTransport"],
        'livreur/itineraire/moyentransport' => ["controller" => "LivraisonController", "method" => "saveMoyenTransport"],
        'livreur/itineraire/afficher' => ["controller" => "LivraisonController", "method" => "afficherItineraire"],

        // Exemples
        //'exemple' => ["controller" => "ExempleController", "method" => "renderView"],
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
        $userSession = UserSession::getUserSession();

        // Gestion des droits d'accès
        // Route commencant par "employe"
        if (substr($route, 0, 7) == "employe") {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            if (!$userSession->isLogged()) {
                Router::redirect('connexion');
                return;
            }
            // Si l'utilisateur n'est pas un employé, on le redirige vers la page d'accueil
            elseif (!$userSession->isEmploye()) {
                Router::redirect('');
                return;
            }
        }

        // Route commencant par "gerant"
        if (substr($route, 0, 6) == "gerant") {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            if (!$userSession->isLogged()) {
                Router::redirect('connexion');
                return;
            }
            // Si l'utilisateur n'est pas un gérant, on le redirige vers la page d'accueil
            elseif (!$userSession->isGerant()) {
                Router::redirect('');
                return;
            }
        }

        // Route commencant par "cuisinier"
        if (substr($route, 0, 9) == "cuisinier") {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            if (!$userSession->isLogged()) {
                Router::redirect('connexion');
                return;
            }
            // Si l'utilisateur n'est pas un cuisinier ni un gérant, on le redirige vers la page d'accueil
            elseif (!$userSession->isCuisinier() && !$userSession->isGerant()) {
                Router::redirect('');
                return;
            }
        }

        // Route commencant par "livreur"
        if (substr($route, 0, 7) == "livreur") {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            if (!$userSession->isLogged()) {
                Router::redirect('connexion');
                return;
            }
            // Si l'utilisateur n'est pas un livreur ni un gérant, on le redirige vers la page d'accueil
            elseif (!$userSession->isLivreur() && !$userSession->isGerant()) {
                Router::redirect('');
                return;
            }
        }

        // Si la route demandée est vide, on charge la page d'accueil appropriée
        if ($route == "" || $route == "employe" || $route == "livreur" || $route == "gerant") {
            // Si l'utilisateur est connecté, on le redirige vers la page d'accueil de son profil
            if ($userSession->isLogged()) {
                // Si l'utilisateur est un cuisinier, on le redirige vers la page de cuisine
                if ($userSession->isCuisinier()) {
                    Router::redirect('cuisinier');
                    return;
                }
                // Si l'utilisateur est un livreur, on le redirige vers la page de livraison
                elseif ($userSession->isLivreur()) {
                    Router::redirect('livreur/livraisons');
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
