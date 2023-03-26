<?php
require_once '_config.php';

if (!isset($_GET["root"])) {
    $request = "accueil";
} else {
    $request = $_GET["root"];
}

$routeur = new RooterController($request);
$routeur->renderController();
