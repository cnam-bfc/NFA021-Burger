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
     * Méthode permettant de savoir si le formulaire a été soumis
     * 
     * @param string $method (méthode utilisée pour récupérer le paramètre)
     * @return bool
     */
    public static function isFormSubmited($method = Form::METHOD_POST)
    {
        if ($method == Form::METHOD_POST) {
            if (isset($_POST) && !empty($_POST)) {
                return true;
            }
        } elseif ($method == Form::METHOD_GET) {
            if (isset($_GET) && !empty($_GET)) {
                return true;
            }
        }
        return false;
    }

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
     * @return mixed|null (valeur du paramètre ou null si le paramètre n'existe pas)
     */
    public static function getParam($paramName, $method = Form::METHOD_POST, $type = Form::TYPE_MIXED, $required = true, $convert = true)
    {
        // On récupère la valeur du paramètre
        $value = null;
        if ($method == Form::METHOD_POST) {
            if (isset($_POST[$paramName])) {
                $value = $_POST[$paramName];
            }
        } elseif ($method == Form::METHOD_GET) {
            if (isset($_GET[$paramName])) {
                $value = $_GET[$paramName];
            }
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

    /**
     * Méthode permettant de récupérer un fichier passé en POST
     * Affiche une erreur si le paramètre est obligatoire et n'existe pas
     * 
     * @param string $paramName (nom du paramètre)
     * @param bool $required (paramètre obligatoire)
     * @param int $maxSize (taille maximale du fichier, en octets)
     * @param array $extensions (extensions autorisées)
     * @return string|null (chemin du fichier ou null si le paramètre n'existe pas)
     */
    public static function getFile($paramName, $required = true, $maxSize = 2097152, $extensions = array("jpg", "png", "gif"))
    {
        // On récupère la valeur du paramètre
        $value = null;
        if (isset($_FILES[$paramName])) {
            $value = $_FILES[$paramName];
        }

        // Si le paramètre est obligatoire et n'existe pas, on affiche une erreur
        if ($required && $value == null) {
            ErrorController::error(400, "Le paramètre " . $paramName . " est obligatoire");
            exit;
        }
        // Si le paramètre n'existe pas, on retourne null
        elseif ($value == null) {
            return null;
        }

        // Source du code ci-dessous : https://www.php.net/manual/en/features.file-upload.php#114004
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (!isset($_FILES[$paramName]['error']) || is_array($_FILES[$paramName]['error'])) {
            //throw new RuntimeException('Invalid parameters.');
            ErrorController::error(400, "Le paramètre " . $paramName . " est invalide");
            exit;
        }

        // Check $_FILES[$paramName]['error'] value.
        switch ($_FILES[$paramName]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                //throw new RuntimeException('No file sent.');
                ErrorController::error(400, "Aucun fichier envoyé pour le paramètre " . $paramName);
                exit;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                //throw new RuntimeException('Exceeded filesize limit.');
                ErrorController::error(400, "Le fichier envoyé pour le paramètre " . $paramName . " est trop volumineux (" . Form::convertirOctets($_FILES[$paramName]['size']) . ")");
                exit;
            default:
                //throw new RuntimeException('Unknown errors.');
                ErrorController::error(400, "Une erreur inconnue est survenue lors de l'envoi du fichier pour le paramètre " . $paramName);
                exit;
        }

        // You should also check filesize here. 
        if ($_FILES[$paramName]['size'] > $maxSize) {
            //throw new RuntimeException('Exceeded filesize limit.');
            ErrorController::error(400, "Le fichier envoyé pour le paramètre " . $paramName . " est trop volumineux (" . Form::convertirOctets($_FILES[$paramName]['size']) . " / " . Form::convertirOctets($maxSize) . ")");
            exit;
        }

        // DO NOT TRUST $_FILES[$paramName]['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $extension = array_search(
            $finfo->file($_FILES[$paramName]['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
            ),
            true
        )) {
            //throw new RuntimeException('Invalid file format.');
            ErrorController::error(400, "Le fichier envoyé pour le paramètre " . $paramName . " n'est pas lisible");
            exit;
        }

        // On vérifie que l'extension du fichier est autorisée
        if (!in_array($extension, $extensions)) {
            //throw new RuntimeException('Invalid file format.');
            ErrorController::error(400, "Le fichier envoyé pour le paramètre " . $paramName . " n'est pas autorisé (extensions autorisées : " . implode(", ", $extensions) . ")");
            exit;
        }

        // *** CODE INUTILE POUR NOTRE PROJET ***
        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        /*if (!move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            sprintf(
                './uploads/%s.%s',
                sha1_file($_FILES['upfile']['tmp_name']),
                $ext
            )
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        echo 'File is uploaded successfully.';*/
        // *** FIN DU CODE INUTILE POUR NOTRE PROJET ***

        // Retourne le fichier
        return $_FILES[$paramName];
    }

    /**
     * Méthode permettant de convertir des octets en une taille lisible
     * 
     * @param int $bytes (nombre d'octets)
     * @param int $precision (nombre de décimales)
     * @return string (taille lisible)
     */
    private static function convertirOctets($bytes, $precision = 2)
    {
        $units = array('o', 'Ko', 'Mo', 'Go', 'To');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
