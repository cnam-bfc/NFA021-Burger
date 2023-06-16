$(function () {
    // Récupération des informations de l'itinéraire dans l'url
    const url = new URL(window.location.href);

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

    // Ajout du bouton de retour à la liste des livraisons
    L.easyButton('fa-arrow-left', function (btn, map) {
        window.location.href = "livraisons";
    }, "Retour à la liste des livraisons").addTo(map);

    // Ajout du choix de mode de transport
    let moyensTransport = [
        { label: "Voiture", value: "car" },
        { label: "Vélo", value: "bike" },
        { label: "Pied", value: "foot" }
    ];
    L.control.select({
        position: "topleft",
        iconMain: '<span class="fas fa-car"></span>',
        title: "Choisir un moyen de transport",
        selectedDefault: "bike",
        items: moyensTransport,
        onSelect: function (e) {
            console.log(e);
        }
    }).addTo(map);

    // Ajout du marqueur pour la position actuelle
    let currentLocationMarker = L.marker([0, 0]).addTo(map);

    // Fonction de mise à jour de la position du marqueur
    function updateCurrentLocation(position) {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
        currentLocationMarker.setLatLng([lat, lng]);
    }

    // Suivi de la position de l'utilisateur
    navigator.geolocation.watchPosition(updateCurrentLocation);

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