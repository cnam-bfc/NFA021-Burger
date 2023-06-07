$(document).ready(function () {
    afficherBDC();
});


//****************************************************************************************************************/
//****************************************************************************************************************/


//requête AJAX pour récupérer les bdc en bdd
function afficherBDC() {

    $("#bdc").empty();

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

    $.ajax({
        url: 'listebdc/donnees',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            creerElements(data);
        },

        error: function (data) {
            console.log('ListeBdc.js - error');
        }
    })
}


//****************************************************************************************************************/
//****************************************************************************************************************/


//Méthode pour afficher les bdc
function creerElements(data) {

    data.forEach(element => {

        if (element.validation === null) {
            //Création de la div conteneur
            let conteneur = document.createElement('div');
            conteneur.setAttribute('id', 'conteneur' + element.id);
            conteneur.setAttribute('class', 'conteneur padding_petit margin_bottom_top_moyen');
            let div = document.querySelector('#bdc');
            div.appendChild(conteneur);

            //Création de la div box_liste
            let boxListe = document.createElement('div');
            boxListe.setAttribute('id', 'bdc' + element.id);
            boxListe.setAttribute('class', 'box_liste ouvert');
            conteneur.appendChild(boxListe);

            let titreBdc = document.createElement('h2');
            titreBdc.setAttribute('id', 'numBdc' + element.id);
            titreBdc.setAttribute('class', 'bold');
            boxListe.appendChild(titreBdc);

            let nomFournisseur = document.createElement('p');
            nomFournisseur.setAttribute('id', 'nomFournisseur' + element.id);
            boxListe.appendChild(nomFournisseur);

            let montantHT = document.createElement('p');
            montantHT.setAttribute('id', 'montantHT' + element.id);
            boxListe.appendChild(montantHT);

            let btnValider = document.createElement('button');
            btnValider.setAttribute('class', 'btn_valider');
            btnValider.textContent = 'Valider';
            btnValider.value = element.id;
            boxListe.appendChild(btnValider);

            let btnDetails = document.createElement('button');
            btnDetails.setAttribute('class', 'btn_details');
            btnDetails.textContent = 'Détails';
            btnDetails.value = element.id;
            boxListe.appendChild(btnDetails);

            //On remplit les éléments avec les données reçues
            document.getElementById('numBdc' + element.id).textContent = "Bdc N°" + element.id;
            document.getElementById('nomFournisseur' + element.id).textContent = element.fournisseur;
            document.getElementById('montantHT' + element.id).textContent = "montant";
        }

        //On retire le visuel de chargement
        $("#chargement").remove();

    });

    //On récupère tous les boutons "détails"
    var boutonsDet = document.querySelectorAll('.btn_details');

    boutonsDet.forEach(bouton => {
        //On place un écouteur sur chaque bouton
        bouton.addEventListener('click', (event) => {
            const idBdc = bouton.value;
            window.location.href = `nouveaubdc?idBdc=${idBdc}`;
        });
    });


    //On récupère tous les boutons "valider"
    var boutonsVal = document.querySelectorAll('.btn_valider');

    boutonsVal.forEach(bouton => {
        //On place un écouteur sur chaque bouton
        bouton.addEventListener('click', (event) => {
            validerBDC(bouton.value);
        });
    });
}


//****************************************************************************************************************/
//****************************************************************************************************************/


function validerBDC($id) {
    let json = ({
        id: $id,
    });

    json = JSON.stringify(json);

    $.ajax({
        url: 'listebdc/valider',
        type: 'POST',
        dataType: 'json',
        data: {
            data: json
        },
        success: function (data) {
            $("#conteneur" + data.id).remove();
        },

        error: function (data) {
            console.log('ListeBdc.js - error');
        }
    })
}


//****************************************************************************************************************/
//****************************************************************************************************************/


function redirigerPageNouveauBdc() {
    window.location.href = `nouveaubdc`;
}