<?php
// Récupération du dossier du code source PHP (../src/)
define("SRC_FOLDER", __DIR__ . '/../src/');

// Récupération du dossier de données (../data/)
define("DATA_FOLDER", __DIR__ . '/../data/');

// Ajout du dossier de code source PHP à include_path
set_include_path(get_include_path() . PATH_SEPARATOR . SRC_FOLDER);

// On définit le dossier de travail où se trouverons les fichiers de données
if (!file_exists(DATA_FOLDER)) {
    mkdir(DATA_FOLDER, 0777, true);
}
chdir(DATA_FOLDER);

// on vérifie si dans data les dossier "utilisateurs" "recettes" et "ingredients" existents sinon on les créer
if (!file_exists(DATA_FOLDER . "utilisateurs")) {
    mkdir(DATA_FOLDER . "utilisateurs", 0777, true);
}

if (!file_exists(DATA_FOLDER . "recettes")) {
    mkdir(DATA_FOLDER . "recettes", 0777, true);
}

if (!file_exists(DATA_FOLDER . "ingredients")) {
    mkdir(DATA_FOLDER . "ingredients", 0777, true);
}

// on défini leur chemin
define("DATA_UTILISATEURS", DATA_FOLDER . "utilisateurs/");
define("DATA_RECETTES", DATA_FOLDER . "recettes/");
define("DATA_INGREDIENTS", DATA_FOLDER . "ingredients/");

// On récupère le chemin absolu du navigateur du client vers index.php (exemple si URL = http://localhost/Projet/PHP/Burger/index.php, alors $browserPathToIndex = /Projet/PHP/Burger/index.php)
$browserPathToIndex = $_SERVER['PHP_SELF'];

// On récupère le chemin absolu du navigateur du client vers la racine du projet (exemple si URL = http://localhost/Projet/PHP/Burger/index.php, alors $browserUri = /Projet/PHP/Burger/)
$browserPath = strstr($browserPathToIndex, 'index.php', true);

// Définition des dossiers importants
// Accessible côté serveur
define("CONTROLLER", SRC_FOLDER . "controller/"); // Dossier des contrôleurs
define("MODEL", SRC_FOLDER . "model/"); // Dossier des modèles
define("VIEW", SRC_FOLDER . "view/"); // Dossier des vues

// Accessible côté client
define("PUBLIC_FOLDER", $browserPath); // Dossier public
define("ASSETS", PUBLIC_FOLDER . "assets/"); // Dossier des ressources
define("CSS", ASSETS . "css/"); // Dossier des feuilles de style
define("IMG", ASSETS . "img/"); // Dossier des images
define("JS", ASSETS . "js/"); // Dossier des scripts JavaScript

// On initialise l'autoloader (êvite d'avoir à faire des require_once)
require_once 'AutoLoader.php';
AutoLoader::start();

// On initialise le gestionnaire d'erreurs
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        $message = $error["message"];
        // On formate les retours à la ligne
        $message = str_replace("\n", "<br>", $message);
        ErrorController::error(500, $message, false);
    }
});

// On initialise la session
Session::start();

// On initialise le routeur
if (!isset($_GET["r"])) {
    $route = "";
} else {
    $route = $_GET["r"];
    unset($_GET["r"]);
    // On enlève le dernier slash de la route si il existe
    if (substr($route, -1) == "/") {
        $route = substr($route, 0, -1);

        // On redirige vers la route sans le slash
        Router::redirect($route);
        return;
    }
}

// Si l'application n'est pas installée, on redirige vers l'installation
if (!file_exists(DATA_FOLDER . ".installed.lock")) {
    // Si la route ne commence pas par 'install', on redirige vers la page d'installation
    if (stripos($route, "install") !== 0) {
        Router::redirect("install");
        return;
    }
}
// Si l'application est déjà installé
elseif (file_exists(DATA_FOLDER . ".installed.lock")) {
    // Si un utilisateur tente d'accéder à la page d'installation, on le redirige vers la page d'accueil
    if (stripos($route, "install") === 0) {
        Router::redirect("");
        return;
    }
}

Router::route($route);
