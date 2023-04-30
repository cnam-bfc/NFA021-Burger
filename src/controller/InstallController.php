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
            // Création du fichier de configuration
            $config = array(
                'bdd' => array(
                    'host' => $host,
                    'port' => $port,
                    'database' => $database,
                    'user' => $user,
                    'password' => $password
                )
            );

            $config_json = json_encode($config, JSON_PRETTY_PRINT);

            $success = file_put_contents(DATA_FOLDER . 'config.json', $config_json);
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
}
