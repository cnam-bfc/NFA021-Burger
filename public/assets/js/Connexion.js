$(function () {
    /*******************************
     ********** VARIABLES **********
     *******************************/

    // Récupération des élements du DOM
    const formConnexion = $("#form_connexion");
    const boutonRedirectionInscription = $("#bouton_redirection_inscription");
    const boutonConnexion = $("#bouton_connexion");

    /*****************************
     ********* FONCTIONS *********
     *****************************/

    // Lors de la soumission du formulaire
    function onFormConnexionSubmit(formDatas) {
        // Désactivation des champs du formulaire
        let disabledElements = [];
        formConnexion.find("input, select, textarea, button").each(function () {
            if (!$(this).prop("disabled")) {
                $(this).prop("disabled", true);
                disabledElements.push($(this));
            }
        });

        // Ajout icone et texte de chargement (fontawesome)
        let old_html = boutonConnexion.html();
        boutonConnexion.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');

        // Envoi des données au serveur
        $.ajax({
            url: "connexion/connexion",
            method: "POST",
            data: formDatas,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            dataType: "json",
            success: function (data) {
                // Si la connexion a réussi
                if (data.success) {
                    // Afficher un message de succès
                    boutonConnexion.html('<i class="fas fa-check"></i> Connecté !');
                    // On change la couleur du bouton
                    boutonConnexion.css('background-color', '#28a745');

                    // Redirection vers la page d'accueil appropriée
                    setTimeout(function () {
                        window.location.href = data.redirect;
                    }, 1000);
                }
                // Si la connexion a échoué
                else {
                    // Afficher un message d'erreur
                    boutonConnexion.html('<i class="fas fa-times"></i> Échec !');
                    // On change la couleur du bouton
                    boutonConnexion.css('background-color', '#dc3545');

                    setTimeout(function () {
                        // Afficher un message d'erreur
                        alert("Une erreur est survenue lors de la connexion !\nRaison : " + data.message);

                        // Réactivation des champs du formulaire
                        disabledElements.forEach(function (element) {
                            element.prop("disabled", false);
                        });

                        // Suppression icone et texte de chargement (fontawesome)
                        boutonConnexion.html(old_html);

                        // Suppression de la couleur du bouton
                        boutonConnexion.css('background-color', '');
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
                boutonConnexion.html(old_html);
            }
        });
    }

    /*****************************************
     *************** PRINCIPAL ***************
     *****************************************/

    // Lors de la soumission du formulaire
    formConnexion.submit(function (event) {
        // On empêche le formulaire de se soumettre
        event.preventDefault();

        // Récupération des champs du formulaire
        let formDatas = new FormData(this);

        onFormConnexionSubmit(formDatas);
    });

    // Lors du clic sur le bouton de redirection vers la page de connexion
    boutonRedirectionInscription.click(function () {
        window.location.href = "inscription";
    });
});