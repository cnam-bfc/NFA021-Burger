$(function () {
    // Récupération des élements du DOM
    const bodyTableauRecettes = $("#tableau_recettes tbody");
    const ajouterRecette = $("#ajouter_recette");

    // Fonction permettant d'ajouter une ligne contenant une recette dans le tableau des recettes
    function addRecette(data) {
        let ligne = $("<tr>");

        // Image
        let cellule = $("<td>");
        cellule.append($("<img>").attr("src", data.image));
        ligne.append(cellule);

        // Nom
        cellule = $("<td>");
        cellule.text(data.nom);
        ligne.append(cellule);

        // Description
        cellule = $("<td>");
        cellule.addClass("description");
        cellule.text(data.description);
        ligne.append(cellule);

        // Ingrédients
        cellule = $("<td>");
        data.ingredients.forEach(element => {
            // CAS - Général
            if (element.ingredients === undefined) {
                let ingredientText = element.quantite + element.unite + " " + element.nom;
                // CAS - Particulier - Optionnel
                if (element.optionnel) {
                    ingredientText += " (optionnel)";
                }
                cellule.append($("<li>").text(ingredientText));
            }
            // CAS - Particulier - Sélection multiple
            else {
                let ingredientText = "Sélection multiple : " + element.quantite + " parmi";
                let ingredient = $("<li>").text(ingredientText);
                element.ingredients.forEach(element2 => {
                    let ingredientText = element2.quantite + element2.unite + " " + element2.nom;
                    ingredient.append($("<li>").text(ingredientText));
                });
                cellule.append(ingredient);
            }
        });
        ligne.append(cellule);

        // Prix
        cellule = $("<td>");
        cellule.html(data.prix + "&nbsp;€");
        ligne.append(cellule);

        // Boutons d'action rapide
        cellule = $("<td>");
        // Conteneur des boutons
        let contenuCellule = $("<div>");
        contenuCellule.addClass('wrapper main_axe_center second_axe_center');

        // Bouton modifier
        let boutonModifier = $("<button>").addClass("bouton");
        boutonModifier.click(function () {
            // Ouvrir la page de modification de recette
            window.location.href = "recettes/modifier?id=" + data.id;
        });
        boutonModifier.append($("<i>").addClass("fa-solid fa-pen-to-square"));
        contenuCellule.append(boutonModifier);

        // Bouton supprimer
        let boutonSupprimer = $("<button>").addClass("bouton");
        boutonSupprimer.click(function () {
            // Désactiver le bouton
            boutonSupprimer.prop("disabled", true);
            // Remplacer l'icône par un spinner
            boutonSupprimer.empty();
            boutonSupprimer.append($("<i>").addClass("fa-solid fa-spinner fa-spin"));

            // Envoyer une requête pour supprimer la recette
            $.ajax({
                url: "recettes/supprimer",
                method: "POST",
                data: {
                    id: data.id
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        // Supprimer la ligne
                        ligne.remove();
                    } else {
                        // Réactiver le bouton
                        boutonSupprimer.prop("disabled", false);
                        // Remplacer le spinner par l'icône
                        boutonSupprimer.empty();
                        boutonSupprimer.append($("<i>").addClass("fa-solid fa-trash"));
                        // Avertir l'utilisateur
                        alert("Erreur lors de la suppression de la recette");
                    }
                },
                error: function (data) {
                    // Réactiver le bouton
                    boutonSupprimer.prop("disabled", false);
                    // Remplacer le spinner par l'icône
                    boutonSupprimer.empty();
                    boutonSupprimer.append($("<i>").addClass("fa-solid fa-trash"));
                    // Avertir l'utilisateur
                    alert("Erreur lors de la suppression de la recette");
                }
            });
        });
        boutonSupprimer.append($("<i>").addClass("fa-solid fa-trash"));
        contenuCellule.append(boutonSupprimer);

        cellule.append(contenuCellule);
        ligne.append(cellule);

        // Ajout de la ligne au tableau
        bodyTableauRecettes.append(ligne);
    }

    // Fonction permettant d'actualiser le tableau des recettes
    function refreshRecettes() {
        // Supprimer le contenu du tableau
        bodyTableauRecettes.empty();

        // Ajout ligne de chargement
        let ligne = $("<tr>");
        let cellule = $("<td>");
        cellule.attr("colspan", 6);
        cellule.html("<br><i class='fa-solid fa-spinner fa-spin'></i> Chargement des recettes<br><br>");
        ligne.append(cellule);
        bodyTableauRecettes.append(ligne);

        // Récupération des recettes
        $.ajax({
            url: "recettes/list/recettes",
            method: "GET",
            dataType: "json",
            success: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauRecettes.empty();

                // Si aucune recette n'a été trouvée, afficher "Aucun résultats"
                if (data['data'].length == 0) {
                    let ligne = $("<tr>");
                    let cellule = $("<td>");
                    cellule.attr("colspan", 6);
                    cellule.html("<br>Aucune recette n'a été trouvée<br><br>");
                    ligne.append(cellule);
                    bodyTableauRecettes.append(ligne);
                }
                // Sinon, ajouter chaque recette dans une nouvelle ligne
                else {
                    data['data'].forEach(element => {
                        addRecette(element);
                    });
                }
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauRecettes.empty();

                // Ajout ligne d'erreur
                let ligne = $("<tr>");
                let cellule = $("<td>");
                cellule.attr("colspan", 6);
                cellule.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement des recettes<br><br>");
                ligne.append(cellule);
                bodyTableauRecettes.append(ligne);
            }
        });
    }

    // Lorsque l'on appuie sur le bouton d'ajout de recette
    ajouterRecette.click(function () {
        // Ouvrir la page de création de recette
        window.location.href = "recettes/ajouter";
    });

    // Rafraichir la liste des recettes
    refreshRecettes();
});