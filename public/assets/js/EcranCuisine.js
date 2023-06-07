// Récupération des éléments HTML pertinents
const wrapper = document.getElementById('wrapper_cuisine');
const boutonPrev = document.getElementById('boutonPrev');
const boutonNext = document.getElementById('boutonNext');
const boutonValide = document.getElementById('boutonValide');
const divCommande = document.querySelectorAll('.commande');
const boutonRecette = document.getElementById('boutonRecette');

/*boutonValide.addEventListener('click', function () {
    // Récupère la commande actuellement en focus

});*/


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
        let divCommande = $("<div>").addClass("commande");
        divCommande.attr("id", data.id);

        //Numéro de la commande
        let divNumCom = $("<div>").addClass("num_com");
        let pNumCom = $("<p>").text(data.id);

        divNumCom.append(pNumCom);
        divCommande.append(divNumCom);

        //Recettes
        let divContenu = $("<div>").addClass("composition_com");

        data.recettes.forEach(element => {
            let boutonRecette = $("<button>");
            boutonRecette.attr("id", element.id);
            let recetteText = element.quantite + "x " + element.nom;
            boutonRecette.append(recetteText);

            boutonRecette.click(function () {
                window.open("cuisinier/recette?id=" + element.id,'Recette','menubar=no, scrollbars=no, top=auto, left=auto, width=1000, height=700, position=absolute' );
            });

            divContenu.append(boutonRecette);
            element.ingredients.forEach(element => {
                if (element.quantite === 0) {
                    let pIngredients = $('<p>').addClass('ingredient').text("     sans " + element.nom);
                    boutonRecette.append(pIngredients);
                    divContenu.append(boutonRecette);
                }
            })
        });


        divCommande.append(divContenu);

        let champDateHeure = data.date_remise;
        let parties = champDateHeure.split(" ");
        let heure = parties[1];
        //Heure Livraison de la commande
        let divHeureCom = $("<div>").addClass("temps_com");
        divHeureCom.text(heure);
        divCommande.append(divHeureCom);
        divPrincipale.append(divCommande);
    }

    function addBoutons() {
        const divBoutons = $("div.bouton");

        //Création du bouton Précedent
        let boutonPrev = $("<button>").addClass('boutonsPrincipaux').text('Précédent');
        boutonPrev.attr("id", "boutonPrev");
        boutonPrev.click(function () {
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

        //Création du bouton Suivant
        let boutonNext = $("<button>").addClass('boutonsPrincipaux').text('Suivant');
        boutonNext.attr("id", "boutonNext");
        boutonNext.click(function () {
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

        //Création du bouton Validé
        let boutonValide = $("<button>").addClass('boutonsPrincipaux').text('Valider');
        boutonValide.attr("id", "boutonNext");
        boutonValide.click(function () {
            const commandes = document.querySelectorAll('.commande');
            const commandeFocus = document.querySelector('.commande.focus');
            const commandeSuivante = commandeFocus.nextElementSibling;
            // Si une commande est en focus, la désactive et passe le focus à la commande suivante
            if (commandeFocus) {
                let idCommandeClient = $('.commande.focus div.num_com p').text();
                console.log(idCommandeClient);

                $.ajax({
                    url: "cuisinier/supprimer",
                    method: "POST",
                    data: {
                        id: idCommandeClient
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success === false) {
                            // Avertir l'utilisateur
                            alert("Erreur lors de la suppression de la commande");
                        }
                    },
                    error: function (data) {
                        // Avertir l'utilisateur
                        alert("Erreur lors de la suppression de la commande");
                    }
                });
                commandeFocus.remove();

                if (commandeSuivante) {
                    commandeSuivante.classList.add('focus');
                } else {
                    // Si la commande focus est la seule, on lui remet la classe focus
                    commandeFocus.classList.add('focus');
                }

                if (commandes.length === 1) {
                    commandes[0].classList.add('focus');
                }

            }
        });

        divBoutons.append(boutonValide, boutonPrev, boutonNext);
    }


    function refreshCommande() {

        let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");

        let h2 = $("<h2>").addClass("bold").html("<i class='fa-spinner'></i> Chargement des recettes...");

        div.append(h2);
        divPrincipale.append(div);

        $.ajax({
            url: "cuisinier/listeCommandes",
            method: "GET",
            dataType: "json",
            success: function (data) {
                // Supprimer la ligne de chargement
                divPrincipale.empty();


                // Si aucune recette n'a été trouvée, afficher "Aucun résultats"
                if (data['data'].length === 0) {
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
                        const premiereCommande = document.querySelector('.commande');
                        if (premiereCommande) {
                            premiereCommande.classList.add('focus');
                        }
                    });
                    addBoutons();
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

    boutonValide.click(function () {

    });
});
