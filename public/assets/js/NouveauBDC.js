// Variable qui contiendra toutes les balises ayant le nom 'produit'
var selectTousLesProduits;

// Variable qui contiendra toutes les balises ayant le nom 'quantite'
var selectTouteslesQuantites;

// Variable qui contiendra toutes les balises ayant le nom 'prix'
var selectTouslesPrix;

// Variable qui contiendra toutes les balises ayant le nom 'id'
var selectTouslesId;

// Variable qui contiendra le prix total du bdc
var montantBdc;

// Variable qui contient la balise <select> des fournisseurs
var selectMenuDeroulantFournisseur = document.querySelector('select[name="fournisseur"]');

//idFournisseur au lancement de la page
var idFournisseur = 1;

// Ajout de l'event listener pour l'événement "change"
selectMenuDeroulantFournisseur.addEventListener("change", function () {
    // Code à exécuter lorsque l'événement "change" se produit
    idFournisseur = selectMenuDeroulantFournisseur.value;

    //Appel méthode pour récupérer la liste des produits du fournisseur sélectionné
    recupererProduits(true);
});

//Calcul du prix au lancement de la page
calculerPrixTotalBdc();


//****************************************************************************************************************/
//****************************************************************************************************************/


function majProduits(data) {
    // On sélectionne toutes les balises <select> ayant le nom 'produit'
    selectTousLesProduits = document.querySelectorAll('select[name="produit"]');

    // On modifie les options de chaque balise <select>
    selectTousLesProduits.forEach(function (selectElement) {
        // Ajouter des options à chaque balise <select>

        selectElement.innerHTML = "";

        var idProduit = [];
        var nomProduit = [];
        var prixUnitaireProduit = [];

        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            if (item.idFournisseur == idFournisseur) {
                idProduit.push(item.id);
                nomProduit.push(item.nom);
                prixUnitaireProduit.push(item.prix);
            }
        }

        for (var i = 0; i < nomProduit.length; i++) {

            selectElement.innerHTML += '<option value="' + prixUnitaireProduit[i] + '" id = "' + idProduit[i] + '">' + nomProduit[i] + '</option>';
        }
    });
    ajusterPrixEtIdChaqueProduit();

    //Màj du prix total
    calculerPrixTotalBdc();

}


//****************************************************************************************************************/
//****************************************************************************************************************/


function ajouterLigne(data) {

    var idProduit = [];
    var nomProduit = [];
    var prixUnitaireProduit = [];

    for (var i = 0; i < data.length; i++) {
        var item = data[i];
        if (item.idFournisseur == idFournisseur) {
            idProduit.push(item.id);
            nomProduit.push(item.nom);
            prixUnitaireProduit.push(item.prix);
        }
    }

    var table = document.getElementById("tableau");
    var ligne = table.insertRow(-1);
    var produit = ligne.insertCell(0);
    var quantite = ligne.insertCell(1);
    var prix = ligne.insertCell(2);
    var idLigne = ligne.insertCell(3);
    var suppression = ligne.insertCell(4);

    var idProduitParDefaut;
    var prixOptionParDefaut;

    var selectHtml = '<select name="produit" class="input">';
    for (var i = 0; i < nomProduit.length; i++) {
        if (i == 0) {
            idProduitParDefaut = idProduit[i];
            prixOptionParDefaut = prixUnitaireProduit[i];
        }
        selectHtml += '<option value="' + prixUnitaireProduit[i] + '" id = "' + idProduit[i] + '">' + nomProduit[i] + '</option>';
    }

    selectHtml += '</select>';
    produit.innerHTML = selectHtml;

    quantite.innerHTML = '<input type="number" name="quantite" class="input" value=1>';
    prix.innerHTML = '<input type="number" name="prix" disabled value ="' + prixOptionParDefaut + '" class="input">';
    idLigne.innerHTML = '<input type="hidden" name="id" value="' + idProduitParDefaut + '">';
    suppression.innerHTML = '<button onclick="retirerLigne(this)" class="courbe bouton">X</button>';

    //Màj du prix total
    calculerPrixTotalBdc();

    // Sélectionner tous les éléments <select> ayant l'ID 'produit'
    selectTousLesProduits = document.querySelectorAll('select[name="produit"]');

    // Ajouter un écouteur d'événement à chaque élément sélectionné
    selectTousLesProduits.forEach(function (selectElement) {
        selectElement.addEventListener("change", function () {
            var td1 = selectElement.parentNode;
            var td3 = td1.nextElementSibling.nextElementSibling;
            var prix = td3.querySelector("input");
            prix.value = selectElement.value;

            var td4 = td3.nextElementSibling;
            var id = td4.querySelector("input");
            id.value = selectElement.selectedOptions[0].id;

            //Màj du prix total
            calculerPrixTotalBdc();
        });
    });

    selectTouteslesQuantites = document.querySelectorAll('input[name="quantite"]');

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectTouteslesQuantites.forEach(function (selectElement) {
        selectElement.addEventListener("input", function () {

            //Màj du prix total
            calculerPrixTotalBdc();
        });
    });

    //Màj du prix total
    calculerPrixTotalBdc();

}


//****************************************************************************************************************/
//****************************************************************************************************************/


function retirerLigne(btn) {
    var ligne = btn.parentNode.parentNode;
    ligne.parentNode.removeChild(ligne);

    //Màj du prix total
    calculerPrixTotalBdc();

    selectTouteslesQuantites = document.querySelectorAll('input[name="quantite"]');

    if (selectTouteslesQuantites.length == 0) {
        montantBdc = document.getElementById('montant');
        montantBdc.textContent = 'Montant TTC : ' + 0 + '€';
    }
}


