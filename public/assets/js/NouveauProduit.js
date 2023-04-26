$(function () {


    document.getElementById('stockAuto').onchange = function () {
        document.getElementById('qteMin').disabled = !this.checked;
        document.getElementById('qteStandard').disabled = !this.checked;
    };


    //const urlSearchParams = new URLSearchParams(window.location.search);

    // Récupérez la valeur du paramètre "nom_produit"
    // if (urlSearchParams.get('nomProduit') != null) {
    //     nomProduit = urlSearchParams.get('nomProduit');

    //     // Obtenez la balise input
    //     const inputProduit = document.getElementById('nom');

    //     // Définissez la valeur de l'attribut "value" de la balise input avec la valeur du paramètre "nom_produit"
    //     inputProduit.setAttribute('value', nomProduit);
    // }
});
