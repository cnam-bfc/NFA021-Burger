$(function () {
    let bdd_success = false;

    // Boutons
    let install = $('#install');
    let bdd_test = $('#test_bdd');

    // Champs
    let bdd_ip = $('#ip_bdd');
    let bdd_port = $('#port_bdd');
    let bdd_nom = $('#nom_bdd');
    let bdd_user = $('#user_bdd');
    let bdd_mdp = $('#mdp_bdd');

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
        if (bdd_ip.val() == '') {
            alert('Veuillez renseigner l\'adresse IP de la base de données');
            bdd_ip.focus();
            return false;
        } else if (bdd_port.val() == '') {
            alert('Veuillez renseigner le port de la base de données');
            bdd_port.focus();
            return false;
        } else if (isNaN(bdd_port.val())) {
            alert('Le port de la base de données doit être un nombre');
            bdd_port.focus();
            return false;
        } else if (bdd_nom.val() == '') {
            alert('Veuillez renseigner le nom de la base de données');
            bdd_nom.focus();
            return false;
        } else if (bdd_user.val() == '') {
            alert('Veuillez renseigner le nom d\'utilisateur de la base de données');
            bdd_user.focus();
            return false;
        } else if (bdd_mdp.val() == '') {
            alert('Veuillez renseigner le mot de passe de la base de données');
            bdd_mdp.focus();
            return false;
        }

        // Désactivation des champs
        bdd_ip.prop('disabled', true);
        bdd_port.prop('disabled', true);
        bdd_nom.prop('disabled', true);
        bdd_user.prop('disabled', true);
        bdd_mdp.prop('disabled', true);

        // Désactivation du bouton
        bdd_test.prop('disabled', true);

        // Ajout icone de chargement (fontawesome) au milieu du bouton (par dessus le texte)
        let old_html = bdd_test.html();
        bdd_test.html('<i class="fas fa-spinner fa-spin"></i> Connexion à la base de données...');

        // On envoie les données au serveur
        $.ajax({
            url: 'install/test_bdd',
            type: 'POST',
            dataType: 'json',
            data: {
                ip_bdd: bdd_ip.val(),
                port_bdd: bdd_port.val(),
                nom_bdd: bdd_nom.val(),
                user_bdd: bdd_user.val(),
                mdp_bdd: bdd_mdp.val()
            },
            success: function (data) {
                if (data['success']) {
                    // On affiche un message de succès
                    alert('Connexion à la base de données réussie !');

                    bdd_success = true;
                } else {
                    // On affiche un message d'erreur
                    alert('Connexion à la base de données échouée !');
                }
            },
            error: function (data) {
                // On affiche un message d'erreur
                alert('Connexion à la base de données échouée !');
            },
            complete: function () {
                // Si la connexion à la base de données a échoué
                if (!bdd_success) {
                    // On réactive les champs
                    bdd_ip.prop('disabled', false);
                    bdd_port.prop('disabled', false);
                    bdd_nom.prop('disabled', false);
                    bdd_user.prop('disabled', false);
                    bdd_mdp.prop('disabled', false);

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


    });
});