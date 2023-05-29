<?php
class AuthentificationController extends Controller
{
    public function renderViewConnexion()
    {
        $userSession = UserSession::getUserSession();

        // Si l'utilisateur est connecté, on le redirige vers la page d'accueil appropriée
        if ($userSession->isLogged()) {
            // Redirection vers la page d'accueil
            if ($userSession->isEmploye()) {
                header('Location: ' . PUBLIC_FOLDER . 'employe/accueil');
            } else {
                header('Location: ' . PUBLIC_FOLDER . 'accueil');
            }

            return;
        }

        $view = new View(BaseTemplate::EMPTY, 'ConnexionView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function connexion()
    {
        $userSession = UserSession::getUserSession();

        // Si l'utilisateur est déjà connecté, on le déconnecte
        if ($userSession->isLogged()) {
            UserSession::destroy();
        }

        // Récupération des paramètres
        $username = Form::getParam('identifiant', Form::METHOD_POST, Form::TYPE_STRING, true);
        $password = Form::getParam('password', Form::METHOD_POST, Form::TYPE_STRING, true);

        // Initialisation des DAO
        $compteDAO = new CompteDAO();
        $gerantDAO = new GerantDAO();
        $cuisinierDAO = new CuisinierDAO();
        $livreurDAO = new LivreurDAO();
        $clientDAO = new ClientDAO();

        $json = array(
            'success' => false
        );

        // Vérification de l'existence du compte
        if (strpos($username, '@') !== false) {
            $compte = $compteDAO->selectByEmail($username);
        } else {
            $compte = $compteDAO->selectByLogin($username);
        }

        if ($compte === null) {
            $json['message'] = 'Le compte n\'existe pas';
        } else {
            // Vérification de l'activation du compte (date_archive < now())
            if ($compte->getDateArchive() !== null && $compte->getDateArchive() < date('Y-m-d H:i:s')) {
                $json['message'] = 'Le compte est désactivé';
            }
            // Vérification du mot de passe
            elseif (!Security::getInstance()->verifyPassword($password, $compte->getHashedPassword())) {
                $json['message'] = 'Le mot de passe est incorrect';
            }
            // Connexion
            else {
                // Définition du compte lambda (temporaire)
                $userSession->setCompte($compte);

                // Récupération de l'utilisateur en base de données
                $gerant = $gerantDAO->selectById($compte->getId());
                $cuisinier = $cuisinierDAO->selectById($compte->getId());
                $livreur = $livreurDAO->selectById($compte->getId());
                $client = $clientDAO->selectById($compte->getId());
                if ($gerant !== null) {
                    $userSession->setCompte($gerant);
                } elseif ($cuisinier !== null) {
                    $userSession->setCompte($cuisinier);
                } elseif ($livreur !== null) {
                    $userSession->setCompte($livreur);
                } elseif ($client !== null) {
                    $userSession->setCompte($client);
                }

                $json['success'] = true;
                $json['message'] = 'Vous êtes connecté';
                if ($userSession->isEmploye()) {
                    $json['redirect'] = PUBLIC_FOLDER . 'employe/accueil';
                } else {
                    $json['redirect'] = PUBLIC_FOLDER . 'accueil';
                }
            }
        }

        $view = new View(BaseTemplate::JSON);

        // Définition des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }

    public function renderViewMotDePasseOublie()
    {
        $view = new View(BaseTemplate::EMPTY, 'MotDePasseOublieView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function envoiMailMotDePasseOublie()
    {
    }

    public function deconnexion()
    {
        $userSession = UserSession::getUserSession();

        // Si l'utilisateur est connecté, on le déconnecte
        if ($userSession->isLogged()) {
            UserSession::destroy();
        }

        // Redirection vers la page d'accueil
        header('Location: ' . PUBLIC_FOLDER . 'accueil');
    }

    public function renderViewInscription()
    {
        $userSession = UserSession::getUserSession();

        // Si l'utilisateur est connecté, on le redirige vers la page d'accueil appropriée
        if ($userSession->isLogged()) {
            // Redirection vers la page d'accueil
            if ($userSession->isEmploye()) {
                header('Location: ' . PUBLIC_FOLDER . 'employe/accueil');
            } else {
                header('Location: ' . PUBLIC_FOLDER . 'accueil');
            }

            return;
        }

        $view = new View(BaseTemplate::EMPTY, 'InscriptionView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function inscription()
    {
        $userSession = UserSession::getUserSession();

        // Si l'utilisateur est déjà connecté, on le déconnecte
        if ($userSession->isLogged()) {
            UserSession::destroy();
        }

        // Récupération des paramètres
        $nom = Form::getParam('nom', Form::METHOD_POST, Form::TYPE_STRING, true);
        $prenom = Form::getParam('prenom', Form::METHOD_POST, Form::TYPE_STRING, true);
        $username = Form::getParam('username', Form::METHOD_POST, Form::TYPE_STRING, true);
        // Vérification de la validité du nom d'utilisateur
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            ErrorController::error(400, 'Le nom d\'utilisateur doit contenir entre 3 et 20 caractères alphanumériques ou des underscores');
            return;
        }
        $email = Form::getParam('email', Form::METHOD_POST, Form::TYPE_EMAIL, true);
        $password = Form::getParam('password', Form::METHOD_POST, Form::TYPE_STRING, true);

        // Initialisation des DAO
        $compteDAO = new CompteDAO();
        $clientDAO = new ClientDAO();

        $json = array(
            'success' => false
        );

        // Vérification de l'existence du compte
        $compteUsername = $compteDAO->selectByLogin($username);
        $compteEmail = $compteDAO->selectByEmail($email);
        if ($compteUsername !== null) {
            $json['message'] = 'Le nom d\'utilisateur est déjà utilisé';
        } elseif ($compteEmail !== null) {
            $json['message'] = 'L\'adresse email est déjà utilisée';
        } else {
            // Hashage du mot de passe
            $password = Security::getInstance()->hashPassword($password);

            // Création du client (compte)
            $client = new Client();
            $client->setNom($nom);
            $client->setPrenom($prenom);
            $client->setLogin($username);
            $client->setEmail($email);
            $client->setHashedPassword($password);

            $clientDAO->create($client);

            // Connexion
            $userSession->setCompte($client);

            $json['success'] = true;
            $json['message'] = 'Votre compte a bien été créé';
            if ($userSession->isEmploye()) {
                $json['redirect'] = PUBLIC_FOLDER . 'employe/accueil';
            } else {
                $json['redirect'] = PUBLIC_FOLDER . 'accueil';
            }
        }

        $view = new View(BaseTemplate::JSON);

        // Définition des variables utilisées dans la vue
        $view->json = $json;

        $view->renderView();
    }
}
