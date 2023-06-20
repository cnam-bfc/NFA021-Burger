$(function () {
    // Récupération des élements du DOM
    const divPrincipale = $("div#wrapper_burger");
    const titre = $("h1.titre_souligne");
    const boutonValide = $("button#boutonValide");


    // Fonction permettant d'ajouter une div contenant une commande dans le tableau des recettes
    function addBurger(data) {
        // Création de la div contenant la commande
        titre.text(data.idcc + " - " + data.nom + " x" + data.quantite);

        data.ingredients.forEach(element => {
            let divImage = $("<div>").addClass("wrapper axe_ligne main_axe_center image");
            let img = $("<img>").attr("src", element.image);
            divImage.append(img);
            divPrincipale.append(divImage);
            let divIngredients = $("<div>").addClass("ingredients");
            let pIngredients = $("<p>").text(element.quantite +""+element.unite+" "+element.nom);
            divIngredients.append(pIngredients);
            divPrincipale.append(divIngredients);
        });

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

                if (data['data'].length === 0) {
                    let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");
                    let h2 = $("<h2>").addClass("bold");
                    h2.text("Aucun burger n'a été trouvé");
                    div.append(h2);
                    divPrincipale.append(div);
                } else {

                    data['data'].forEach(element => {
                        addBurger(element);
                    });
                }

            },
            error: function (data) {
                // Supprimer la ligne de chargement
                divPrincipale.empty();

                // Ajout ligne d'erreur
                let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");
                let h2 = $("<h2>").addClass("bold");
                h2.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement de la visualisation du burger<br><br>");
                div.append(h2);
                divPrincipale.append(div);
            }
        });
    }

    refreshBurger();
});