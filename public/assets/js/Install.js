$(function () {
    let bdd_success = false;
    let install_success = false;

    // Boutons
    let install = $('#install');
    let bdd_test = $('#test_bdd');

    // Champs
    let bdd_host = $('#host_bdd');
    let bdd_port = $('#port_bdd');
    let bdd_database = $('#database_bdd');
    let bdd_user = $('#user_bdd');
    let bdd_password = $('#password_bdd');

    function refreshInstallButton() {
        if (bdd_success) {
            install.prop('disabled', false);
        } else {
            install.prop('disabled', true);
        }
    }

    // Lorsque bouton test_bdd est cliqué
    bdd_test.click(function () {
        // On récupère les champs nécessaire et vérifie leurs validités (vérification côté client)
        if (bdd_host.val() == '') {
            alert('Veuillez renseigner l\'adresse IP de la base de données');
            bdd_host.focus();
            return false;
        } else if (bdd_port.val() == '') {
            alert('Veuillez renseigner le port de la base de données');
            bdd_port.focus();
            return false;
        } else if (isNaN(bdd_port.val())) {
            alert('Le port de la base de données doit être un nombre');
            bdd_port.focus();
            return false;
        } else if (bdd_database.val() == '') {
            alert('Veuillez renseigner le nom de la base de données');
            bdd_database.focus();
            return false;
        } else if (bdd_user.val() == '') {
            alert('Veuillez renseigner le nom d\'utilisateur de la base de données');
            bdd_user.focus();
            return false;
        } else if (bdd_password.val() == '') {
            alert('Veuillez renseigner le mot de passe de la base de données');
            bdd_password.focus();
            return false;
        }

        // Désactivation des champs
        bdd_host.prop('disabled', true);
        bdd_port.prop('disabled', true);
        bdd_database.prop('disabled', true);
        bdd_user.prop('disabled', true);
        bdd_password.prop('disabled', true);

        // Désactivation du bouton
        bdd_test.prop('disabled', true);

        // Ajout icone de chargement (fontawesome)
        let old_html = bdd_test.html();
        bdd_test.html('<i class="fas fa-spinner fa-spin"></i> Connexion à la base de données...');

        // On envoie les données au serveur
        $.ajax({
            url: 'install/test_bdd',
            type: 'POST',
            dataType: 'json',
            data: {
                host_bdd: bdd_host.val(),
                port_bdd: bdd_port.val(),
                database_bdd: bdd_database.val(),
                user_bdd: bdd_user.val(),
                password_bdd: bdd_password.val()
            },
            success: function (data) {
                if (data['success']) {
                    bdd_success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Impossible de se connecter à la base de données !\nVeuillez vérifier les identifiants et le port de la base de données.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    alert('Erreur ' + jqXHR.status + ' : ' + errorThrown);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si la connexion à la base de données a échoué
                if (!bdd_success) {
                    // On réactive les champs
                    bdd_host.prop('disabled', false);
                    bdd_port.prop('disabled', false);
                    bdd_database.prop('disabled', false);
                    bdd_user.prop('disabled', false);
                    bdd_password.prop('disabled', false);

                    // On réactive le bouton
                    bdd_test.prop('disabled', false);

                    // On remet le bouton à son état initial
                    bdd_test.html(old_html);
                }
                // Sinon, on a réussi à se connecter à la base de données
                else {
                    // On remplace le bouton par un bouton de validation
                    bdd_test.html('<i class="fa-solid fa-check"></i> Base de données connectée !');
                    // On change la couleur du bouton
                    bdd_test.css('background-color', '#28a745');
                }

                // Refresh du bouton install
                refreshInstallButton();
            }
        });
    });

    // Lorsque le bouton install est cliqué
    install.click(function () {
        refreshInstallButton();

        if (install.prop('disabled')) {
            return false;
        }

        // Désactivation du bouton
        install.prop('disabled', true);

        // Ajout icone de chargement (fontawesome)
        let old_html = install.html();
        install.html('<i class="fa-solid fa-spinner fa-spin"></i> Installation...');

        // On envoie les données au serveur
        $.ajax({
            url: 'install/install',
            type: 'POST',
            dataType: 'json',
            data: {
                host_bdd: bdd_host.val(),
                port_bdd: bdd_port.val(),
                database_bdd: bdd_database.val(),
                user_bdd: bdd_user.val(),
                password_bdd: bdd_password.val()
            },
            success: function (data) {
                if (data['success']) {
                    install_success = true;

                    // On redirige vers la page d'accueil dans 1s
                    setTimeout(function () {
                        window.location.href = 'accueil';
                    }, 1000);
                } else {
                    // On affiche un message d'erreur
                    alert('Une erreur est survenue lors de l\'installation !\nVeuillez réessayer.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    alert('Erreur ' + jqXHR.status + ' : ' + errorThrown);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }
            },
            complete: function () {
                // Si l'installation a échoué
                if (!install_success) {
                    // On réactive le bouton
                    install.prop('disabled', false);

                    // On remet le bouton à son état initial
                    install.html(old_html);
                }
                // Sinon, l'installation a réussi
                else {
                    // On remplace le bouton par un bouton de validation
                    install.html('<i class="fa-solid fa-check"></i> Installation terminée !');
                    // On change la couleur du bouton
                    install.css('background-color', '#28a745');
                }
            }
        });
    });
});