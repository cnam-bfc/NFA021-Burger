<?php

class Database
{
    /**
     * Dernière version de la base de données
     * 
     * @var int
     */
    const LAST_VERSION = 3;

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
            // Connexion à la base de données
            self::$instance->connect();
            // Mise à jour de la base de données
            self::$instance->update();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Méthode permettant de récupérer l'instance de la classe Database
     *
     * @return Database (instance de la classe Database)
     */
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
            } catch (PDOException $e) {
                throw new Exception('Impossible de créer la table _metadata', 0, $e);
            }

            try {
                // Création du trigger empêchant l'ajout de lignes dans la table _metadata
                $this->pdo->exec('CREATE TRIGGER forbid_metadata_insert BEFORE INSERT ON _metadata FOR EACH ROW BEGIN SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Insertion on _metadata table is not allowed"; END');
            } catch (PDOException $e) {
            }

            $databaseVersion = 0;
        }

        // Convert to int
        $databaseVersion = (int) $databaseVersion;

        // Mise à jour de la base de données jusqu'à la dernière version
        while ($databaseVersion < self::LAST_VERSION) {
            $databaseVersion++;

            // Chemin du fichier de mise à jour
            $sqlUpdateFile = SRC_FOLDER . 'database' . DIRECTORY_SEPARATOR . $databaseVersion . '.sql';

            // Vérification de l'existence du fichier de mise à jour
            if (!file_exists($sqlUpdateFile)) {
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::LAST_VERSION . '), fichier de mise à jour manquant');
                break;
            }

            // Lecture du fichier de mise à jour
            $sqlQueries = file_get_contents($sqlUpdateFile);

            // Vérification du contenu du fichier de mise à jour
            if ($sqlQueries === false) {
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::LAST_VERSION . '), fichier de mise à jour illisible');
                break;
            }

            $this->pdo->beginTransaction();

            // Mise à jour de la base de données
            try {
                $this->pdo->exec($sqlQueries);
            } catch (PDOException $e) {
                try {
                    $this->pdo->rollBack();
                } catch (PDOException $e) {
                }
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::LAST_VERSION . '), erreur de syntaxe dans le fichier de mise à jour', 0, $e);
                break;
            }

            // Mise à jour de la version de la base de données
            try {
                $sqlQuery = 'UPDATE _metadata SET version = :version';
                $sqlStatement = $this->pdo->prepare($sqlQuery);
                $sqlStatement->bindValue(':version', $databaseVersion, PDO::PARAM_INT);
                $sqlStatement->execute();
            } catch (PDOException $e) {
                try {
                    $this->pdo->rollBack();
                } catch (PDOException $e) {
                }
                throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::LAST_VERSION . '), erreur lors de la mise à jour de la version', 0, $e);
                break;
            }

            // Commit
            if ($this->pdo->inTransaction()) {
                try {
                    $commitResult = $this->pdo->commit();
                    if (!$commitResult) {
                        throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::LAST_VERSION . ')', 0, $e);
                        break;
                    }
                } catch (PDOException $e) {
                    try {
                        $this->pdo->rollBack();
                    } catch (PDOException $e) {
                    }
                    throw new Exception('Impossible de mettre à jour la base de données (version ' . $databaseVersion . ' vers ' . self::LAST_VERSION . '), erreur lors de la mise à jour', 0, $e);
                    break;
                }
            }
        }
    }
}
