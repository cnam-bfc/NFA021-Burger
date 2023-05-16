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