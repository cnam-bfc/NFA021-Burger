<?php
class App
{
    const VERSION = "0.1.0";

    /**
     * Méthode permettant de récupérer la version de git
     * 
     * @return string
     */
    public static function getGitVersion()
    {
        $lastCommit = __DIR__ . "/../.git/ORIG_HEAD";
        $lastCommit = realpath($lastCommit);
        if (!file_exists($lastCommit)) {
            return "";
        }

        $hash = file_get_contents($lastCommit);
        $hash = substr($hash, 0, 7);

        return $hash;
    }

    /**
     * Méthode permettant de récupérer la version de l'application
     * 
     * @return string
     */
    public static function getAppVersion()
    {
        $version = App::VERSION;
        $gitVersion = App::getGitVersion();
        if ($gitVersion != "") {
            $version .= " - " . $gitVersion;
        }

        return $version;
    }
}
