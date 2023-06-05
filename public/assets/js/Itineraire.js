$(function () {
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
});