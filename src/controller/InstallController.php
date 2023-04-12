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
     * Méthode permettant de tester la connexion à la base de données
     */
    public function testConnectionBdd()
    {
        $host = Form::getParam('host_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $port = Form::getParam('port_bdd', Form::METHOD_POST, Form::TYPE_INT);
        $database = Form::getParam('database_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $user = Form::getParam('user_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $password = Form::getParam('password_bdd', Form::METHOD_POST, Form::TYPE_STRING);

        $success = Database::testConnectionBdd($host, $port, $database, $user, $password);

        $json = array(
            'success' => $success
        );

        $view = new View(BaseTemplate::JSON, null);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    /**
     * Méthode permettant d'installer l'application
     */
    public function install()
    {
        $bdd_host = Form::getParam('host_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $bdd_port = Form::getParam('port_bdd', Form::METHOD_POST, Form::TYPE_INT);
        $bdd_database = Form::getParam('database_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $bdd_user = Form::getParam('user_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $bdd_password = Form::getParam('password_bdd', Form::METHOD_POST, Form::TYPE_STRING);

        // Création du fichier de configuration
        $json = array(
            'bdd' => array(
                'host' => $bdd_host,
                'port' => $bdd_port,
                'database' => $bdd_database,
                'user' => $bdd_user,
                'password' => $bdd_password
            )
        );

        $json_data = json_encode($json, JSON_PRETTY_PRINT);

        $success = file_put_contents(DATA_FOLDER . 'config.json', $json_data);

        if ($success) {
            // Rechargement de la configuration
            Configuration::createInstance();

            // Connexion à la base de données
            $success = Database::createInstance();
        }

        if ($success) {
            // Mise à jour de la base de données
            $success = Database::getInstance()->update();
        }

        $json = array(
            'success' => $success
        );

        $view = new View(BaseTemplate::JSON, null);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }
}
