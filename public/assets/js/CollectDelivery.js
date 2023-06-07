$(function () {
    const bclick_collect = document.getElementById("bclick_collect");
    const bdelivery = document.getElementById("bdelivery");
    const click_collect = document.getElementById("clickCollect");
    const delivery = document.getElementById("delivery");



    bclick_collect.addEventListener("change", () => {
        if (bclick_collect.checked) {
            bdelivery.checked = false;
            delivery.style.display = "none";
            click_collect.style.display = "block";
        }
    });

    bdelivery.addEventListener("change", () => {
        if (bdelivery.checked) {
            bclick_collect.checked = false;

            click_collect.style.display = "none";
            delivery.style.display = "block";
        }
    });

    //Pour vérifier que l'heure entrée est supérieure à l'heure actuelle.
    console.log(new Date().toLocaleTimeString('fr-FR', { hour12: false, hour: '2-digit', minute: '2-digit' }));



});


function valider() {

    console.log("valider");

    if (bdelivery.checked == true) {
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
                "Heure": heureDelivery.value
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
        }

    } else if (bclick_collect.checked == true) {// Si le bouton "Cliquez & Collectez" est coché, enregistre le mode de récupération en session

        const HeureCollect = document.getElementById("heureCollect");
        const Prenom = document.getElementById("prenom");

        if (new RegExp(HeureCollect.pattern).test(HeureCollect.value) && new RegExp(Prenom.pattern).test(Prenom.value)) {


            const tabInfosRecup = {
                "Mode Récupération": 'Click & Collect',
                "Heure Collect": HeureCollect.value,
                "Prenom": Prenom.value

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
        }
    } else {
        // Si aucun bouton n'est coché, affiche un message d'erreur
        alert("Veuillez choisir une option.");
    }
}
