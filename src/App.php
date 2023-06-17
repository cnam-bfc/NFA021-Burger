<?php
class App
{
    const VERSION = "1.0.0";

    /**
     * Méthode permettant de récupérer la version de git
     * 
     * @return string
     */
    public static function getGitVersion()
    {
        $gitFolder = __DIR__ . "/../.git";
        $gitFolder = realpath($gitFolder);
        if (!file_exists($gitFolder)) {
            return "";
        }

        $gitBranchFile = $gitFolder . "/HEAD";
        $gitBranchFile = realpath($gitBranchFile);

        $gitBranch = trim(file_get_contents($gitBranchFile));
        $gitBranch = substr($gitBranch, 5);

        $lastCommit = $gitFolder . "/" . $gitBranch;
        $lastCommit = realpath($lastCommit);

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
