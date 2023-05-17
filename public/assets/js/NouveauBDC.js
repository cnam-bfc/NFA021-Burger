// Sélectionner tous les éléments <select> ayant l'ID 'produit'
var selectElements = document.querySelectorAll("#produit");

var selectElement = document.getElementById("fournisseur");
var idFournisseur = 1;

// Ajout de l'event listener pour l'événement "change"
selectElement.addEventListener("change", function () {
    // Code à exécuter lorsque l'événement "change" se produit
    idFournisseur = selectElement.value;

    recupererProduits(true);

    // Sélectionner tous les éléments <select> ayant l'ID 'produit'
    var selectElements = document.querySelectorAll("#produit");

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectElements.forEach(function (selectElement) {
        console.log(1);
        var td1 = selectElement.parentNode;
        var td3 = td1.nextElementSibling.nextElementSibling;
        var prix = td3.querySelector("input");
        prix.value = selectElement.value;
    });
});


//****************************************************************************************************************/
//****************************************************************************************************************/


var selectQuantite = document.querySelectorAll("#quantite");


//****************************************************************************************************************/
//****************************************************************************************************************/


// Calcul du prix au lancement de la page
const inputsPrix = document.querySelectorAll('#prix');

// Calcul de la somme des prix
let total = 0;
inputsPrix.forEach(input => {
    total += parseFloat(input.value);
});

// Affichage du résultat dans la div d'id 'montant'
const montantDiv = document.getElementById('montant');
montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';


//****************************************************************************************************************/
//****************************************************************************************************************/


function majProduits(data) {
    // Récupérer les balises <select> avec name = 'produit'
    var selectElements = document.querySelectorAll("select[name='produit']");

    // Modifier les options des balises <select>
    selectElements.forEach(function (selectElement) {
        // Ajouter des options à chaque balise <select>

        selectElement.innerHTML = "";

        var id = [];
        var nom = [];
        var prix = [];

        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            if (item.idFournisseur == idFournisseur) {
                id.push(item.id);
                nom.push(item.nom);
                prix.push(item.prix);
            }
        }

        for (var i = 0; i < nom.length; i++) {

            selectElement.innerHTML += '<option value="' + prix[i] + '">' + nom[i] + '</option>';
        }
    });

    // sélectionner tous les éléments <select> ayant l'id 'produit'
    var selectElements = document.querySelectorAll("#produit");

    // // Ajouter un écouteur d'événement à chaque élément <select>
    selectElements.forEach(function (selectElement) {
        console.log(1);
        var td1 = selectElement.parentNode;
        var td3 = td1.nextElementSibling.nextElementSibling;
        var prix = td3.querySelector("input");
        prix.value = selectElement.value;
    });

    selectQuantite = document.querySelectorAll("#quantite");

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectQuantite.forEach(function (selectElement) {

        //Màj du prix après le retrait
        const inputsPrix = document.querySelectorAll('#prix');

        // Calcul de la somme des prix
        let total = 0;
        inputsPrix.forEach(input => {
            var qte = input.parentNode.previousElementSibling.querySelector('input').value;
            total += parseFloat(input.value) * qte;
        });

        // Affichage du résultat dans la div d'id 'montant'
        const montantDiv = document.getElementById('montant');
        montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
    });

    selectQuantite = document.querySelectorAll("#quantite");
}


//****************************************************************************************************************/
//****************************************************************************************************************/


