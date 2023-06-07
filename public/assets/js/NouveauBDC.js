// Variable qui contiendra toutes les balises ayant le nom 'produit'
var selectTousLesProduits = document.querySelectorAll('select[name="produit"]');

// Variable qui contiendra toutes les balises ayant le nom 'quantite'
var selectTouteslesQuantites = document.querySelectorAll('input[name="quantite"]');

// Variable qui contiendra toutes les balises ayant le nom 'prix'
var selectTouslesPrix = document.querySelectorAll('input[name="prix"]');

// Variable qui contiendra toutes les balises ayant le nom 'id'
var selectTouslesId = document.querySelectorAll('input[name="id"]');

// Variable qui contient la balise <select> des fournisseurs
var selectMenuDeroulantFournisseur = document.querySelector('select[name="fournisseur"]');

//idFournisseur au lancement de la page
var fournisseur = document.querySelector('select[name="fournisseur"]');
var idFournisseur = fournisseur.selectedOptions[0].value;

// Variable qui contiendra le prix total du bdc
var montantBdc;

//Calcul du prix au lancement de la page
calculerPrixTotalBdc();

// Ajout de l'event listener pour l'événement "change"
selectMenuDeroulantFournisseur.addEventListener("change", function () {
    // Code à exécuter lorsque l'événement "change" se produit
    idFournisseur = selectMenuDeroulantFournisseur.value;

    //Appel méthode pour récupérer la liste des produits du fournisseur sélectionné
    recupererProduits(true);
});


//****************************************************************************************************************/
//****************************************************************************************************************/


function recupererProduits(booleen) {
    afficherVisuelChargement();
    $.ajax({
        url: 'nouveaubdc/listeProduits',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (booleen)
                majProduits(data);
            else
                ajouterLigne(data);
            retirerVisuelChargement();
        },

        error: function (data) {
            console.log('Bdc.js - BDC - error');
        }
    });
}


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
        var uniteProduit = [];
        var prixUnitaireProduit = [];

        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            if (item.idFournisseur == idFournisseur) {
                idProduit.push(item.id);
                nomProduit.push(item.nom);
                uniteProduit.push(item.unite);
                prixUnitaireProduit.push(item.prix);
            }
        }

        for (var i = 0; i < nomProduit.length; i++) {
            selectElement.innerHTML += '<option name ="' + uniteProduit[i] + '" value="' + prixUnitaireProduit[i] + '" id = "' + idProduit[i] + '">' + nomProduit[i] + '</option>';
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
    var uniteProduit = [];
    var prixUnitaireProduit = [];

    for (var i = 0; i < data.length; i++) {
        var item = data[i];
        if (item.idFournisseur == idFournisseur) {
            idProduit.push(item.id);
            nomProduit.push(item.nom);
            uniteProduit.push(item.unite);
            prixUnitaireProduit.push(item.prix);
        }
    }

    var table = document.getElementById("tableau");
    var ligne = table.insertRow(-1);
    var produit = ligne.insertCell(0);
    var quantite = ligne.insertCell(1);
    var unite = ligne.insertCell(2);
    var prix = ligne.insertCell(3);
    var idLigne = ligne.insertCell(4);
    var suppression = ligne.insertCell(5);

    var idProduitParDefaut;
    var prixProduitParDefaut;
    var uniteProduitParDefaut;

    var selectHtml = '<select name="produit" class="courbe espace">';
    for (var i = 0; i < nomProduit.length; i++) {
        if (i == 0) {
            idProduitParDefaut = idProduit[i];
            prixProduitParDefaut = prixUnitaireProduit[i];
            uniteProduitParDefaut = uniteProduit[i];
        }
        selectHtml += '<option name ="' + uniteProduit[i] + '" value="' + prixUnitaireProduit[i] + '" id = "' + idProduit[i] + '">' + nomProduit[i] + '</option>';
    }

    selectHtml += '</select>';
    produit.innerHTML = selectHtml;

    quantite.innerHTML = '<input type="number" min="0"; name="quantite" class="courbe espace" value=1>';
    unite.innerHTML = '<input type="text" name="unite" disabled class="courbe espace" value="' + uniteProduitParDefaut + '">';
    prix.innerHTML = '<input type="number" name="prix" disabled value ="' + prixProduitParDefaut + '" class="courbe espace">';
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
            var td2 = td1.nextElementSibling.nextElementSibling;
            var unite = td2.querySelector("input");
            unite.value = selectElement.selectedOptions[0].getAttribute('name');;

            var td1 = selectElement.parentNode;
            var td3 = td1.nextElementSibling.nextElementSibling.nextElementSibling;
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

//Avant de valider le formulaire, on renomme tous les attributs "name" identiques des balises pour garantir leur transfert en POST

// Sélectionner l'élément <input> avec l'ID "submit"
var boutonSubmit = document.getElementById("submit");

// Ajouter un écouteur d'événements
boutonSubmit.addEventListener("click", function () {

    tableauId = [];

    selectTouslesId = document.querySelectorAll('input[name="id"]');
    selectTouslesId.forEach(function (selectElement) {
        tableauId.push(selectElement.value)
    });

    if (doublonExiste(tableauId)) {
        event.preventDefault();
        alert("Un même ingrédient ne peut apparaître que sur une ligne de votre bon de commande.")
    }

    else {

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

        alert("Votre commande a bien été validée.")
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

    // Ajouter le bon prix, unite et id à chaque ligne de produit lorsqu'on modifie l'option
    selectTousLesProduits.forEach(function (selectElement) {
        var td1 = selectElement.parentNode;
        var td2 = td1.nextElementSibling.nextElementSibling;
        var unite = td2.querySelector("input");
        unite.value = selectElement.selectedOptions[0].getAttribute('name');;

        var td1 = selectElement.parentNode;
        var td3 = td1.nextElementSibling.nextElementSibling.nextElementSibling;
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
        var qte = prix.parentNode.previousElementSibling.previousElementSibling.querySelector('input').value;
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
            var td2 = td1.nextElementSibling.nextElementSibling;
            var unite = td2.querySelector("input");
            unite.value = selectElement.selectedOptions[0].getAttribute('name');;

            var td1 = selectElement.parentNode;
            var td3 = td1.nextElementSibling.nextElementSibling.nextElementSibling;
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

function afficherVisuelChargement() {

    //On ajoute le visuel de chargement

    //On créé des éléments
    var sautLigne1 = document.createElement("br");
    var iconeChargement = document.createElement("i");
    iconeChargement.className = "fa-solid fa-spinner fa-spin";
    var texteChargement = document.createTextNode("Chargement des ingrédients");
    var sautLigne2 = document.createElement("br");

    //On créé la nouvelle div
    var nouvelleDiv = document.createElement("div");
    nouvelleDiv.id = "chargement";
    nouvelleDiv.className = "wrapper axe_colonne second_axe_center";

    //On ajoute les éléments à la nouvelle div
    nouvelleDiv.appendChild(sautLigne1);
    nouvelleDiv.appendChild(iconeChargement);
    nouvelleDiv.appendChild(texteChargement);
    nouvelleDiv.appendChild(sautLigne2);

    //on sélectionne une div existante
    var divExistante = document.getElementById("box");

    //On ajoute la nouvelle div à la div existante
    divExistante.appendChild(nouvelleDiv);

}


//****************************************************************************************************************/
//****************************************************************************************************************/


function retirerVisuelChargement() {

    //On retire le visuel de chargement
    $("#chargement").remove();
}


//****************************************************************************************************************/
//****************************************************************************************************************/


function doublonExiste(array) {
    var set = new Set(array);
    return set.size !== array.length;
}
