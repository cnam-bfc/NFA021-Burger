$(function () {
    /*******************************
     ********** VARIABLES **********
     *******************************/

    // Récupération des élements du DOM
    const formInscription = $("#form_inscription");
    const boutonRedirectionConnexion = $("#bouton_redirection_connexion");
    const boutonInscription = $("#bouton_inscription");
    const inputPassword = $("#password");
    const inputPasswordConfirm = $("#password_confirm");

    /*****************************
     ********* FONCTIONS *********
     *****************************/

    // Lors de la soumission du formulaire
    function onFormInscriptionSubmit(formDatas) {
        // Si les mots de passe ne correspondent pas
        if (inputPassword.val() !== inputPasswordConfirm.val()) {
            // Afficher un message d'erreur
            alert("Les mots de passe ne correspondent pas !");
            return;
        }

        // Retrait de password_confirm des données du formulaire
        formDatas.delete("password_confirm");

        // Désactivation des champs du formulaire
        let disabledElements = [];
        formInscription.find("input, select, textarea, button").each(function () {
            if (!$(this).prop("disabled")) {
                $(this).prop("disabled", true);
                disabledElements.push($(this));
            }
        });

        // Ajout icone et texte de chargement (fontawesome)
        let old_html = boutonInscription.html();
        boutonInscription.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');

        // Envoi des données au serveur
        $.ajax({
            url: "inscription/inscription",
            method: "POST",
            data: formDatas,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            dataType: "json",
            success: function (data) {
                // Si l'inscription a réussi
                if (data.success) {
                    // Afficher un message de succès
                    boutonInscription.html('<i class="fas fa-check"></i> Connecté !');
                    // On change la couleur du bouton
                    boutonInscription.css('background-color', '#28a745');

                    // Redirection vers la page d'accueil appropriée
                    setTimeout(function () {
                        window.location.href = data.redirect;
                    }, 1000);
                }
                // Si l'inscription a échoué
                else {
                    // Afficher un message d'erreur
                    boutonInscription.html('<i class="fas fa-times"></i> Échec !');
                    // On change la couleur du bouton
                    boutonInscription.css('background-color', '#dc3545');

                    setTimeout(function () {
                        // Afficher un message d'erreur
                        alert("Une erreur est survenue lors de l'inscription !\nRaison : " + data.message);

                        // Réactivation des champs du formulaire
                        disabledElements.forEach(function (element) {
                            element.prop("disabled", false);
                        });

                        // Suppression icone et texte de chargement (fontawesome)
                        boutonInscription.html(old_html);

                        // Suppression de la couleur du bouton
                        boutonInscription.css('background-color', '');
                    }, 100);
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

                // Réactivation des champs du formulaire
                disabledElements.forEach(function (element) {
                    element.prop("disabled", false);
                });

                // Suppression icone et texte de chargement (fontawesome)
                boutonInscription.html(old_html);
            }
        });
    }

    /*****************************************
     *************** PRINCIPAL ***************
     *****************************************/

    // Lors de la soumission du formulaire
    formInscription.submit(function (event) {
        // On empêche le formulaire de se soumettre
        event.preventDefault();

        // Récupération des champs du formulaire
        let formDatas = new FormData(this);

        onFormInscriptionSubmit(formDatas);
    });

    // Lors du clic sur le bouton de redirection vers la page de connexion
    boutonRedirectionConnexion.click(function () {
        window.location.href = "connexion";
    });
});