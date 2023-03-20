<?php
// Récupération de l'ancienne valeur de include_path
$old_include_path = get_include_path();

// Récupération du dossier 'src'
$src_folder = __DIR__ . '/../src/';

// Ajout du dossier ../src/ à la valeur de include_path
set_include_path($old_include_path . PATH_SEPARATOR . $src_folder);

// Définition du dossier de travail
// Si nous nous trouvons dans un conteneur Docker
if (file_exists('/proc/self/cgroup') && strpos(file_get_contents('/proc/self/cgroup'), 'docker') !== false) {
    // On définit le dossier de travail à celui défini dans le conteneur (WORKDIR)
    $workdir = getenv('PWD');
} else {
    // Sinon on définit le dossier de travail à celui du projet
    $workdir = __DIR__ . '/../data/';
}

// On définit le dossier de travail où se trouverons les fichiers de données
if ($workdir !== false) {
    if (!file_exists($workdir)) {
        mkdir($workdir, 0777, true);
    }
    chdir($workdir);
}
