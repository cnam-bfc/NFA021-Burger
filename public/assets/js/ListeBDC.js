$(document).ready(function () {

    let creerElements = function (data) {
        $i = 1;

        console.log(5);

        data.forEach(element => {

            if (element.etat == 0) {
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

        // Obtenez tous les éléments <td> avec l'id 'bouton'
        const boutonsDet = document.querySelectorAll('.btn_details');

        // Parcourez tous les éléments <td> avec l'id 'bouton'
        boutonsDet.forEach(bouton => {
            // Ajoutez un écouteur d'événements de clic à chaque bouton
            bouton.addEventListener('click', (event) => {

                const idBdc = bouton.value;
                window.location.href = `nouveaubdc?idBdc=${idBdc}`;
            });
        });


        // Obtenez tous les éléments <td> avec l'id 'bouton'
        const boutonsVal = document.querySelectorAll('.btn_valider');

        // Parcourez tous les éléments <td> avec l'id 'bouton'
        boutonsVal.forEach(bouton => {
            // Ajoutez un écouteur d'événements de clic à chaque bouton
            bouton.addEventListener('click', (event) => {

                validerBDC(bouton.value);
            });
        });
    }

    // requête AJAX pour récupérer les commandes en bdd
    let afficherBDC = function () {
        console.log("salut");
        $.ajax({
            url: 'listebdc/donnees',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                // message dans la console
                console.log('Bdc.js - BDC - success');
                creerElements(data);
            },

            error: function (data) {
                // message dans la console
                console.log('Bdc.js - BDC - error');
            }
        })
    }
    afficherBDC();

    let validerBDC = function ($id) {
        console.log("abc");
        let json = new Array();

        json.push({
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
                // message dans la console
                console.log("leciel est bleu");
                if (true) { //Modifier la condition pour être sur le succès
                    afficherBDC();
                }
            },

            error: function (data) {
                // message dans la console
                console.log('Inventaire.js - refreshTableauInventaire - error');
            }
        })

    }
});


