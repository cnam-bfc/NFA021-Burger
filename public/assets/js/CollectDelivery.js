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
    document.querySelector('form').addEventListener('submit', function (event) {
        var selectedTime = document.getElementById('heureDelivery').value;
        var currentTime = new Date().toLocaleTimeString('fr-FR', { hour12: false, hour: '2-digit', minute: '2-digit' });
        if (selectedTime <= currentTime) {
            event.preventDefault();
            alert("Veuillez sélectionner une heure supérieure à l'heure actuelle.");
        }
    });

});
