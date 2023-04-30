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
     * Méthode permettant de créer un compte gérant
     */
    public function createGerant()
    {
        // Récupération des paramètres de la requête
        $nom = Form::getParam('nom_gerant', Form::METHOD_POST, Form::TYPE_STRING);
        $prenom = Form::getParam('prenom_gerant', Form::METHOD_POST, Form::TYPE_STRING);
        $login = Form::getParam('login_gerant', Form::METHOD_POST, Form::TYPE_STRING);
        $password = Form::getParam('password_gerant', Form::METHOD_POST, Form::TYPE_STRING);

        // Hashage du mot de passe
        $password = Security::getInstance()->hashPassword($password);

        // Création du compte gérant
        $gerant = new Gerant();
        $gerant->setNom($nom);
        $gerant->setPrenom($prenom);
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
}
