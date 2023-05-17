// Récupération des éléments HTML pertinents
const wrapper = document.getElementById('wrapper_cuisine');
const boutonPrev = document.getElementById('boutonPrev');
const boutonNext = document.getElementById('boutonNext');
const boutonValide = document.getElementById('boutonValide');

// Ajout des écouteurs d'événement sur les boutons "Préc." et "Suiv."
boutonPrev.addEventListener('click', () => {
    const commandes = document.querySelectorAll('.commande');
    let focusIndex = -1;
    for (let i = 0; i < commandes.length; i++) {
        if (commandes[i].classList.contains('focus')) {
            focusIndex = i;
            break;
        }
    }

    if (focusIndex > 0) {
        commandes[focusIndex].classList.remove('focus');
        commandes[focusIndex - 1].classList.add('focus');
    }
});
$('.commande:visible:first')
// Fonction pour ajouter la classe "focus" à la div suivante
boutonNext.addEventListener('click', () => {
    const commandes = document.querySelectorAll('.commande');
    let focusIndex = -1;
    for (let i = 0; i < commandes.length; i++) {
        if (commandes[i].classList.contains('focus')) {
            focusIndex = i;
            break;
        }
    }
    if (focusIndex < commandes.length - 1) {
        commandes[focusIndex].classList.remove('focus');
        commandes[focusIndex + 1].classList.add('focus');
    }
});

boutonValide.addEventListener('click', function () {
    // Récupère la commande actuellement en focus
    const commandeFocus = document.querySelector('.commande.focus');
    // Si une commande est en focus, la désactive et passe le focus à la commande suivante
    if (commandeFocus) {
        commandeFocus.classList.remove('focus');
        /* const commandeSuivante = commandeFocus.nextElementSibling;
         if (commandeSuivante) {
             commandeSuivante.classList.add('focus');
         } else {
             // Si la commande focus est la seule, on lui remet la classe focus
             commandeFocus.classList.add('focus');
         }*/
    }
    // Fait disparaître la commande validée en lui rajoutant la classe "hidding"
    commandeFocus.style.display = 'none';
    // Décale les commandes suivantes
    const commandes = document.querySelectorAll('.commande');
    for (let i = 0; i < commandes.length; i++) {
        const computedStyle = window.getComputedStyle(commandes[i]);
        if (computedStyle.display !== 'none') {
            commandes[i].classList.add('focus');
            break;
        }
    }
});

// Ajoute un événement à la pression de la touche "Enter" pour le bouton valider
document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        boutonValide.click();
    }
});

$(function () {
    // Récupération des élements du DOM
    const divPrincipale = $("div#wrapper_cuisine");
    const boutonValide = $("button#boutonValide");

    // Fonction permettant d'ajouter une div contenant une commande dans le tableau des recettes
    function addCommande(data) {
        // Création de la div contenant la commande
        let divCommande = $("<div>").addClass("commande focus");
        divCommande.attr("id", data.id);

        //Numéro de la commande
        let divNumCom = $("<div>").addClass("num_com");
        let pNumCom = $("<p>").text(data.id);
        divNumCom.append(pNumCom);
        divCommande.append(divNumCom);

        //Recettes
        let divContenu = $("<div>").addClass("composition_com");

        data.recettes.forEach(element => {
            let pRecette = $("<p>");
            let recetteText = element.quantite + "x " + element.nom;
            pRecette.append(recetteText);
            divContenu.append(pRecette);
        });

        divCommande.append(divContenu);

        //Heure Livraison de la commande
        let divHeureCom = $("<div>").addClass("temps_com");
        divCommande.append(divHeureCom);
        divPrincipale.append(divCommande);
    }

    function refreshCommande() {
        $.ajax({
            url: "cuisinier/listeCommandes",
            method: "GET",
            dataType: "json",
            success: function (data) {
                // Supprimer la ligne de chargement
                divPrincipale.empty();


                // Si aucune recette n'a été trouvée, afficher "Aucun résultats"
                if (data['data'].length == 0) {
                    let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");
                    let h2 = $("<h2>").addClass("bold");
                    h2.text("Aucune commande n'a été trouvée");
                    div.append(h2);
                    divPrincipale.append(div);
                }
                // Sinon, ajouter chaque recette dans une nouvelle ligne
                else {
                    data['data'].forEach(element => {
                        addCommande(element);
                    });
                }
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                divPrincipale.empty();

                // Ajout ligne d'erreur
                let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");
                let h2 = $("<h2>").addClass("bold");
                h2.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement des recettes<br><br>");
                div.append(h2);
                divPrincipale.append(div);
            }
        });
    }
    refreshCommande();
});
