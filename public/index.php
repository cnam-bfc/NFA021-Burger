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
define("ASSETS", $browserPath . "assets/"); // Dossier des ressources
define("CSS", ASSETS . "css/"); // Dossier des feuilles de style
define("IMG", ASSETS . "img/"); // Dossier des images
define("JS", ASSETS . "js/"); // Dossier des scripts JavaScript

// On initialise l'autoloader (êvite d'avoir à faire des require_once)
require_once 'AutoLoader.php';
AutoLoader::start();

// On initialise le routeur (permet de faire le lien entre les routes et les contrôleurs)
require_once 'Router.php';

if (!isset($_GET["root"])) {
    $route = "accueil";
} else {
    $route = $_GET["root"];
}

Router::route($route);
