//On commence par récupérer les données en bdd
afficherBDC();

// requête AJAX pour récupérer les commandes en bdd
function afficherBDC() {
    $("#bdc").empty();
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

function creerElements(data) {
    $i = 1;

    data.forEach(element => {

        if (element.validation === null) {
            // Créer la div conteneur
            let conteneur = document.createElement('div');
            conteneur.setAttribute('id', 'conteneur' + $i);
            conteneur.setAttribute('class', 'conteneur padding_petit margin_bottom_top_moyen');

            // Créer la div box_liste
            let boxListe = document.createElement('div');
            boxListe.setAttribute('id', 'bdc' + $i);
            boxListe.setAttribute('class', 'box_liste ouvert');

            let titreBdc = document.createElement('h2');
            titreBdc.setAttribute('id', 'numBdc' + $i);
            titreBdc.setAttribute('class', 'bold');
            boxListe.appendChild(titreBdc);

            let nomFournisseur = document.createElement('p');
            nomFournisseur.setAttribute('id', 'nomFournisseur' + $i);
            boxListe.appendChild(nomFournisseur);

            let montantHT = document.createElement('p');
            montantHT.setAttribute('id', 'montantHT' + $i);
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

            // Ajouter boxListe à conteneur
            conteneur.appendChild(boxListe);

            // Ajouter conteneur au document
            document.querySelector('.wrapper.axe_ligne.second_axe_center').appendChild(conteneur);

            // Remplir les éléments avec les données reçues
            document.getElementById('numBdc' + $i).textContent = "Bdc N°" + element.id;
            document.getElementById('nomFournisseur' + $i).textContent = element.fournisseur;
            document.getElementById('montantHT' + $i).textContent = "montant";
        }
        $i++;
    });

    //On récupère tous les boutons "détails"
    const boutonsDet = document.querySelectorAll('.btn_details');

    //On parcourt les boutons
    boutonsDet.forEach(bouton => {
        //On place un écouteur sur chaque bouton
        bouton.addEventListener('click', (event) => {
            const idBdc = bouton.value;
            window.location.href = `nouveaubdc?idBdc=${idBdc}`;
        });
    });


    //On récupère tous les boutons "valider"
    const boutonsVal = document.querySelectorAll('.btn_valider');

    //On parcourt les boutons
    boutonsVal.forEach(bouton => {
        //On place un écouteur sur chaque bouton
        bouton.addEventListener('click', (event) => {
            validerBDC(bouton.value);
        });
    });
}

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
            $("#bdc #conteneur" + data.id).remove();
        },

        error: function (data) {
            console.log('ListeBdc.js - error');
        }
    })
}

function redirigerPageNouveauBdc() {
    window.location.href = `nouveaubdc`;
}



