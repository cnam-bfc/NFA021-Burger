$(function () {
    // Récupération des informations de l'itinéraire dans l'url
    const url = new URL(window.location.href);

    let map = L.map('map').setView([46.783, 4.8519], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    L.easyButton('fa-arrow-left', function (btn, map) {
        window.location.href = "livraisons";
    }, "Retour à la liste des livraisons").addTo(map);

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

            // Ajout du chemin entre la position actuelle et la destination
            let route = L.Routing.control({
                waypoints: [
                    L.latLng(lat, lon),
                    currentLocationMarker.getLatLng()
                ],
                routeWhileDragging: true,
                show: true
            }).addTo(map);

            // Ajout du bouton pour centrer la carte sur l'itinéraire
            L.easyButton('fa-map-marker', function (btn, map) {
                map.fitBounds(route.getPlan().getWaypointsBounds());
            }, "Centrer la carte sur l'itinéraire").addTo(map);
        }
    });
});