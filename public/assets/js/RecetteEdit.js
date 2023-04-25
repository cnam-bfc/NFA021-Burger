$(function () {
    // Récupération des informations de la recette dans l'url
    const url = new URL(window.location.href);

    // Récupération des élements du DOM
    const bodyTableauComposition = $("#tableau_composition tbody");
    const ajouterIngredient = $("#ajouter_ingredient");

    // Fonction permettant d'ajouter une ligne contenant un ingredient dans le tableau de composition de la recette
    function addIngredient(data) {
        let ligne = $("<tr>");

        // Image
        let cellule = $("<td>");
        cellule.append($("<img>").attr("src", data.image));
        ligne.append(cellule);

        // Nom
        cellule = $("<td>");
        cellule.text(data.nom);
        ligne.append(cellule);

        // Quantité
        cellule = $("<td>");
        let celluleDiv = $("<div>");
        celluleDiv.addClass("wrapper main_axe_center second_axe_center");
        let inputQuantite = $("<input>").attr({
            type: "number",
            min: 0,
            max: 99,
            step: 1,
            value: data.quantite,
            required: true
        }).addClass("input");
        celluleDiv.append(inputQuantite);
        // Ajouter l'unité
        celluleDiv.append($("<span>").text(data.unite));
        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Optionnel
        cellule = $("<td>");
        celluleDiv = $("<div>");
        celluleDiv.addClass("wrapper main_axe_center second_axe_center");
        let inputOptionnel = $("<input>").attr({
            type: "checkbox",
            checked: data.optionnel
        }).addClass("input");
        celluleDiv.append(inputOptionnel);
        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Prix
        cellule = $("<td>");
        celluleDiv = $("<div>");
        celluleDiv.addClass("wrapper main_axe_center second_axe_center");
        let inputPrix = $("<input>").attr({
            type: "number",
            min: 0,
            max: 99.99,
            step: 0.01,
            value: data.prix,
            required: true
        }).addClass("input");
        celluleDiv.append(inputPrix);
        celluleDiv.append($("<span>").text("€"));
        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Désactiver le champ prix si l'ingrédient est obligatoire
        // A chaque changement de valeur du champ optionnel
        inputOptionnel.change(function () {
            if (inputOptionnel.prop("checked")) {
                inputPrix.prop("disabled", false);
                // Si le champ prix possède un attribut data, le stocker dans le champ
                if (inputPrix.attr("data-value") !== undefined) {
                    inputPrix.val(inputPrix.attr("data-value"));
                    inputPrix.removeAttr("data-value");
                }
            } else {
                inputPrix.prop("disabled", true);
                // Si le champ prix possède une valeur, la stocker un attribut data
                if (inputPrix.val() !== "") {
                    inputPrix.attr("data-value", inputPrix.val());
                    inputPrix.val("");
                }
            }
        });
        // Initialiser la valeur
        if (!data.optionnel) {
            inputPrix.prop("disabled", true);
        }

        // Boutons d'action rapide
        cellule = $("<td>");
        celluleDiv = $("<div>");
        celluleDiv.addClass("wrapper main_axe_center second_axe_center");

        // Bouton monter
        let boutonMonter = $("<button>").addClass("bouton");
        boutonMonter.click(function () {
            // Récupérer la ligne précédente
            let lignePrecedente = ligne.prev();
            // Si la ligne précédente existe
            if (lignePrecedente.length > 0) {
                // Déplacer la ligne actuelle avant la ligne précédente
                ligne.insertBefore(lignePrecedente);
            }
        });
        boutonMonter.append($("<i>").addClass("fa-solid fa-arrow-up"));
        celluleDiv.append(boutonMonter);

        // Bouton descendre
        let boutonDescendre = $("<button>").addClass("bouton");
        boutonDescendre.click(function () {
            // Récupérer la ligne suivante
            let ligneSuivante = ligne.next();
            // Si la ligne suivante existe
            if (ligneSuivante.length > 0) {
                // Déplacer la ligne actuelle après la ligne suivante
                ligne.insertAfter(ligneSuivante);
            }
        });
        boutonDescendre.append($("<i>").addClass("fa-solid fa-arrow-down"));
        celluleDiv.append(boutonDescendre);

        // Bouton supprimer
        let boutonSupprimer = $("<button>").addClass("bouton");
        boutonSupprimer.click(function () {
            // Supprimer la ligne
            ligne.remove();
        });
        boutonSupprimer.append($("<i>").addClass("fa-solid fa-trash"));
        celluleDiv.append(boutonSupprimer);

        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Ajout de la ligne au tableau
        bodyTableauComposition.append(ligne);
    }

    // Fonction permettant d'actualiser le tableau de composition de la recette
    function refreshIngredients() {
        // Récupération de l'id de la recette
        let idRecette = url.searchParams.get("id");

        // Supprimer le contenu du tableau
        bodyTableauComposition.empty();

        // Ajout ligne de chargement
        let ligne = $("<tr>");
        let cellule = $("<td>");
        cellule.attr("colspan", 6);
        cellule.html("<br><i class='fa-solid fa-spinner fa-spin'></i> Chargement des recettes<br><br>");
        ligne.append(cellule);
        bodyTableauComposition.append(ligne);

        // Récupérer les ingrédients de la recette
        $.ajax({
            url: "list/ingredients",
            method: "GET",
            data: {
                id: idRecette
            },
            dataType: "json",
            success: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauComposition.empty();

                // Si aucun ingrédient n'a été trouvée, afficher "Aucun résultats"
                if (data['data'].length == 0) {
                    let ligne = $("<tr>");
                    let cellule = $("<td>");
                    cellule.attr("colspan", 6);
                    cellule.html("<br>Aucun ingrédients<br><br>");
                    ligne.append(cellule);
                    bodyTableauComposition.append(ligne);
                }
                // Sinon, ajouter chaque ingrédient dans une nouvelle ligne
                else {
                    data['data'].forEach(element => {
                        addIngredient(element);
                    });
                }
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauComposition.empty();

                // Ajout ligne d'erreur
                let ligne = $("<tr>");
                let cellule = $("<td>");
                cellule.attr("colspan", 6);
                cellule.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement des ingrédients<br><br>");
                ligne.append(cellule);
                bodyTableauComposition.append(ligne);
            }
        });
    }

    // Si on est sur la page de modification d'une recette (pathname de l'url si termine par /recettes/modifier)
    if (url.pathname.endsWith("/recettes/modifier")) {
        // On actualise la composition de la recette
        refreshIngredients();
    }
});