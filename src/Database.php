<?php

class Database
{
    /**
     * Dernière version de la base de données
     * 
     * @var int
     */
    const VERSION = 1;

    private static $instance = null;

    /**
     * Méthode permettant de créer une instance de la classe Database
     *
     * @return bool (true si la connexion est réussie, false sinon)
     */
    public static function createInstance()
    {
        try {
            self::$instance = new Database();
            self::$instance->connect();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $success = self::createInstance();
            if (!$success) {
                throw new Exception('Impossible de se connecter à la base de données');
            }
        }
        return self::$instance;
    }

    /**
     * Méthode permettant de tester la connexion à la base de données
     * 
     * @param string $ip (adresse IP de la base de données)
     * @param int $port (port de la base de données)
     * @param string $name (nom de la base de données)
     * @param string $user (nom d'utilisateur de la base de données)
     * @param string $password (mot de passe de la base de données)
     * @return bool (true si la connexion est réussie, false sinon)
     */
    public static function testConnectionBdd($ip, $port, $name, $user, $password)
    {
        try {
            new PDO('mysql:host=' . $ip . ';port=' . $port . ';dbname=' . $name . ';charset=utf8', $user, $password, array(
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * PDO
     *
     * @var PDO
     */
    private $pdo;

    public function connect()
    {
        $config = Configuration::getInstance();
        $this->pdo = new PDO('mysql:host=' . $config->getBddHost() . ';port=' . $config->getBddPort() . ';dbname=' . $config->getBddName() . ';charset=utf8', $config->getBddUser(), $config->getBddPassword(), array(
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
    }

    /**
     * Méthode permettant de récupérer PDO
     * 
     * @return PDO (instance de PDO)
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * Méthode permettant de mettre à jour la base de données si nécessaire
     */
    public function update()
    {
        $databaseVersion = null;

        // Récupération de la version actuelle de la base de données
        try {
            $sqlQuery = 'SELECT version FROM _metadata';
            $sqlStatement = $this->pdo->prepare($sqlQuery);
            $sqlStatement->execute();
            $metadata = $sqlStatement->fetch(PDO::FETCH_ASSOC);
            $databaseVersion = $metadata['version'];
        } catch (PDOException $e) {
        }

        // Si version inexistant, on crée la table _metadata
        if ($databaseVersion === null) {
            try {
                // Création de la table _metadata
                $this->pdo->exec('CREATE TABLE _metadata (id INT, version INT, PRIMARY KEY (id))');

                // Insertion de la version 0
                $this->pdo->exec('INSERT INTO _metadata (id, version) VALUES (1, 0)');

                // Création du trigger empêchant l'ajout de lignes dans la table _metadata
                $this->pdo->exec('CREATE TRIGGER forbid_metadata_insert BEFORE INSERT ON _metadata FOR EACH ROW BEGIN SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Insertion on _metadata table is not allowed"; END');

                $databaseVersion = 0;
            } catch (PDOException $e) {
                throw new Exception('Impossible de créer la table _metadata');
            }
        }

        // Convert to int
        $databaseVersion = (int) $databaseVersion;

        while ($databaseVersion < self::VERSION) {
            $databaseVersion++;

            $sqlUpdateFile = SRC_FOLDER . 'database' . DIRECTORY_SEPARATOR . $databaseVersion . '.sql';

            if (!file_exists($sqlUpdateFile)) {
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::VERSION . '), fichier de mise à jour manquant');
            }

            $sqlQueries = file_get_contents($sqlUpdateFile);
            if ($sqlQueries === false) {
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::VERSION . '), fichier de mise à jour illisible');
            }

            $this->pdo->beginTransaction();

            try {
                $this->pdo->exec($sqlQueries);
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::VERSION . '), erreur de syntaxe dans le fichier de mise à jour');
            }

            try {
                $this->pdo->commit();
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::VERSION . '), erreur lors de la mise à jour');
            }
        }
    }
}
