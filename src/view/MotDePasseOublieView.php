<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>MotDePasseOublie.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="wrapper axe_colonne second_axe_center margin_bottom_top_large">
    <!-- Box mot_de_passe_oublie -->
    <div class="box" id="mot_de_passe_oublie">
        <h2 class="box_titre">Mot de passe oublié</h2>
        <div class="box_contenu">
            <!-- Formulaire de mot de passe oublié -->
            <form id="form_mot_de_passe_oublie">
                <!-- Champ pour l'adresse email de l'utilisateur -->
                <div class="form-input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <!-- Boutons pour retourner à la connexion ou réinitialiser le mot de passe -->
                <div class="form-action">
                    <!-- Bouton pour se connecter -->
                    <a href="connexion" class="bouton">Retourner à la connexion</a>

                    <!-- Bouton pour réinitialiser le mot de passe -->
                    <button type="submit" class="bouton" id="bouton_mot_de_passe_oublie">Réinitialiser le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
</div>