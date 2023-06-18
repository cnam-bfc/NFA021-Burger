$(function () {
    // Récupération des élements du DOM
    const divPrincipale = $("div#wrapper_carte");
    const titre_carte = $("<h1>").addClass("titre_bulle espace_titre margin_titre").text("Carte");

    // Fonction permettant d'ajouter un div contenant le burger dans la div principale
    function addBurger (data) {
        // Création de la div contenant le burger
        let div = $("<div>").addClass("wrapper box axe_colonne margin_large");
        div.attr("id", data.id);

        // Création de la balise de navigation
        let a = $("<a>")
            .addClass("wrapper axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow");
        a.attr("href", "visuModifsBurgers?id=" + data.id);

        // Création de la balise contenant l'image
        let img = $("<img>").attr("src", data.image);

        // Création de la balise contenant le nom
        let h2 = $("<h2>").addClass("bold").text(data.nom);

        // Création du bouton contenant la balise d'ajout au panier
        let boutonAjoutPanier = $("<button>").html("<i class='fa-solid fa-plus fa-l'></i>").addClass("boutonAjout");
        boutonAjoutPanier.click(function () {

            $.ajax({
                url: "carte/ajoutPanier",
                method: "POST",
                data: {
                    id : data.id,
                },
                dataType: "json",
                success: function (data) {
                        // Avertir l'utilisateur
                        alert("Le burger à été ajouté au panier");
                        location.reload();
                },
                error: function (data) {
                    // Avertir l'utilisateur
                    alert("Erreur de l'ajout du burger au panier");
                    location.reload();
                }
            });
        });

        // Ajout des balises dans la div
        a.append(img, h2);
        div.append(a, boutonAjoutPanier);
        divPrincipale.append(div);
    }

    // Fonction permettant de rafraichir la liste des recettes
    function refreshBurger() {

        let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");

        let h2 = $("<h2>").addClass("bold").html("<i class='fa-solid fa-spinner fa-spin'></i> Chargement des données");

        div.append(h2);
        divPrincipale.append(div);

        $.ajax({
            url: "carte/listeBurgers",
            method: "GET",
            dataType: "json",
            success: function (data) {
                // Supprimer la ligne de chargement
                divPrincipale.empty();


                // Si aucune recette n'a été trouvée, afficher "Aucun résultats"
                if (data['data'].length === 0) {
                    let div = $("<div>").addClass("boutonRecette wrapper box_sans_bordure margin_large");
                    let h2 = $("<h2>").addClass("bold");
                    h2.text("Aucune recette n'a été trouvée");
                    div.append(h2);
                    divPrincipale.append(titre_carte, div);
                }
                // Sinon, ajouter chaque recette dans une nouvelle ligne
                else {
                    divPrincipale.append(titre_carte);
                    data['data'].forEach(element => {
                        addBurger(element);
                    });
                }
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauRecettes.empty();

                // Ajout ligne d'erreur
                let div = $("<div>").addClass("wrapper box_sans_bordure margin_large");
                let h2 = $("<h2>").addClass("bold");
                h2.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement des recettes<br><br>");
                div.append(h2);
                divPrincipale.append(titre_carte, div);
            }
        });

    }
    refreshBurger();
});