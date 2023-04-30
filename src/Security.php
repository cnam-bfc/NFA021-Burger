<?php

/**
 * Classe permettant de gérer la sécurité (mots de passe notamment)
 */
class Security
{
    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::createInstance();
        }
        return self::$instance;
    }

    public static function createInstance()
    {
        self::$instance = new Security();
    }

    private $passwordHashKey;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $config = Configuration::getInstance();

        // Si la clé de hashage n'existe pas, on la génère
        if (!$config->hasSecurityPasswordHashKey()) {
            $this->passwordHashKey = bin2hex(random_bytes(32));
            $config->setSecurityPasswordHashKey($this->passwordHashKey);
        }
        // Sinon on récupère la clé de hashage
        else {
            $this->passwordHashKey = $config->getSecurityPasswordHashKey();
        }
    }

    /**
     * Fonction permettant de hasher un mot de passe
     * 
     * @param string $password (mot de passe à hasher)
     * @return string (mot de passe hashé)
     */
    public function hashPassword($password)
    {
        $algo = PASSWORD_BCRYPT;
        $options = array(
            'cost' => 12
        );

        $hashedPassword = password_hash($password, $algo, $options);

        if ($hashedPassword === false) {
            throw new Exception('Erreur lors du hashage du mot de passe');
        }

        return $hashedPassword;
    }

    /**
     * Fonction permettant de vérifier qu'un mot de passe correspond à un hash
     * 
     * @param string $password (mot de passe à vérifier)
     * @param string $hash (hash à vérifier)
     * @return bool (true si le mot de passe correspond au hash, false sinon)
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
