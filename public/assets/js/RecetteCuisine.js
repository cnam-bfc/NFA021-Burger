$(function () {
    // Récupération des élements du DOM
    const divPrincipale = $("div#wrapper_cuisine");

    const boutonValide = $("button#boutonValide");


    // Fonction permettant d'ajouter une div contenant une commande dans le tableau des recettes
    function addBurger(data) {
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

        data.ingredients.forEach(element => {
            let boutonRecette = $("<button>");
            boutonRecette.attr("id", element.id);
            let recetteText = element.quantite + "x " + element.nom;
            boutonRecette.append(recetteText);
        });


        divCommande.append(divContenu);

        let champDateHeure = data.date_remise;
        let parties = champDateHeure.split(" ");
        let heure = parties[1];
        heure = heure.substring(0, heure.length - 3);
        //Heure Livraison de la commande
        let divHeureCom = $("<div>").addClass("temps_com");
        divHeureCom.text(heure);
        divCommande.append(divHeureCom);
        divPrincipale.append(divCommande);
    }

    function refreshBurger() {
        const url = new URL(window.location.href);

        let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");

        let h2 = $("<h2>").addClass("bold").html("<i class='fa-solid fa-spinner fa-spin'></i> Chargement des recettes...");

        div.append(h2);
        divPrincipale.append(div);

        let idRecette = url.searchParams.get("id");
        let idCommande = url.searchParams.get("idcc");
        let idRecetteFinale = url.searchParams.get("idrf");
        $.ajax({
            url: "recette/afficheBurger",
            method: "GET",
            data: {
                id: idRecette,
                idcc: idCommande,
                idrf: idRecetteFinale,
            },
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
                        addBurger(element);
                        const premiereCommande = document.querySelector('.commande');
                        if (premiereCommande) {
                            premiereCommande.classList.add('focus');
                        }
                    });

                }
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                divPrincipale.empty();

                // Ajout ligne d'erreur
                let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");
                let h2 = $("<h2>").addClass("bold");
                h2.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement du burger<br><br>");
                div.append(h2);
                divPrincipale.append(div);
            }
        });
    }

    refreshBurger();
});