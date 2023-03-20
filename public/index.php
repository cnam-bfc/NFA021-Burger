<?php require_once 'alwaysInclude.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>My Website</title>
    <meta charset="utf-8">
</head>

<body>
    <h1>My Website</h1>
    <p>Welcome to my website!</p>
    <p>
        <?php
        require_once 'app/personne.php';

        // Si le fichier 'personne.txt' existe, on a 1 chance sur 2 de le lire sinon on en créer un au hasard
        if (file_exists('personne.txt')) {
            $random = rand(0, 1);
            if ($random === 0) {
                $personne = unserialize(file_get_contents('personne.txt'));
            } else {
                $randomFirstNames = array('John', 'Jane', 'Jack', 'Jill', 'Joe');
                $randomLastNames = array('Doe', 'Smith', 'Doe', 'Smith', 'Doe');
                $personne = new Personne($randomLastNames[array_rand($randomLastNames)], $randomFirstNames[array_rand($randomFirstNames)]);
            }
        } else {
            $personne = new Personne('Doe', 'John');
        }

        echo $personne->getNom() . ' ' . $personne->getPrenom();

        // On sérialise l'objet
        $serialized = serialize($personne);

        // On sauvegarde la sérialisation dans un fichier
        file_put_contents('personne.txt', $serialized);
        ?>
    </p>
</body>

</html>