function ajouterLigne(data) {

    var id = [];
    var nom = [];
    var pu = [];

    for (var i = 0; i < data.length; i++) {
        var item = data[i];
        if (item.idFournisseur == idFournisseur) {
            id.push(item.id);
            nom.push(item.nom);
            pu.push(item.prix);
        }
    }

    var table = document.getElementById("tableau");
    var ligne = table.insertRow(-1);
    var produit = ligne.insertCell(0);
    var quantite = ligne.insertCell(1);
    var prix = ligne.insertCell(2);
    var suppression = ligne.insertCell(3);

    var selectHtml = '<select id="produit" name="produit" class="courbe">';
    for (var i = 0; i < nom.length; i++) {
        selectHtml += '<option value="' + pu[i] + '">' + nom[i] + '</option>';
    }

    selectHtml += '</select>';
    produit.innerHTML = selectHtml;

    var selectElement = document.getElementById('produit');

    // Obtenez la valeur par défaut
    var pu2 = selectElement.value;

    quantite.innerHTML = '<input type="number" name="quantite" id="quantite" class="courbe" value=1>';
    prix.innerHTML = '<input type="number" name="prix" id="prix" disabled value ="' + pu2 + '" class="courbe">';
    suppression.innerHTML = '<button onclick="retirerLigne(this)" class="courbe">X</button>';

    //Màj du prix après le retrait
    const inputsPrix = document.querySelectorAll('#prix');

    // Calcul de la somme des prix
    let total = 0;
    inputsPrix.forEach(input => {
        total += parseFloat(input.value);
    });

    // Affichage du résultat dans la div d'id 'montant'
    const montantDiv = document.getElementById('montant');
    montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';

    // Sélectionner tous les éléments <select> ayant l'ID 'produit'
    var selectElements = document.querySelectorAll("#produit");

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectElements.forEach(function (selectElement) {
        selectElement.addEventListener("change", function () {
            console.log(1);
            var td1 = selectElement.parentNode;
            var td3 = td1.nextElementSibling.nextElementSibling;
            var prix = td3.querySelector("input");
            prix.value = selectElement.value;

            //Màj du prix après le retrait
            const inputsPrix = document.querySelectorAll('#prix');

            // Calcul de la somme des prix
            let total = 0;
            inputsPrix.forEach(input => {
                total += parseFloat(input.value);
            });

            // Affichage du résultat dans la div d'id 'montant'
            const montantDiv = document.getElementById('montant');
            montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
        });
    });

    selectQuantite = document.querySelectorAll("#quantite");

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectQuantite.forEach(function (selectElement) {
        selectElement.addEventListener("input", function () {
            console.log(25);

            //Màj du prix après le retrait
            const inputsPrix = document.querySelectorAll('#prix');

            let total = 0;
            inputsPrix.forEach(input => {
                var qte = input.parentNode.previousElementSibling.querySelector('input').value;
                total += parseFloat(input.value) * qte;
            });

            // Affichage du résultat dans la div d'id 'montant'
            const montantDiv = document.getElementById('montant');
            montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
        });
    });



    // Ajouter un écouteur d'événement à chaque élément <select>
    selectQuantite.forEach(function () {

        //Màj du prix après le retrait
        const inputsPrix = document.querySelectorAll('#prix');

        // Calcul de la somme des prix
        let total = 0;
        inputsPrix.forEach(input => {
            var qte = input.parentNode.previousElementSibling.querySelector('input').value;
            total += parseFloat(input.value) * qte;
        });

        // Affichage du résultat dans la div d'id 'montant'
        const montantDiv = document.getElementById('montant');
        montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
    });


}


//****************************************************************************************************************/
//****************************************************************************************************************/


function retirerLigne(btn) {
    var ligne = btn.parentNode.parentNode;
    ligne.parentNode.removeChild(ligne);

    selectQuantite = document.querySelectorAll("#quantite");

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectQuantite.forEach(function (selectElement) {

        //Màj du prix après le retrait
        const inputsPrix = document.querySelectorAll('#prix');

        // Calcul de la somme des prix
        let total = 0;
        inputsPrix.forEach(input => {
            var qte = input.parentNode.previousElementSibling.querySelector('input').value;
            total += parseFloat(input.value) * qte;
        });

        // Affichage du résultat dans la div d'id 'montant'
        const montantDiv = document.getElementById('montant');
        montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
    });



    // Sélectionner tous les éléments <select> ayant l'ID 'produit'
    var selectElements = document.querySelectorAll("#produit");

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectElements.forEach(function (selectElement) {
        console.log(1);
        var td1 = selectElement.parentNode;
        var td3 = td1.nextElementSibling.nextElementSibling;
        var prix = td3.querySelector("input");
        prix.value = selectElement.value;
    });

    selectQuantite = document.querySelectorAll("#quantite");

    if(selectQuantite.length == 0) {
        const montantDiv = document.getElementById('montant');
        montantDiv.textContent = 'Montant TTC : '+ 0 + '€';

    }
}


//****************************************************************************************************************/
//****************************************************************************************************************/


let recupererProduits = function (cas) {
    console.log("salut");
    //$("#bdc").empty();
    $.ajax({
        url: 'nouveaubdc/listeProduits',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log("salut 2");
            if (cas)
                majProduits(data);
            else
                ajouterLigne(data);
        },

        error: function (data) {
            // message dans la console
            console.log('Bdc.js - BDC - error');
        }
    })
}