<div class="wrapper_colonne">
    <h1 class="titre">Installation</h1>
    <div class="box" id="box_install_bdd">
        <h2 class="box_titre">Configuration de la base de données</h2>
        <div class="box_contenu">
            <!-- Champ pour l'ip de la base de données -->
            <div class="form-input">
                <label for="ip_bdd">Adresse IP</label>
                <input type="text" id="ip_bdd" name="ip_bdd" placeholder="Adresse IP de la base de données" required>
            </div>
            <!-- Champ pour le port de la base de données -->
            <div class="form-input">
                <label for="port_bdd">Port</label>
                <input type="number" min="0" id="port_bdd" name="port_bdd" placeholder="Port de la base de données" required value="3306">
            </div>
            <!-- Champ pour le nom de la base de données -->
            <div class="form-input">
                <label for="nom_bdd">Nom de la base de données</label>
                <input type="text" id="nom_bdd" name="nom_bdd" placeholder="Nom de la base de données" required>
            </div>
            <!-- Champ pour le nom d'utilisateur de la base de données -->
            <div class="form-input">
                <label for="user_bdd">Nom d'utilisateur</label>
                <input type="text" id="user_bdd" name="user_bdd" placeholder="Nom d'utilisateur de la base de données" required>
            </div>
            <!-- Champ pour le mot de passe de la base de données -->
            <div class="form-input">
                <label for="mdp_bdd">Mot de passe</label>
                <input type="password" id="mdp_bdd" name="mdp_bdd" placeholder="Mot de passe de la base de données" required>
            </div>
            <!-- Bouton pour tester la connexion à la base de données -->
            <div class="form-action">
                <button id="test_bdd" class="bouton bouton_primaire">Tester la connexion</button>
            </div>
        </div>
    </div>

    <div class="center_items_horizontal">
        <button id="install" class="bouton bouton_primaire">Installer</button>
    </div>
</div>