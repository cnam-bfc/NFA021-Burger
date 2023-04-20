$(function () {
    const bodyTableauRecettes = $("#tableau_recettes tbody");
    const ajouterRecette = $("#ajouter_recette");

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
        // Ingrédients basiques
        data.ingredientsBasique.forEach(element => {
            cellule.append($("<li>").text(element.quantite + element.unite + " " + element.nom));
        });
        // Ingrédients optionnels
        data.ingredientsOptionnel.forEach(element => {
            cellule.append($("<li>").text(element.quantite + element.unite + " " + element.nom + " (optionnel)"));
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

        bodyTableauRecettes.append(ligne);
    }

    function refreshRecettes() {
        bodyTableauRecettes.empty();

        // Ajout ligne de chargement
        let ligne = $("<tr>");
        let cellule = $("<td>");
        cellule.attr("colspan", 6);
        cellule.html("<br><i class='fa-solid fa-spinner fa-spin'></i> Chargement des recettes<br><br>");
        ligne.append(cellule);
        bodyTableauRecettes.append(ligne);

        $.ajax({
            url: "recettes/list",
            method: "GET",
            dataType: "json",
            success: function (data) {
                bodyTableauRecettes.empty();
                if (data['data'].length == 0) {
                    let ligne = $("<tr>");
                    let cellule = $("<td>");
                    cellule.attr("colspan", 6);
                    cellule.html("<br>Aucune recette n'a été trouvée<br><br>");
                    ligne.append(cellule);
                    bodyTableauRecettes.append(ligne);
                } else {
                    data['data'].forEach(element => {
                        addRecette(element);
                    });
                }
            },
            error: function (data) {
                bodyTableauRecettes.empty();
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