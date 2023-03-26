<?php
// Récupération de l'ancienne valeur de include_path
$old_include_path = get_include_path();

// Récupération du dossier 'src'
define("SRC_FOLDER", __DIR__ . '/../src/');

// Ajout du dossier ../src/ à la valeur de include_path
set_include_path($old_include_path . PATH_SEPARATOR . SRC_FOLDER);

// Définition du dossier de travail
define("DATA_FOLDER", __DIR__ . '/../data/');

// On définit le dossier de travail où se trouverons les fichiers de données
if (DATA_FOLDER !== false) {
    if (!file_exists(DATA_FOLDER)) {
        mkdir(DATA_FOLDER, 0777, true);
    }
    chdir(DATA_FOLDER);
}

// on récupère la variable serveur PHP_SELF et on retire index.php 
$php_self = $_SERVER['PHP_SELF'];
$cheminRelatif = strstr($php_self, 'index.php', true);

// Définition de constantes utiles pour le projet
define("CONTROLLER", SRC_FOLDER . "controller/"); // On définit le dossier des contrôleurs
define("MODEL", SRC_FOLDER . "model/"); // On définit le dossier des modèles
define("VIEW", SRC_FOLDER . "view/"); // On définit le dossier des vues
define("ASSETS", $cheminRelatif . "assets/"); // On définit le dossier des ressources
define("CSS", ASSETS . "css/"); // On définit le dossier des feuilles de style
define("IMG", ASSETS . "img/"); // On définit le dossier des images
define("JS", ASSETS . "js/"); // On définit le dossier des scripts JavaScript

// On inclut l'autoloader
require_once 'AutoLoader.php';