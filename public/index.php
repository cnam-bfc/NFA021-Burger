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

// On vérifie si dans data les dossier "utilisateurs" "recettes" et "ingredients" existents sinon on les créer
if (!file_exists(DATA_FOLDER . "utilisateurs")) {
    mkdir(DATA_FOLDER . "utilisateurs", 0777, true);
}

if (!file_exists(DATA_FOLDER . "recettes")) {
    mkdir(DATA_FOLDER . "recettes", 0777, true);
}

if (!file_exists(DATA_FOLDER . "ingredients")) {
    mkdir(DATA_FOLDER . "ingredients", 0777, true);
}

// On défini leur chemin dans des constantes
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

// On initialise le gestionnaire d'erreurs, exécution de code personnalisé (mais garde l'affichage de l'erreur par défaut)
// Erreurs PHP
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // On formate les retours à la ligne
    $errstr = str_replace("\n", "<br>", $errstr);
    ErrorController::error(500, $errstr, false, false);

    // On affiche l'erreur par défaut
    return false;
});
// Exceptions PHP
set_exception_handler(function ($exception) {
    // On formate les retours à la ligne
    $message = str_replace("\n", "<br>", $exception->getMessage());
    ErrorController::error(500, $message, false, false);

    // On affiche l'erreur par défaut
    restore_exception_handler();
    throw $exception;
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

// On gère l'affichage des images stockées dans le dossier 'data'
// Si la route commence par 'assets/img/ingredients/', on affiche l'image correspondante
if (stripos($route, "assets/img/ingredients/") === 0) {
    // Vérification faille de sécurité : Traversée de dossiers (Directory traversal attack)
    $basePath = DATA_INGREDIENTS;
    $realBasePath = realpath($basePath);

    $userPath = DATA_INGREDIENTS . substr($route, strlen("assets/img/ingredients/"));
    $realUserPath = realpath($userPath);

    // On vérifie que le chemin réel existe
    if ($realUserPath !== false) {
        // Si le chemin réel de l'image ne commence pas par le chemin réel du dossier des images, alors c'est une tentative de traversée de dossiers
        if (strpos($realUserPath, $realBasePath) !== 0) {
            ErrorController::error(403, "Accès interdit");
            return;
        }
        // Sinon si le fichier existe, on l'affiche
        elseif (file_exists($realUserPath)) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($realUserPath);
            // Vérification du type MIME
            if (!in_array($mime, ["image/jpeg", "image/png", "image/gif"])) {
                ErrorController::error(403, "Accès interdit");
                return;
            }
            header("Content-Type: " . $mime);
            readfile($realUserPath);
            return;
        }
    }
}
// Si la route commence par 'assets/img/recettes/', on affiche l'image correspondante
elseif (stripos($route, "assets/img/recettes/") === 0) {
    // Vérification faille de sécurité : Traversée de dossiers (Directory traversal attack)
    $basePath = DATA_RECETTES;
    $realBasePath = realpath($basePath);

    $userPath = DATA_RECETTES . substr($route, strlen("assets/img/recettes/"));
    $realUserPath = realpath($userPath);

    // On vérifie que le chemin réel existe
    if ($realUserPath !== false) {
        // Si le chemin réel de l'image ne commence pas par le chemin réel du dossier des images, alors c'est une tentative de traversée de dossiers
        if (strpos($realUserPath, $realBasePath) !== 0) {
            ErrorController::error(403, "Accès interdit");
            return;
        }
        // Sinon si le fichier existe, on l'affiche
        elseif (file_exists($realUserPath)) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($realUserPath);
            // Vérification du type MIME
            if (!in_array($mime, ["image/jpeg", "image/png", "image/gif"])) {
                ErrorController::error(403, "Accès interdit");
                return;
            }
            header("Content-Type: " . $mime);
            readfile($realUserPath);
            return;
        }
    }
}
// Si la route commence par 'assets/img/utilisateurs/', on affiche l'image correspondante
elseif (stripos($route, "assets/img/utilisateurs/") === 0) {
    // Vérification faille de sécurité : Traversée de dossiers (Directory traversal attack)
    $basePath = DATA_UTILISATEURS;
    $realBasePath = realpath($basePath);

    $userPath = DATA_UTILISATEURS . substr($route, strlen("assets/img/utilisateurs/"));
    $realUserPath = realpath($userPath);

    // On vérifie que le chemin réel existe
    if ($realUserPath !== false) {
        // Si le chemin réel de l'image ne commence pas par le chemin réel du dossier des images, alors c'est une tentative de traversée de dossiers
        if (strpos($realUserPath, $realBasePath) !== 0) {
            ErrorController::error(403, "Accès interdit");
            return;
        }
        // Sinon si le fichier existe, on l'affiche
        elseif (file_exists($realUserPath)) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($realUserPath);
            // Vérification du type MIME
            if (!in_array($mime, ["image/jpeg", "image/png", "image/gif"])) {
                ErrorController::error(403, "Accès interdit");
                return;
            }
            header("Content-Type: " . $mime);
            readfile($realUserPath);
            return;
        }
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
