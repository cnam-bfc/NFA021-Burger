<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>Connexion.css">

<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>Connexion.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="wrapper axe_colonne second_axe_center margin_bottom_top_large">
    <!-- Box connexion -->
    <div class="box" id="connexion">
        <h2 class="box_titre">Connexion</h2>
        <div class="box_contenu">
            <!-- Formulaire de connexion -->
            <form id="form_connexion">
                <!-- Champ pour l'identifiant de l'utilisateur -->
                <div class="form-input">
                    <label for="identifiant">Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant" placeholder="Nom d'utilisateur ou email" required>
                </div>
                <!-- Champ pour le mot de passe de l'utilisateur -->
                <div class="form-input">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                    <!-- Lien pour réinitialiser le mot de passe -->
                    <a href="mot_de_passe_oublie" class="lien">Mot de passe oublié ?</a>
                </div>

                <!-- Boutons pour se créer un compte ou se connecter -->
                <div class="form-action">
                    <!-- Bouton pour se créer un compte -->
                    <button type="button" class="bouton" id="bouton_redirection_inscription">Créer un compte</button>

                    <!-- Bouton pour se connecter -->
                    <button type="submit" class="bouton" id="bouton_connexion">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>