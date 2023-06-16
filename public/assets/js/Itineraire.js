$(function () {
    // Récupération des informations de l'itinéraire dans l'url
    const url = new URL(window.location.href);

    let moyensTransport = [];
    let currentMoyenTransport = "";
    let currentLocationMarker;

    // Création de la carte
    let map = L.map('map', {
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: 'topleft'
        }
    }).setView([46.783, 4.8519], 13);

    // Ajout des tuiles OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Ajout du marqueur pour la position actuelle
    currentLocationMarker = L.marker([0, 0]).addTo(map);

    // Fonction de mise à jour de la position du marqueur
    function updateCurrentLocation(position) {
        console.log("Mise à jour de la position de l'utilisateur");

        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
        currentLocationMarker.setLatLng([lat, lng]);
    }

    // Suivi de la position de l'utilisateur
    navigator.geolocation.watchPosition(updateCurrentLocation);

    // Ajout du bouton de retour à la liste des livraisons
    L.easyButton('fa-arrow-left', function (btn, map) {
        window.location.href = "livraisons";
    }, "Retour à la liste des livraisons").addTo(map);

    // Ajout du choix de mode de transport
    console.log("Récupération des moyens de transport...");
    $.ajax({
        url: "itineraire/moyenstransport",
        method: "GET",
        dataType: "json",
        success: function (response) {
            console.log("Moyens de transport récupérés");

            // Sauvegarde des moyens de transport dans un tableau
            moyensTransport = response['data']['moyens_transport'];

            // Construction des items pour le select
            let selectMoyensTransportData = [];
            moyensTransport.forEach(function (moyenTransport) {
                selectMoyensTransportData.push({
                    label: moyenTransport['nom'],
                    value: moyenTransport['id']
                });
            });

            // Configuration du select
            let selectOptions = {
                position: "topleft",
                iconMain: '<span class="fas fa-car"></span>',
                title: "Choisir un moyen de transport",
                items: selectMoyensTransportData,
                onSelect: function (item) {
                    moyensTransport.forEach(function (moyenTransport) {
                        if (moyenTransport['id'] == item) {
                            console.log("Moyen de transport sélectionné : " + moyenTransport['nom']);

                            // Actualisation du moyen de transport sélectionné
                            currentMoyenTransport = moyenTransport['osrm_profile'];

                            // Sauvegarde du moyen de transport sélectionné
                            $.ajax({
                                url: "itineraire/moyentransport",
                                method: "POST",
                                data: {
                                    moyen_transport: moyenTransport['id']
                                },
                                dataType: "json",
                                success: function (response) {
                                    console.log("Moyen de transport sélectionné sauvegardé");
                                },
                                error: function (xhr, status, error) {
                                    console.log("Erreur lors de la sauvegarde du moyen de transport sélectionné : " + error);
                                }
                            });

                            // Recréation de la route
                            recreateItineraireView();
                        }
                    });
                }
            }

            if (response['data']['profil_actuel']) {
                // Récupération du moyen de transport sélectionné
                moyensTransport.forEach(function (moyenTransport) {
                    if (moyenTransport['id'] == response['data']['profil_actuel']) {
                        console.log("Moyen de transport sélectionné : " + moyenTransport['nom']);

                        // Actualisation du moyen de transport sélectionné
                        currentMoyenTransport = moyenTransport['osrm_profile'];

                        // Sélection du moyen de transport par défaut
                        selectOptions['selectedDefault'] = moyenTransport['id'];
                    }
                });
            }

            // Création du select
            L.control.select(selectOptions).addTo(map);
        },
        error: function (xhr, status, error) {
            console.log("Erreur lors de la récupération des moyens de transport : " + error);
        }
    });

    /**
     * Fonction permettant de recréer l'itinéraire
     */
    function recreateItineraireView() {
    }

    // Récupération des informations de l'itinéraire
    let osm_type = url.searchParams.get("osm_type");
    let osm_id = url.searchParams.get("osm_id");

    // Récupération de la position de la destination via l'API de nominatim
    $.ajax({
        url: "https://nominatim.openstreetmap.org/lookup?osm_ids=" + osm_type + osm_id + "&format=json&addressdetails=1",
        method: "GET",
        dataType: "json",
        success: function (response) {
            let lat = response[0].lat;
            let lon = response[0].lon;
            let display_name = response[0].display_name;

            // Ajout du marqueur pour la destination
            let destinationMarker = L.marker([lat, lon]).addTo(map);
            destinationMarker.bindPopup(display_name).openPopup();

            // Création du routeur (OSRM, vélo, français)
            let router = L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1',
                profile: 'cycling',
                language: 'fr'
            });

            // Ajout du chemin entre la position actuelle et la destination
            let routingControl = L.Routing.control({
                waypoints: [
                    currentLocationMarker.getLatLng(),
                    L.latLng(lat, lon)
                ],
                router: router,
                routeWhileDragging: false,
                draggableWaypoints: false,
                addWaypoints: false,
                show: true,
                autoRoute: false,
                createMarker: function () {
                    return null;
                }
            }).addTo(map);

            // Actualisation de la route en cas de changement de position
            setInterval(function () {
                // Récupération de la position de l'ancienne position de l'utilisateur
                let oldLocationLatLng = routingControl.getWaypoints()[0].latLng;

                // Récupération de la position actuelle de l'utilisateur
                let newLocationLatLng = currentLocationMarker.getLatLng();

                // Si la position a changé (plus de 10 mètres)
                if (oldLocationLatLng.distanceTo(newLocationLatLng) > 10) {
                    console.log("Votre position a changé, actualisation de l'itinéraire");

                    // Mise à jour de la position de l'utilisateur
                    routingControl.spliceWaypoints(0, 1, newLocationLatLng);
                    routingControl.route();
                }
            }, 2000);

            routingControl.route();
        }
    });
});