//****************************************************************************************************************/
//****************************************************************************************************************/

//Avant de valider le formulaire, on renomme tous les attributs "name" des balise html pour garantir leur transfert en POST

// Sélectionner l'élément <input> avec l'ID "submit"
var boutonSubmit = document.getElementById("submit");

// Ajouter un écouteur d'événements
boutonSubmit.addEventListener("click", function () {

    // Sélectionner tous les éléments <select> avec name="produit"
    selectTousLesProduits = document.querySelectorAll('select[name="produit"]');
    // Parcourir les éléments et modifier le nom
    for (var i = 0; i < selectTousLesProduits.length; i++) {
        selectTousLesProduits[i].name = "prix" + (i + 1);
    }

    selectTouteslesQuantites = document.querySelectorAll('input[name="quantite"]');
    // Parcourir les éléments et modifier le nom
    for (var i = 0; i < selectTouteslesQuantites.length; i++) {
        selectTouteslesQuantites[i].name = "quantite" + (i + 1);
    }

    selectTouslesId = document.querySelectorAll('input[name="id"]');
    // Parcourir les éléments et modifier le nom
    for (var i = 0; i < selectTouslesId.length; i++) {
        selectTouslesId[i].name = "id" + (i + 1);
    }
});


//****************************************************************************************************************/
//****************************************************************************************************************/


function genererPdf() {

    var divExport = document.querySelector('#boxBdc');

    var dimensionsDiv = divExport.getBoundingClientRect();
    var divWidth = dimensionsDiv.width;
    var divHeight = dimensionsDiv.height;

    //On capture le contenu HTML dans une image
    html2canvas(divExport).then(function (canvas) {
        var imgData = canvas.toDataURL('image/png');

        var pdf = new jsPDF();

        //On juste la taille de l'image
        var imageWidth = divWidth * 0.3;
        var imageHeight = divHeight * 0.3;

        //On centre l'image
        var pageWidth = pdf.internal.pageSize.getWidth();
        var pageHeight = pdf.internal.pageSize.getHeight();
        var xPos = (pageWidth - imageWidth) / 2;
        var yPos = (pageHeight - imageHeight) / 2;

        // Ajoute l'image capturée au document PDF en utilisant les coordonnées centrées
        pdf.addImage(imgData, 'PNG', xPos, yPos, imageWidth, imageHeight);

        // Enregistre le fichier PDF
        pdf.save('export' + new Date().toLocaleString() + '.pdf');
    });
}


//****************************************************************************************************************/
//****************************************************************************************************************/


function ajusterPrixEtIdChaqueProduit() {

    // Sélectionner toutes les balises <select> ayant le nom 'produit'
    selectTousLesProduits = document.querySelectorAll('select[name="produit"]');

    // Ajouter le bon prix à chaque ligne de produit
    selectTousLesProduits.forEach(function (selectElement) {
        var td1 = selectElement.parentNode;
        var td3 = td1.nextElementSibling.nextElementSibling;
        var prix = td3.querySelector("input");
        prix.value = selectElement.value;

        var td4 = td3.nextElementSibling;
        var id = td4.querySelector("input");
        id.value = selectElement.selectedOptions[0].id;
    });
}


//****************************************************************************************************************/
//****************************************************************************************************************/

function calculerPrixTotalBdc() {
    //Màj du prix
    selectTouslesPrix = document.querySelectorAll('input[name="prix"]');

    let total = 0;
    selectTouslesPrix.forEach(prix => {
        var qte = prix.parentNode.previousElementSibling.querySelector('input').value;
        total += parseFloat(prix.value) * qte;
    });

    // Affichage du résultat dans la div d'id 'montant'
    montantBdc = document.getElementById('montant');
    montantBdc.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
}


//****************************************************************************************************************/
//****************************************************************************************************************/


function placerEcouteursProduitsExistants() {

    // Sélectionner tous les éléments <select> ayant l'ID 'produit'
    selectTousLesProduits = document.querySelectorAll('select[name="produit"]');

    // Ajouter un écouteur d'événement à chaque élément sélectionné
    selectTousLesProduits.forEach(function (selectElement) {
        selectElement.addEventListener("change", function () {
            var td1 = selectElement.parentNode;
            var td3 = td1.nextElementSibling.nextElementSibling;
            var prix = td3.querySelector("input");
            prix.value = selectElement.value;

            var td4 = td3.nextElementSibling;
            var id = td4.querySelector("input");
            id.value = selectElement.selectedOptions[0].id;

            //Màj du prix total
            calculerPrixTotalBdc();
        });
    });

    selectTouteslesQuantites = document.querySelectorAll('input[name="quantite"]');

    // Ajouter un écouteur d'événement à chaque élément <select>
    selectTouteslesQuantites.forEach(function (selectElement) {
        selectElement.addEventListener("input", function () {

            //Màj du prix total
            calculerPrixTotalBdc();
        });

    });
}


//****************************************************************************************************************/
//****************************************************************************************************************/



function redirigerPageListeBdc() {

    window.location.href = `listebdc`;

}


//****************************************************************************************************************/
//****************************************************************************************************************/


function recupererProduits(booleen) {
    $.ajax({
        url: 'nouveaubdc/listeProduits',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (booleen)
                majProduits(data);
            else
                ajouterLigne(data);
        },

        error: function (data) {
            console.log('Bdc.js - BDC - error');
        }
    });
}