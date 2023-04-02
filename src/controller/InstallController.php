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
        $ip = Form::getParam('ip_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $port = Form::getParam('port_bdd', Form::METHOD_POST, Form::TYPE_INT);
        $name = Form::getParam('nom_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $user = Form::getParam('user_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        $password = Form::getParam('mdp_bdd', Form::METHOD_POST, Form::TYPE_STRING);
        
        $success = Database::testConnectionBdd($ip, $port, $name, $user, $password);

        $json = array(
            'success' => $success
        );

        $view = new View(BaseTemplate::JSON, null);

        // Définission des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }
}
