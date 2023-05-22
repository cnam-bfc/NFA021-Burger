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
                <!-- Champ pour le nom d'utilisateur de l'utilisateur -->
                <div class="form-input">
                    <label for="nom_utilisateur">Nom d'utilisateur</label>
                    <input type="text" id="nom_utilisateur" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
                </div>
                <!-- Champ pour l'adresse email de l'utilisateur -->
                <div class="form-input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <!-- Champ pour le mot de passe de l'utilisateur -->
                <div class="form-input">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
                </div>
                <!-- Champ pour la confirmation du mot de passe de l'utilisateur -->
                <div class="form-input">
                    <label for="confirmation_mot_de_passe">Confirmation du mot de passe</label>
                    <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" placeholder="Confirmation du mot de passe" required>
                </div>

                <!-- Boutons pour se connecter ou se créer un compte -->
                <div class="form-action">
                    <!-- Bouton pour se connecter -->
                    <a href="<?php echo PUBLIC_FOLDER ?>connexion" class="bouton">J'ai déjà un compte</a>

                    <!-- Bouton pour se créer un compte -->
                    <button type="submit" class="bouton" id="bouton_inscription">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>