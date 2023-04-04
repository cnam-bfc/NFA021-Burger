<?php

/**
 * Class Form
 * 
 * Classe permettant de gérer les formulaires
 */
class Form
{
    const METHOD_POST = "POST";
    const METHOD_GET = "GET";

    const TYPE_STRING = "string";
    const TYPE_INT = "int";
    const TYPE_FLOAT = "float";
    const TYPE_DOUBLE = "double";
    const TYPE_BOOL = "bool";
    const TYPE_ARRAY = "array";
    const TYPE_MIXED = "mixed";
    const TYPE_EMAIL = "email";

    /**
     * Méthode permettant de récupérer un paramètre passé en POST ou en GET
     * Affiche une erreur si le paramètre est obligatoire et n'existe pas
     * Affiche une erreur si le paramètre n'est pas du bon type
     * 
     * @param string $paramName (nom du paramètre)
     * @param string $method (méthode utilisée pour récupérer le paramètre)
     * @param string $type (type de paramètre)
     * @param bool $required (paramètre obligatoire)
     * @param bool $convert (convertir le paramètre)
     * @return mixed
     */
    public static function getParam($paramName, $method, $type = Form::TYPE_MIXED, $required = true, $convert = true)
    {
        // On récupère la valeur du paramètre
        $value = null;
        if ($method == Form::METHOD_POST) {
            if (isset($_POST[$paramName]))
                $value = $_POST[$paramName];
        } elseif ($method == Form::METHOD_GET) {
            if (isset($_GET[$paramName]))
                $value = $_GET[$paramName];
        }

        // Si le paramètre est obligatoire et n'existe pas, on affiche une erreur
        if ($required && $value == null) {
            ErrorController::error(400, "Le paramètre " . $paramName . " est obligatoire");
            exit;
        }

        // Si le paramètre n'est pas du bon type, on affiche une erreur
        if ($value != null) {
            switch ($type) {
                case Form::TYPE_STRING:
                    if (!is_string($value)) {
                        if ($convert && settype($value, "string")) {
                            // Conversion réussie
                        } else {
                            // Conversion échouée
                            ErrorController::error(400, "Le paramètre " . $paramName . " doit être une chaîne de caractères");
                            exit;
                        }
                    }
                    break;
                case Form::TYPE_INT:
                    if (!is_int($value)) {
                        if ($convert && settype($value, "int")) {
                            // Conversion réussie
                        } else {
                            // Conversion échouée
                            ErrorController::error(400, "Le paramètre " . $paramName . " doit être un entier");
                            exit;
                        }
                    }
                    break;
                case Form::TYPE_FLOAT:
                    if (!is_float($value)) {
                        if ($convert && settype($value, "float")) {
                            // Conversion réussie
                        } else {
                            // Conversion échouée
                            ErrorController::error(400, "Le paramètre " . $paramName . " doit être un nombre décimal");
                            exit;
                        }
                    }
                    break;
                case Form::TYPE_DOUBLE:
                    if (!is_double($value)) {
                        if ($convert && settype($value, "double")) {
                            // Conversion réussie
                        } else {
                            // Conversion échouée
                            ErrorController::error(400, "Le paramètre " . $paramName . " doit être un nombre décimal");
                            exit;
                        }
                    }
                    break;
                case Form::TYPE_BOOL:
                    if (!is_bool($value)) {
                        if ($convert && settype($value, "bool")) {
                            // Conversion réussie
                        } else {
                            // Conversion échouée
                            ErrorController::error(400, "Le paramètre " . $paramName . " doit être un booléen");
                            exit;
                        }
                    }
                    break;
                case Form::TYPE_ARRAY:
                    if (!is_array($value)) {
                        if ($convert && settype($value, "array")) {
                            // Conversion réussie
                        } else {
                            // Conversion échouée
                            ErrorController::error(400, "Le paramètre " . $paramName . " doit être un tableau");
                            exit;
                        }
                    }
                    break;
                case Form::TYPE_EMAIL:
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        ErrorController::error(400, "Le paramètre " . $paramName . " doit être une adresse email");
                        exit;
                    }
                    break;
            }
        }

        return $value;
    }
}
