$(function () {
    // Forms
    let form_config_bdd = $('#config_bdd');
    let form_install_bdd = $('#install_bdd');
    let form_api_routexl = $('#api_routexl');
    let form_create_gerant = $('#create_gerant');
    let form_install_moyens_transport = $('#install_moyens_transport');
    let form_install_unites = $('#install_unites');
    let form_install_emballages = $('#install_emballages');
    let form_install_fournisseurs = $('#install_fournisseurs');
    let form_install_finish = $('#finish_install');

    // Fonction permettant de charger la partie de configuration de la base de données
    function loadConfigBdd() {
        // On récupère le titre de la box
        let title = form_config_bdd.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_config_bdd.find('input');
        // On récupère le bouton de soumission
        let submit = form_config_bdd.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie d'installation de la base de données
    function loadInstallBdd() {
        // On récupère le titre de la box
        let title = form_install_bdd.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_install_bdd.find('input');
        // On récupère le bouton de soumission
        let submit = form_install_bdd.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie de configuration de l'API RouteXL
    function loadAPIRouteXL() {
        // On récupère le titre de la box
        let title = form_api_routexl.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_api_routexl.find('input');
        // On récupère le bouton de soumission
        let submit = form_api_routexl.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie de création du compte gérant
    function loadCreateGerant() {
        // On récupère le titre de la box
        let title = form_create_gerant.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_create_gerant.find('input');
        // On récupère le bouton de soumission
        let submit = form_create_gerant.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie d'installation des moyens de transport
    function loadInstallMoyensTransport() {
        // On récupère le titre de la box
        let title = form_install_moyens_transport.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_install_moyens_transport.find('input');
        // On récupère le bouton de soumission
        let submit = form_install_moyens_transport.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie d'installation des unités
    function loadInstallUnites() {
        // On récupère le titre de la box
        let title = form_install_unites.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_install_unites.find('input');
        // On récupère le bouton de soumission
        let submit = form_install_unites.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie d'installation des emballages
    function loadInstallEmballages() {
        // On récupère le titre de la box
        let title = form_install_emballages.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_install_emballages.find('input');
        // On récupère le bouton de soumission
        let submit = form_install_emballages.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie d'installation des fournisseurs
    function loadInstallFournisseurs() {
        // On récupère le titre de la box
        let title = form_install_fournisseurs.find('h2[class="box_titre"]');
        // On récupère les champs input
        let inputs = form_install_fournisseurs.find('input');
        // On récupère le bouton de soumission
        let submit = form_install_fournisseurs.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le titre de la box (Ajout icone de chargement)
        let old_title = title.html();
        title.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_title);

        // On attend 1 seconde
        setTimeout(function () {
            // On remet le titre de la box à son état initial
            title.html(old_title);

            // On active les champs input et le bouton de soumission
            inputs.prop('disabled', false);
            submit.prop('disabled', false);
        }, 1000);
    }

    // Fonction permettant de charger la partie d'installation finale
    function loadInstallFinish() {
        // On récupère le bouton de soumission
        let submit = form_install_finish.find('button[type="submit"]');

        // On active le bouton de soumission
        submit.prop('disabled', false);
    }

    // Fonction permettant de sauvegarder la partie de configuration de la base de données
    function saveConfigBdd() {
        // On récupère les champs nécessaire
        let host_bdd = form_config_bdd.find('input[name="host_bdd"]');
        let port_bdd = form_config_bdd.find('input[name="port_bdd"]');
        let database_bdd = form_config_bdd.find('input[name="database_bdd"]');
        let user_bdd = form_config_bdd.find('input[name="user_bdd"]');
        let password_bdd = form_config_bdd.find('input[name="password_bdd"]');

        // On regroupe tous les champs dans un tableau
        let inputs = form_config_bdd.find('input');

        // On récupère le bouton de soumission
        let submit = form_config_bdd.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/config_bdd',
            type: 'POST',
            data: {
                host_bdd: host_bdd.val(),
                port_bdd: port_bdd.val(),
                database_bdd: database_bdd.val(),
                user_bdd: user_bdd.val(),
                password_bdd: password_bdd.val()
            },
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible de se connecter à la base de données !\nVeuillez vérifier les identifiants et le port de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si la connexion à la base de données est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Base de données connectée !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');

                    // On charge la partie d'installation de la base de données
                    loadInstallBdd();
                }
                // Si la connexion à la base de données à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active les champs input et le bouton de soumission
                    inputs.prop('disabled', false);
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie d'installation de création du compte gérant
    function saveInstallBdd() {
        // On récupère le bouton de soumission
        let submit = form_install_bdd.find('button[type="submit"]');

        // On désactive le bouton de soumission
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/install_bdd',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible d\'installer la base de données !\nVeuillez vérifier les permissions de l\'utilisateur de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation de la base de données est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Base de données installée !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');

                    // On charge la partie de configuration de l'API RouteXL
                    loadAPIRouteXL();
                }
                // Si l'installation de la base de données à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active le bouton de soumission
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie de configuration de l'API RouteXL
    function saveAPIRouteXL() {
        // On récupère les champs nécessaire
        let user_routexl = form_api_routexl.find('input[name="user_routexl"]');
        let password_routexl = form_api_routexl.find('input[name="password_routexl"]');

        // On regroupe tous les champs dans un tableau
        let inputs = form_api_routexl.find('input');

        // On récupère le bouton de soumission
        let submit = form_api_routexl.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/api_routexl',
            type: 'POST',
            data: {
                user_routexl: user_routexl.val(),
                password_routexl: password_routexl.val()
            },
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;

                    // On affiche le nombre de positions supportées par l'API RouteXL
                    alert(' --- INFORMATION --- \n\nConnexion à ' + data['api_id'] + ' réussie !\nNombre de positions maximales supportées : ' + data['api_max_locations']);
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible de se connecter à l\'API RouteXL !\nVeuillez vérifier les identifiants.\nCode erreur : ' + data['error_code'] + '\nMessage : ' + data['error_message']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si la connexion à l'API RouteXL est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> API RouteXL configurée !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');

                    // On charge la partie de création du compte gérant
                    loadCreateGerant();
                }
                // Si la connexion à l'API RouteXL à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active les champs input et le bouton de soumission
                    inputs.prop('disabled', false);
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie de création du compte gérant
    function saveCreateGerant() {
        // On récupère les champs nécessaire
        let nom_gerant = form_create_gerant.find('input[name="nom_gerant"]');
        let prenom_gerant = form_create_gerant.find('input[name="prenom_gerant"]');
        let email_gerant = form_create_gerant.find('input[name="email_gerant"]');
        let login_gerant = form_create_gerant.find('input[name="login_gerant"]');
        let password_gerant = form_create_gerant.find('input[name="password_gerant"]');
        let password_confirm_gerant = form_create_gerant.find('input[name="password_confirm_gerant"]');

        // On vériifie que les mots de passe correspondent
        if (password_gerant.val() !== password_confirm_gerant.val()) {
            // On affiche un message d'erreur
            alert('Les mots de passe ne correspondent pas !');

            return;
        }

        // On regroupe tous les champs dans un tableau
        let inputs = form_create_gerant.find('input');

        // On récupère le bouton de soumission
        let submit = form_create_gerant.find('button[type="submit"]');

        // On désactive les champs input et le bouton de soumission
        inputs.prop('disabled', true);
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/create_gerant',
            type: 'POST',
            data: {
                nom_gerant: nom_gerant.val(),
                prenom_gerant: prenom_gerant.val(),
                email_gerant: email_gerant.val(),
                login_gerant: login_gerant.val(),
                password_gerant: password_gerant.val()
            },
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible de créer le compte gérant !\nVeuillez vérifier les informations saisies.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si la création du compte gérant est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Compte gérant créé !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');

                    // On charge la partie d'installation des moyens de transport
                    loadInstallMoyensTransport();

                    // On charge la partie d'installation des unités
                    loadInstallUnites();

                    // On charge la partie d'installation des emballages
                    loadInstallEmballages();

                    // On charge la partie d'installation des fournisseurs
                    loadInstallFournisseurs();

                    // On charge la partie d'installation finale
                    loadInstallFinish();
                }
                // Si la création du compte gérant à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active les champs input et le bouton de soumission
                    inputs.prop('disabled', false);
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie d'installation des moyens de transport
    function saveInstallMoyensTransport() {
        // On récupère le bouton de soumission
        let submit = form_install_moyens_transport.find('button[type="submit"]');

        // On désactive le bouton de soumission
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/install_moyens_transport',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible d\'installer les moyens de transport !\nVeuillez vérifier les permissions de l\'utilisateur de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation des moyens de transport est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Moyens de transport installés !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');
                }
                // Si l'installation des moyens de transport à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active le bouton de soumission
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie d'installation des unités
    function saveInstallUnites() {
        // On récupère le bouton de soumission
        let submit = form_install_unites.find('button[type="submit"]');

        // On désactive le bouton de soumission
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/install_unites',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible d\'installer les unités !\nVeuillez vérifier les permissions de l\'utilisateur de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation des unités est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Unités installées !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');
                }
                // Si l'installation des unités à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active le bouton de soumission
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie d'installation des emballages
    function saveInstallEmballages() {
        // On récupère le bouton de soumission
        let submit = form_install_emballages.find('button[type="submit"]');

        // On désactive le bouton de soumission
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/install_emballages',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible d\'installer les emballages !\nVeuillez vérifier les permissions de l\'utilisateur de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation des emballages est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Emballages installés !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');
                }
                // Si l'installation des emballages à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active le bouton de soumission
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie d'installation des fournisseurs
    function saveInstallFournisseurs() {
        // On récupère le bouton de soumission
        let submit = form_install_fournisseurs.find('button[type="submit"]');

        // On désactive le bouton de soumission
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/install_fournisseurs',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible d\'installer les fournisseurs !\nVeuillez vérifier les permissions de l\'utilisateur de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation des fournisseurs est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Fournisseurs installés !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');
                }
                // Si l'installation des fournisseurs à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active le bouton de soumission
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Fonction permettant de sauvegarder la partie d'installation finale
    function saveInstallFinish() {
        // On récupère le bouton de soumission
        let submit = form_install_finish.find('button[type="submit"]');

        // On désactive le bouton de soumission
        submit.prop('disabled', true);

        // On change le bouton de soumission (Ajout icone de chargement)
        let old_submit = submit.html();
        submit.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + old_submit);

        let success = false;

        // On envoie les données au serveur
        $.ajax({
            url: 'install/finish',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible de terminer l\'installation !\nVeuillez vérifier les permissions d\'écriture dans le dossier "data".');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation finale est réussie
                if (success) {
                    // On remplace le bouton par un bouton de validation
                    submit.html('<i class="fa-solid fa-check"></i> Installation terminée !');
                    // On change la couleur du bouton
                    submit.css('background-color', '#28a745');

                    // On redirige vers la page de connexion
                    setTimeout(function () {
                        window.location.href = 'connexion';
                    }, 1000);
                }
                // Si l'installation finale à échouée
                else {
                    // On remet le bouton de soumission à son état initial
                    submit.html(old_submit);

                    // On active le bouton de soumission
                    submit.prop('disabled', false);
                }
            }
        });
    }

    // Initialisation des formulaires
    form_config_bdd.submit(function (e) {
        e.preventDefault();

        saveConfigBdd();
    });

    form_install_bdd.submit(function (e) {
        e.preventDefault();

        saveInstallBdd();
    });

    form_api_routexl.submit(function (e) {
        e.preventDefault();

        saveAPIRouteXL();
    });

    form_create_gerant.submit(function (e) {
        e.preventDefault();

        saveCreateGerant();
    });

    form_install_moyens_transport.submit(function (e) {
        e.preventDefault();

        saveInstallMoyensTransport();
    });

    form_install_unites.submit(function (e) {
        e.preventDefault();

        saveInstallUnites();
    });

    form_install_emballages.submit(function (e) {
        e.preventDefault();

        saveInstallEmballages();
    });

    form_install_fournisseurs.submit(function (e) {
        e.preventDefault();

        saveInstallFournisseurs();
    });

    form_install_finish.submit(function (e) {
        e.preventDefault();

        saveInstallFinish();
    });

    // On charge la partie configuration de la base de données
    loadConfigBdd();
});