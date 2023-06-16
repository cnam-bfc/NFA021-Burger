<?php
class InstallController extends Controller
{
    /**
     * Méthode permettant d'afficher la page d'installation
     */
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPTY, 'InstallView');

        $view->renderView();
    }

    /**
     * Méthode permettant de configurer les identifiants de connexion à la base de données
     */
    public function configBdd()
    {
        // Récupération des paramètres de la requête
        $host = Form::getParam('host_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $port = Form::getParam('port_bdd', Form::METHOD_POST, Form::TYPE_INT);
        $database = Form::getParam('database_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $user = Form::getParam('user_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $password = Form::getParam('password_bdd', Form::METHOD_POST, Form::TYPE_STRING);

        // Test de la connexion à la base de données
        $success = Database::testConnectionBdd($host, $port, $database, $user, $password);

        // Si le test est un succès, on enregistre les informations de connexion dans le fichier de configuration
        if ($success) {
            // Modification du fichier de configuration
            $config = Configuration::getInstance();

            // Modification des informations de connexion à la base de données
            $config->setBddHost($host);
            $config->setBddPort($port);
            $config->setBddName($database);
            $config->setBddUser($user);
            $config->setBddPassword($password);
        }

        $json = array(
            'success' => $success
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Méthode permettant d'installer la base de données
     */
    public function installBdd()
    {
        // Connexion à la base de données
        $success = Database::createInstance();

        $json = array(
            'success' => $success
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Méthode permettant de configurer l'API RouteXL
     */
    public function apiRouteXL()
    {
        // Récupération des paramètres de la requête
        $user = Form::getParam('user_routexl', Form::METHOD_POST, Form::TYPE_STRING);
        $password = Form::getParam('password_routexl', Form::METHOD_POST, Form::TYPE_STRING);

        // Initialisation de l'API RouteXL
        $routeXL = new RouteXLAPI($user, $password);

        // Test de la connexion à l'API RouteXL
        $success = $routeXL->status();

        $json = array(
            'success' => $success
        );

        $result = $routeXL->getResult();
        if (!empty($result['id'])) {
            $json['api_id'] = $result['id'];
        }
        if (!empty($result['max_locations'])) {
            $json['api_max_locations'] = $result['max_locations'];
        }

        // Si le test est un succès, on enregistre les informations de connexion dans le fichier de configuration
        if ($success) {
            // Modification du fichier de configuration
            $config = Configuration::getInstance();

            // Modification des informations de connexion à l'API RouteXL
            $config->setRouteXLUsername($user);
            $config->setRouteXLPassword($password);
        }
        // Si le test est un échec, on affiche le message d'erreur dans le JSON
        else {
            $json['error_code'] = $routeXL->getResultHttpCode();
            $json['error_message'] = $routeXL->getResultError();
            // Message d'erreur personnalisé
            if (empty($json['error_message'])) {
                if ($json['error_code'] == 401) {
                    $json['error_message'] = 'Identifiants invalides';
                } else {
                    $json['error_message'] = 'Erreur inconnue';
                }
            }
        }

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Méthode permettant de créer un compte gérant
     */
    public function createGerant()
    {
        // Récupération des paramètres de la requête
        $nom = Form::getParam('nom_gerant', Form::METHOD_POST, Form::TYPE_STRING);
        $prenom = Form::getParam('prenom_gerant', Form::METHOD_POST, Form::TYPE_STRING);
        $email = Form::getParam('email_gerant', Form::METHOD_POST, Form::TYPE_EMAIL);
        $login = Form::getParam('login_gerant', Form::METHOD_POST, Form::TYPE_STRING);
        $password = Form::getParam('password_gerant', Form::METHOD_POST, Form::TYPE_STRING);

        // Hashage du mot de passe
        $password = Security::getInstance()->hashPassword($password);

        // Création du compte gérant
        $gerant = new Gerant();
        $gerant->setNom($nom);
        $gerant->setPrenom($prenom);
        $gerant->setEmail($email);
        $gerant->setLogin($login);
        $gerant->setHashedPassword($password);

        // Enregistrement du compte gérant
        $gerantDAO = new GerantDAO();
        $gerantDAO->create($gerant);

        $json = array(
            'success' => true
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Fonction permettant d'installer les unités par défaut
     */
    public function installUnites()
    {
        // Création des DAO
        $uniteDAO = new UniteDAO();

        // On lance une transaction
        Database::getInstance()->getPDO()->beginTransaction();

        // Création des unités par défaut
        // Pièce
        $unitePiece = new Unite();
        $unitePiece->setNom('Pièce');
        $unitePiece->setDiminutif('pce');
        $uniteDAO->create($unitePiece);

        // Gramme
        $uniteGramme = new Unite();
        $uniteGramme->setNom('Gramme');
        $uniteGramme->setDiminutif('g');
        $uniteDAO->create($uniteGramme);

        // Kilogramme
        $uniteKilogramme = new Unite();
        $uniteKilogramme->setNom('Kilogramme');
        $uniteKilogramme->setDiminutif('kg');
        $uniteDAO->create($uniteKilogramme);

        // Millilitre
        $uniteMillilitre = new Unite();
        $uniteMillilitre->setNom('Millilitre');
        $uniteMillilitre->setDiminutif('ml');
        $uniteDAO->create($uniteMillilitre);

        // Litre
        $uniteLitre = new Unite();
        $uniteLitre->setNom('Litre');
        $uniteLitre->setDiminutif('L');
        $uniteDAO->create($uniteLitre);

        // On valide la transaction
        Database::getInstance()->getPDO()->commit();

        $json = array(
            'success' => true
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Méthode permettant d'installer les emballages par défaut
     */
    public function installEmballages()
    {
        // Création des DAO
        $emballageDAO = new EmballageDAO();

        // On lance une transaction
        Database::getInstance()->getPDO()->beginTransaction();

        // Création des emballages par défaut
        // Carton
        $emballageCarton = new Emballage();
        $emballageCarton->setNom('Carton');
        $emballageDAO->create($emballageCarton);

        // Isotherme
        $emballageIsotherme = new Emballage();
        $emballageIsotherme->setNom('Isotherme');
        $emballageDAO->create($emballageIsotherme);

        // On valide la transaction
        Database::getInstance()->getPDO()->commit();

        $json = array(
            'success' => true
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Méthode permettant d'installer les fournisseurs par défaut
     */
    public function installFournisseurs()
    {
        // Création des DAO
        $fournisseurDAO = new FournisseurDAO();

        // On lance une transaction
        Database::getInstance()->getPDO()->beginTransaction();

        // Création des fournisseurs par défaut
        // Marché
        $fournisseurMarche = new Fournisseur();
        $fournisseurMarche->setNom('Marché');
        $fournisseurDAO->create($fournisseurMarche);

        // On valide la transaction
        Database::getInstance()->getPDO()->commit();

        $json = array(
            'success' => true
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Fonction permettant de terminer l'installation
     */
    public function finish()
    {
        // Créer le fichier '.installed.lock'
        $file = fopen('.installed.lock', 'w');
        fclose($file);

        $json = array(
            'success' => true
        );

        $view = new View(BaseTemplate::JSON);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }
}
