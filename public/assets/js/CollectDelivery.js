$(document).ready(function () {
    const bclick_collect = $("#bclick_collect");
    const bdelivery = $("#bdelivery");
    const clickcollect = $("#clickCollect");
    const delivery = $("#delivery");



    bclick_collect.on("click", function () {
        delivery.hide();
        clickcollect.show();
        console.log($("#emballage").val());
    });

    bdelivery.on("click", function () {
        clickcollect.hide();
        delivery.show();
    });


    // bclick_collect.trigger("click");
    // console.log('a');
    //////////////////////////////////////////////////////
    const element = document.getElementById("bclick_collect");
    const customCursor = document.getElementById("custom-cursor");

    //////1 CLICK

    // // Création d'un nouvel événement de clic de souris
    // const event = new MouseEvent("click", {
    //     bubbles: true,
    //     cancelable: true,
    //     view: window
    // });

    // // Déclenchement de l'événement de clic de souris sur l'élément
    // element.dispatchEvent(event);

    // Simulation de clic
    function simulateClick(event) {
        // Obtenir les coordonnées du clic
        const rect = element.getBoundingClientRect();
        const x = rect.left + rect.width / 2;
        const y = rect.top + rect.height / 2;

        // Positionner l'élément du curseur personnalisé aux coordonnées du clic
        customCursor.style.left = x + "px";
        customCursor.style.top = y + "px";

        // Afficher l'élément du curseur personnalisé
        customCursor.style.display = "block";

        // Obtenir l'élément situé aux coordonnées du clic
        const targetElement = document.elementFromPoint(x, y);

        // Vérifier si l'élément est valide et déclencher un événement de clic sur celui-ci
        if (targetElement) {
            targetElement.click();
        }

        // Effectuer d'autres actions liées au clic simulé
        // ...
    }


    // Appel de la fonction simulateClick pour simuler le clic
    console.log("avant carton");

    /////////2CLICK
    simulateClick();
    /////////////

});


//Pour vérifier que l'heure entrée est supérieure à l'heure actuelle.
console.log(new Date().toLocaleTimeString('fr-FR', { hour12: false, hour: '2-digit', minute: '2-digit' }));





function valider() {

    console.log("valider");

    if (delivery.style.display !== "none") {
        // Si le bouton "Livraison" est coché, enregistre le mode de récupération en session

        const cp = document.getElementById("cp");
        const ville = document.getElementById("ville");
        const voie = document.getElementById("voie");
        const numeroVoie = document.getElementById("numeroVoie");
        const telephone = document.getElementById("telephone");
        const heureDelivery = document.getElementById("heureDelivery");
        if (new RegExp(cp.pattern).test(cp.value) && new RegExp(ville.pattern).test(ville.value)
            && new RegExp(voie.pattern).test(voie.value) && new RegExp(numeroVoie.pattern).test(numeroVoie.value)
            && new RegExp(telephone.pattern).test(telephone.value) && new RegExp(heureDelivery.pattern).test(heureDelivery.value)) {


            // Crée un objet contenant les informations de récupération
            const tabInfosRecup = {
                "Mode Récupération": 'Livraison',
                "Code Postal": cp.value,
                "Ville": ville.value,
                "Voie": voie.value,
                "NumVoie": numeroVoie.value,
                "Telephone": telephone.value,
                "Heure": heureDelivery.value,
                "Emballage": "isotherme"
            };

            // Enregistre les informations de récupération en session
            console.log(tabInfosRecup);

            $.ajax({
                url: "collectLivraison/valider",
                method: "POST",
                dataType: "JSON",
                data: { infos: tabInfosRecup },
                success: function (response) {
                    console.log("responseGOOD");
                    console.log(response);

                },
                error: function (xhr, status, error) {
                    console.log("Erreur lors de la requête AJAX : " + error);
                    console.log(xhr.responseText);
                    console.log('Objet JSON envoyé : ' + JSON.stringify(tabInfosRecup));
                }
            });
            console.log("a");
            window.location.href = 'recap';
        }

    } else if (delivery.style.display == "none") {// Si le bouton "Cliquez & Collectez" est coché, enregistre le mode de récupération en session

        const HeureCollect = document.getElementById("heureCollect");
        const Prenom = document.getElementById("prenom");
        const Emballage = document.getElementById("emballage");

        if (new RegExp(HeureCollect.pattern).test(HeureCollect.value) && new RegExp(Prenom.pattern).test(Prenom.value)) {
            console.log(Emballage.value);

            var optionSelectionnee = HeureCollect.selectedOptions[0]; // Première option sélectionnée (peut en contenir plusieurs avec l'attribut 'multiple')

            if (optionSelectionnee) {
                var texteOptionSelectionnee = optionSelectionnee.textContent;
                console.log("Option sélectionnée : " + texteOptionSelectionnee);
            } else {
                console.log("Aucune option sélectionnée");
            }

            const tabInfosRecup = {
                "Mode Récupération": 'Click & Collect',
                "Heure Collect": texteOptionSelectionnee,
                "Prenom": Prenom.value,
                "Emballage": Emballage.value
            };

            // Enregistre les informations de récupération en session
            console.log(tabInfosRecup);

            $.ajax({
                url: "collectLivraison/valider",
                method: "POST",
                dataType: "JSON",
                data: { infos: tabInfosRecup },
                success: function (response) {
                    console.log("responseGOOD");
                    console.log(response);

                },
                error: function (xhr, status, error) {
                    console.log("Erreur lors de la requête AJAX : " + error);
                    console.log(xhr.responseText);
                    console.log('Objet JSON envoyé : ' + JSON.stringify(tabInfosRecup));
                }
            });
            console.log("a");
            window.location.href = 'recap';
        }
    } else {
        // Si aucun bouton n'est coché, affiche un message d'erreur
        alert("Veuillez choisir une option.");
    }
}
