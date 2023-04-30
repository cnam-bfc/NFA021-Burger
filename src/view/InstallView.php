<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>Install.css">

<!-- On ajoute la feuille de js associé à la page -->
<script type="text/javascript" src="<?php echo JS ?>Install.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="padding_default wrapper axe_colonne second_axe_center">
    <h1 class="titre_bulle">Initialisation</h1>

    <div id="boxs" class="wrapper axe_colonne margin_bottom_top_large">
        <!-- DÉBUT * ÉTAPE 1 - Configuration de la base de données -->
        <form id="config_bdd">
            <div class="box" id="box_config_bdd">
                <h2 class="box_titre">ÉTAPE 1 - Configuration de la base de données</h2>
                <div class="box_contenu">
                    <!-- Description de l'étape -->
                    <p>
                        Vous devez renseigner les informations de connexion à la base de données.
                        <br>
                        Si vous ne connaissez pas ces informations, contactez votre hébergeur.
                    </p>

                    <hr class="delimitation_trait">

                    <!-- Formulaire de configuration de la base de données -->
                    <!-- Champ pour l'ip de la base de données -->
                    <div class="form-input">
                        <label for="host_bdd">Adresse IP</label>
                        <input type="text" id="host_bdd" name="host_bdd" placeholder="Adresse IP de la base de données" required disabled>
                    </div>
                    <!-- Champ pour le port de la base de données -->
                    <div class="form-input">
                        <label for="port_bdd">Port</label>
                        <input type="number" min="0" id="port_bdd" name="port_bdd" placeholder="Port de la base de données" required value="3306" disabled>
                    </div>
                    <!-- Champ pour le nom de la base de données -->
                    <div class="form-input">
                        <label for="database_bdd">Nom de la base de données</label>
                        <input type="text" id="database_bdd" name="database_bdd" placeholder="Nom de la base de données" required disabled>
                    </div>
                    <!-- Champ pour le nom d'utilisateur de la base de données -->
                    <div class="form-input">
                        <label for="user_bdd">Nom d'utilisateur</label>
                        <input type="text" id="user_bdd" name="user_bdd" placeholder="Nom d'utilisateur de la base de données" required disabled>
                    </div>
                    <!-- Champ pour le mot de passe de la base de données -->
                    <div class="form-input">
                        <label for="password_bdd">Mot de passe</label>
                        <input type="password" id="password_bdd" name="password_bdd" placeholder="Mot de passe de la base de données" required disabled>
                    </div>

                    <!-- Bouton pour tester la connexion à la base de données -->
                    <div class="form-action">
                        <button type="submit" class="bouton" disabled>Tester et enregistrer la configuration</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- FIN * ÉTAPE 1 - Configuration de la base de données -->

        <!-- DÉBUT * ÉTAPE 2 - Installation de la base de données -->
        <form id="install_bdd">
            <div class="box" id="box_install_bdd">
                <h2 class="box_titre">ÉTAPE 2 - Installation de la base de données</h2>
                <div class="box_contenu">
                    <!-- Description de l'étape -->
                    <p>
                        En cliquant sur le bouton ci-dessous, vous allez installer et mettre à jour la base de données vers la dernière version.
                    </p>

                    <hr class="delimitation_trait">

                    <!-- Bouton pour installer la base de données -->
                    <div class="form-action">
                        <button type="submit" class="bouton" disabled>Installer la base de données</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- FIN * ÉTAPE 2 - Installation de la base de données -->

        <!-- DÉBUT * ÉTAPE 3 - Configuration du compte gérant -->
        <form id="create_gerant">
            <div class="box" id="box_create_gerant">
                <h2 class="box_titre">ÉTAPE 3 - Création d'un compte gérant</h2>
                <div class="box_contenu">
                    <!-- Description de l'étape -->
                    <p>
                        Vous devez renseigner les informations du compte gérant.
                        <br>
                        Ce compte vous permettra de vous connecter à l'application.
                    </p>

                    <hr class="delimitation_trait">

                    <!-- Formulaire de configuration du compte gérant -->
                    <!-- Champ pour le nom du compte gérant -->
                    <div class="form-input">
                        <label for="nom_gerant">Nom</label>
                        <input type="text" id="nom_gerant" name="nom_gerant" placeholder="Nom du compte gérant" required disabled>
                    </div>
                    <!-- Champ pour le prénom du compte gérant -->
                    <div class="form-input">
                        <label for="prenom_gerant">Prénom</label>
                        <input type="text" id="prenom_gerant" name="prenom_gerant" placeholder="Prénom du compte gérant" required disabled>
                    </div>
                    <!-- Champ pour l'email du compte gérant -->
                    <div class="form-input">
                        <label for="email_gerant">Email</label>
                        <input type="email" id="email_gerant" name="email_gerant" placeholder="Email du compte gérant" required disabled>
                    </div>
                    <!-- Champ pour le login du compte gérant -->
                    <div class="form-input">
                        <label for="login_gerant">Identifiant</label>
                        <input type="text" id="login_gerant" name="login_gerant" placeholder="Identifiant du compte gérant" required disabled>
                    </div>
                    <!-- Champ pour le mot de passe du compte gérant -->
                    <div class="form-input">
                        <label for="password_gerant">Mot de passe</label>
                        <input type="password" id="password_gerant" name="password_gerant" placeholder="Mot de passe du compte gérant" required disabled>
                    </div>
                    <!-- Champ pour la confirmation du mot de passe du compte gérant -->
                    <div class="form-input">
                        <label for="password_confirm_gerant">Confirmation du mot de passe</label>
                        <input type="password" id="password_confirm_gerant" name="password_confirm_gerant" placeholder="Confirmation du mot de passe du compte gérant" required disabled>
                    </div>

                    <!-- Bouton pour créer le compte gérant -->
                    <div class="form-action">
                        <button type="submit" class="bouton" disabled>Créer le compte gérant</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- FIN * ÉTAPE 3 - Configuration du compte gérant -->

        <!-- DÉBUT * ÉTAPE 4 - (Optionnel) Ajouter les unités par défaut (recommandé) -->
        <form id="install_unites">
            <div class="box" id="box_install_unites">
                <h2 class="box_titre">ÉTAPE 4 - (Optionnel) Ajouter les unités par défaut (recommandé)</h2>
                <div class="box_contenu">
                    <!-- Description de l'étape -->
                    <p>
                        En cliquant sur le bouton ci-dessous, vous allez ajouter les unités par défaut.
                        <br>
                        Ces unités sont recommandées pour une utilisation optimale de l'application.
                    </p>

                    <hr class="delimitation_trait">

                    <!-- Bouton pour installer les unités par défaut -->
                    <div class="form-action">
                        <button type="submit" class="bouton" disabled>Ajouter les unités par défaut</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- FIN * ÉTAPE 4 - (Optionnel) Ajouter les unités par défaut (recommandé) -->

        <!-- DÉBUT * ÉTAPE 5 - (Optionnel) Ajouter les emballages par défaut (recommandé) -->
        <form id="install_emballages">
            <div class="box" id="box_install_emballages">
                <h2 class="box_titre">ÉTAPE 5 - (Optionnel) Ajouter les emballages par défaut (recommandé)</h2>
                <div class="box_contenu">
                    <!-- Description de l'étape -->
                    <p>
                        En cliquant sur le bouton ci-dessous, vous allez ajouter les emballages par défaut.
                        <br>
                        Ces emballages sont recommandés pour une utilisation optimale de l'application.
                    </p>

                    <hr class="delimitation_trait">

                    <!-- Bouton pour installer les emballages par défaut -->
                    <div class="form-action">
                        <button type="submit" class="bouton" disabled>Ajouter les emballages par défaut</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- FIN * ÉTAPE 5 - (Optionnel) Ajouter les emballages par défaut (recommandé) -->

        <!-- DÉBUT * ÉTAPE 6 - (Optionnel) Ajouter les fournisseurs par défaut (recommandé) -->
        <form id="install_fournisseurs">
            <div class="box" id="box_install_fournisseurs">
                <h2 class="box_titre">ÉTAPE 6 - (Optionnel) Ajouter les fournisseurs par défaut (recommandé)</h2>
                <div class="box_contenu">
                    <!-- Description de l'étape -->
                    <p>
                        En cliquant sur le bouton ci-dessous, vous allez ajouter les fournisseurs par défaut.
                        <br>
                        Ces fournisseurs sont recommandés pour une utilisation optimale de l'application.
                    </p>

                    <hr class="delimitation_trait">

                    <!-- Bouton pour installer les fournisseurs par défaut -->
                    <div class="form-action">
                        <button type="submit" class="bouton" disabled>Ajouter les fournisseurs par défaut</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- FIN * ÉTAPE 6 - (Optionnel) Ajouter les fournisseurs par défaut (recommandé) -->
    </div>

    <!-- DÉBUT * TERMINER L'INSTALLATION -->
    <form id="finish_install">
        <div class="wrapper main_axe_space_around">
            <button type="submit" class="bouton" disabled>Terminez l'installation</button>
        </div>
    </form>
    <!-- FIN * TERMINER L'INSTALLATION -->
</div>