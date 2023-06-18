let adresse_selectionnee = -1;
let adresse_code_postal = [];
let adresse_ville = [];
let adresse_voie = [];
let adresse_numero_voie = [];
let adresse_osm_id = [];
let adresse_osm_type = [];

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
    console.log('a');
    //////////////////////////////////////////////////////
    const element = document.getElementById("bclick_collect");
    const customCursor = document.getElementById("custom-cursor");

    //////1 CLICK

    // Création d'un nouvel événement de clic de souris
    const event = new MouseEvent("click", {
        bubbles: true,
        cancelable: true,
        view: window
    });

    // Déclenchement de l'événement de clic de souris sur l'élément
    element.dispatchEvent(event);

    let adresseInput = $("#adresse");
    let suggestions = $("#suggestions");

    // L'utilisateur tappe son adresse dans le champ "adresse", on affiche les suggestions de Nominatim
    adresseInput.on("keyup", function () {
        debounceSuggestions();
    });

    let timer;
    function debounceSuggestions() {
        clearTimeout(timer);
        timer = setTimeout(refreshSuggestions, 500);
    }

    function refreshSuggestions() {
        let adresse = adresseInput.val();

        adresse_selectionnee = -1;

        if (adresse.length > 7) {
            console.log("Actualisation des suggestions...");
            suggestions.empty();
            suggestions.append("<div class='suggestion'><i class='fas fa-spinner fa-spin'></i> Recherche en cours...</div>");

            $.ajax({
                url: "https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&countrycodes=fr&q=" + adresse,
                method: "GET",
                dataType: "JSON",
                success: function (response) {
                    suggestions.empty();

                    adresse_selectionnee = -1;
                    adresse_code_postal = [];
                    adresse_ville = [];
                    adresse_voie = [];
                    adresse_numero_voie = [];
                    adresse_osm_id = [];
                    adresse_osm_type = [];

                    // On garde seulement les suggestions dont osm_type est "way" ou "node" (pour éviter les suggestions de villes)
                    response = response.filter(function (suggestion) {
                        return suggestion.osm_type === "way" || suggestion.osm_type === "node";
                    });

                    // On retire les suggestions qui ne possèdent pas de rue
                    response = response.filter(function (suggestion) {
                        return suggestion.address.road !== undefined;
                    });

                    // Si au moins 1 suggestion est trouvée
                    if (response.length > 0) {
                        suggestions.append("<div class='suggestion'><i class='fas fa-map-marker-alt'></i> Sélectionnez votre adresse :</div>");
                    } else {
                        suggestions.append("<div class='suggestion'><i class='fas fa-exclamation-triangle'></i> Aucune adresse trouvée</div>");
                    }

                    // Formatage des suggestions
                    for (let i = 0; i < response.length; i++) {
                        let suggestion = response[i];
                        let code_postal = suggestion.address.postcode;
                        let ville = suggestion.address.city;
                        if (ville === undefined) {
                            ville = suggestion.address.town;
                            if (ville === undefined) {
                                ville = suggestion.address.village;
                                if (ville === undefined) {
                                    ville = suggestion.address.hamlet;
                                    if (ville === undefined) {
                                        ville = suggestion.address.city_district;
                                    }
                                }
                            }
                        }
                        let voie = suggestion.address.road;
                        if (voie === undefined) {
                            voie = suggestion.address.pedestrian;
                            if (voie === undefined) {
                                voie = suggestion.address.footway;
                                if (voie === undefined) {
                                    voie = suggestion.address.path;
                                    if (voie === undefined) {
                                        voie = suggestion.address.road;
                                    }
                                }
                            }
                        }
                        let numero_voie = suggestion.address.house_number;
                        if (numero_voie === undefined) {
                            numero_voie = suggestion.address.building;
                            if (numero_voie === undefined) {
                                numero_voie = suggestion.address.house;
                                if (numero_voie === undefined) {
                                    numero_voie = suggestion.address.housename;
                                }
                            }
                        }
                        let osm_id = suggestion.osm_id;
                        let osm_type = suggestion.osm_type;
                        if (osm_type === "way") {
                            osm_type = "W";
                        } else if (osm_type === "node") {
                            osm_type = "N";
                        }

                        let adresse
                        if (numero_voie !== undefined) {
                            adresse = numero_voie + " " + voie + ", " + code_postal + " " + ville;
                        } else {
                            adresse = voie + ", " + code_postal + " " + ville;
                        }

                        adresse_code_postal.push(code_postal);
                        adresse_ville.push(ville);
                        adresse_voie.push(voie);
                        adresse_numero_voie.push(numero_voie);
                        adresse_osm_id.push(osm_id);
                        adresse_osm_type.push(osm_type);

                        suggestions.append("<div class='suggestion' data-index='" + i + "'>" + adresse + "</div>");
                    }

                    console.log("Suggestions actualisées !");
                }
            });
        }
    }

    // L'utilisateur clique sur une suggestion, on enregistre l'adresse
    suggestions.on("click", ".suggestion", function () {
        const index = $(this).data("index");
        if (index === undefined) {
            return;
        }
        adresse_selectionnee = index;
        console.log("Adresse sélectionnée : " + $(this).text());
        adresseInput.val($(this).text());
        suggestions.empty();
    });
});


//Pour vérifier que l'heure entrée est supérieure à l'heure actuelle.
console.log(new Date().toLocaleTimeString('fr-FR', { hour12: false, hour: '2-digit', minute: '2-digit' }));


function valider() {

    console.log("valider");

    if (delivery.style.display !== "none") {
        // Si le bouton "Livraison" est coché, enregistre le mode de récupération en session

        const telephone = document.getElementById("telephone");
        const heureDelivery = document.getElementById("heureDelivery");
        if (adresse_selectionnee !== -1 && new RegExp(telephone.pattern).test(telephone.value) && new RegExp(heureDelivery.pattern).test(heureDelivery.value)) {
            // Crée un objet contenant les informations de récupération
            const tabInfosRecup = {
                "Mode Récupération": 'Livraison',
                "Code Postal": adresse_code_postal[adresse_selectionnee],
                "Ville": adresse_ville[adresse_selectionnee],
                "Voie": adresse_voie[adresse_selectionnee],
                "NumVoie": adresse_numero_voie[adresse_selectionnee],
                "OSM_ID": adresse_osm_id[adresse_selectionnee],
                "OSM_TYPE": adresse_osm_type[adresse_selectionnee],
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
