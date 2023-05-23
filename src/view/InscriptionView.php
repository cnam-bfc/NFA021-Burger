<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>Inscription.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="wrapper axe_colonne second_axe_center margin_bottom_top_large">
    <!-- Box inscription -->
    <div class="box" id="inscription">
        <h2 class="box_titre">Inscription</h2>
        <div class="box_contenu">
            <!-- Formulaire d'inscription -->
            <form id="form_inscription">
                <!-- Champ pour le nom de l'utilisateur -->
                <div class="form-input">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="Nom" required>
                </div>
                <!-- Champ pour le prénom de l'utilisateur -->
                <div class="form-input">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
                </div>
                <!-- Champ pour le nom d'utilisateur de l'utilisateur -->
                <div class="form-input">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" pattern="^[a-zA-Z0-9_]{3,20}$" id="username" name="username" placeholder="Nom d'utilisateur" required>
                </div>
                <!-- Champ pour l'adresse email de l'utilisateur -->
                <div class="form-input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <!-- Champ pour le mot de passe de l'utilisateur -->
                <div class="form-input">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                </div>
                <!-- Champ pour la confirmation du mot de passe de l'utilisateur -->
                <div class="form-input">
                    <label for="password_confirm">Confirmation du mot de passe</label>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirmation du mot de passe" required>
                </div>

                <!-- Boutons pour se connecter ou se créer un compte -->
                <div class="form-action">
                    <!-- Bouton pour se connecter -->
                    <button type="button" class="bouton" id="bouton_redirection_connexion">J'ai déjà un compte</button>

                    <!-- Bouton pour se créer un compte -->
                    <button type="submit" class="bouton" id="bouton_inscription">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>