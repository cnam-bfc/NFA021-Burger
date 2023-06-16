$(function () {
    // Récupération des informations de l'itinéraire dans l'url
    const url = new URL(window.location.href);

    let moyensTransport = [];
    let currentMoyenTransport = "";
    let currentLocationMarker;
    let routingControl;
    let waypoints = [];
    let itineraire = [];

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

        if (routingControl) {
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
        }
    }

    // Suivi de la position de l'utilisateur
    navigator.geolocation.watchPosition(updateCurrentLocation);

    // Ajout du bouton de retour à la liste des livraisons
    let backButton = L.easyButton('fa-arrow-left', function (btn, map) {
        window.location.href = "livraisons";
    }, "Retour à la liste des livraisons").addTo(map);

    // Ajout du bouton de rafraichissement de l'itinéraire
    let refreshButton = L.easyButton('fa-sync-alt', function (btn, map) {
        refreshItineraire();
    }, "Rafraichir l'itinéraire").addTo(map);

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
                            refreshItineraire();
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
        let fontawesomeicon = refreshButton.button.children[0].children[0];
        fontawesomeicon.classList.remove("fa-spin");

        console.log("Re-création de l'itinéraire...");

        let routerOptions = {
            serviceUrl: 'https://router.project-osrm.org/route/v1',
            language: 'fr'
        };

        if (currentMoyenTransport) {
            routerOptions['profile'] = currentMoyenTransport;
        }

        // Création du routeur (OSRM, vélo, français)
        let router = L.Routing.osrmv1(routerOptions);

        let routeWaypoints = [];
        routeWaypoints.push(currentLocationMarker.getLatLng());
        waypoints.forEach(function (waypoint) {
            routeWaypoints.push(waypoint.getLatLng());
        });

        let routingOptions = {
            router: router,
            routeWhileDragging: false,
            draggableWaypoints: false,
            addWaypoints: false,
            show: true,
            autoRoute: false,
            createMarker: function () {
                return null;
            }
        };

        // Si il y a moins de 2 points, on ne peut pas créer d'itinéraire
        if (routeWaypoints.length < 2) {
            console.log("Il n'y a pas assez de points pour créer un itinéraire");
            return;
        }

        routingOptions['waypoints'] = routeWaypoints;

        if (routingControl) {
            // Suppression de l'ancien itinéraire
            map.removeControl(routingControl);
        }

        // Ajout du chemin entre la position actuelle et la destination
        routingControl = L.Routing.control(routingOptions).addTo(map);

        console.log("Itinéraire recréé");

        routingControl.on('routesfound', function (e) {
            console.log("Itinéraire recalculé");
        });

        routingControl.route();
    }

    /**
     * Fonction permettant de recréer l'itinéraire
     */
    function recreateItineraireData() {
        // Si on est en mode vision d'un point
        if (url.searchParams.has("osm_type") && url.searchParams.has("osm_id")) {
            // Récupération des informations de l'itinéraire
            let osm_type = url.searchParams.get("osm_type");
            let osm_id = url.searchParams.get("osm_id");

            // Récupération de la position de la destination via l'API de nominatim
            console.log("Récupération de la destination...");
            $.ajax({
                url: "https://nominatim.openstreetmap.org/lookup?osm_ids=" + osm_type + osm_id + "&format=json&addressdetails=1",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    let lat = response[0].lat;
                    let lon = response[0].lon;
                    let display_name = response[0].display_name;

                    console.log("Destination récupérée : " + display_name);

                    // Enlever tous les marqueurs
                    waypoints.forEach(function (waypoint) {
                        map.removeLayer(waypoint);
                    });
                    waypoints = [];

                    // Ajout du marqueur pour la destination
                    let destinationMarker = L.marker([lat, lon]).addTo(map);
                    destinationMarker.bindPopup(display_name).openPopup();

                    waypoints.push(destinationMarker);

                    recreateItineraireView();
                }
            });
        }
        // Sinon on charge les points de la livraison
        else {
            // Récupération de l'itinéraire
            console.log("Récupération de l'itinéraire...");

            $.ajax({
                url: "itineraire/afficher",
                method: "POST",
                data: {
                },
                dataType: "json",
                success: function (response) {
                    console.log("Itinéraire récupéré");

                    let locations = [];

                    itineraire = response['data']['itineraire'];

                    // Formatage des points de l'itinéraire
                    response['data']['itineraire'].forEach(function (point) {
                        locations.push(point['osm_type'] + point['osm_id']);
                    });

                    // Récupération des latitudes et longitudes des points de l'itinéraire via l'API de nominatim
                    console.log("Récupération des points de l'itinéraire...");
                    $.ajax({
                        url: "https://nominatim.openstreetmap.org/lookup?osm_ids=" + locations.join(",") + "&format=json&addressdetails=1",
                        method: "GET",
                        dataType: "json",
                        success: function (response) {
                            let log = "Points de l'itinéraire récupérés : ";
                            for (let i = 0; i < response.length; i++) {
                                log += "\n" + i + " - " + response[i].display_name;
                            }
                            console.log(log);

                            // Enlever tous les marqueurs
                            waypoints.forEach(function (waypoint) {
                                map.removeLayer(waypoint);
                            });
                            waypoints = [];

                            // Ajout des marqueurs pour les points de l'itinéraire
                            response.forEach(function (point) {
                                let waypointMarker = L.marker([point.lat, point.lon]).addTo(map);
                                waypointMarker.bindPopup(point.display_name);

                                waypoints.push(waypointMarker);
                            });

                            recreateItineraireView();
                        },
                        error: function (xhr, status, error) {
                            console.log("Erreur lors de la récupération des points de l'itinéraire : " + error);
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.log("Erreur lors de la récupération de l'itinéraire : " + error);
                }
            });
        }
    }

    function refreshItineraire() {
        let fontawesomeicon = refreshButton.button.children[0].children[0];

        if (fontawesomeicon.classList.contains("fa-spin")) {
            return;
        }

        console.log("Rafraichissement de l'itinéraire...");

        fontawesomeicon.classList.add("fa-spin");

        recreateItineraireData();
    }

    refreshItineraire();
});