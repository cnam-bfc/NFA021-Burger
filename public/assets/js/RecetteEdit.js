$(function () {
    // Récupération des informations de la recette dans l'url
    const url = new URL(window.location.href);

    // Récupération des élements du DOM
    const formRecette = $("#form_recette");
    const enregistrerRecette = $("#enregistrer");
    const bodyTableauComposition = $("#tableau_composition tbody");
    const ajouterIngredient = $("#ajouter_ingredient");

    // Fonction permettant d'ajouter une ligne contenant un ingredient dans le tableau de composition de la recette
    function addIngredient(data) {
        let ligne = $("<tr>");
        ligne.attr("data-id", data.id);

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
            name: "quantite_ingredient",
            type: "number",
            min: 0,
            minlenght: 1,
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
            name: "optionnel_ingredient",
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
            name: "prix_ingredient",
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

    // Lors de la soumission du formulaire
    formRecette.submit(function (event) {
        // On empêche le formulaire de se soumettre
        event.preventDefault();

        let formDatas = new FormData(this);

        // Si on modifie la recette
        if (url.pathname.endsWith("/recettes/modifier")) {
            // Récupération de l'id de la recette
            let idRecette = url.searchParams.get("id");
            formDatas.append("id", idRecette);
        }

        // Récupération des informations générales de la recette
        // Nom
        formDatas.append("nom", formRecette.find("input[name='nom_recette']").val());

        // Description
        formDatas.append("description", formRecette.find("textarea[name='description_recette']").val());

        // Prix
        formDatas.append("prix", formRecette.find("input[name='prix_recette']").val());

        // Image de la recette
        let inputImage = formRecette.find("input[name='image_recette']");
        if (inputImage[0].files.length > 0) {
            formDatas.append("image", inputImage[0].files[0]);
        }

        // Récupération des ingrédients
        let ingredients = [];
        bodyTableauComposition.children().each(function () {
            let ingredient = {};
            ingredient.id = $(this).attr("data-id");
            ingredient.quantite = $(this).find("input[name='quantite_ingredient']").val();
            ingredient.optionnel = $(this).find("input[name='optionnel_ingredient']").prop("checked");
            if (ingredient.optionnel) {
                ingredient.prix = $(this).find("input[name='prix_ingredient']").val();
            }
            ingredients.push(ingredient);
        });
        formDatas.append("ingredients", JSON.stringify(ingredients));

        // Désactivation des champs du formulaire
        let disabledElements = [];
        formRecette.find("input, select, textarea, button").each(function () {
            if (!$(this).prop("disabled")) {
                $(this).prop("disabled", true);
                disabledElements.push($(this));
            }
        });

        // Ajout icone et texte de chargement (fontawesome)
        let old_html = enregistrerRecette.html();
        enregistrerRecette.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');

        // Envoi des données au serveur
        $.ajax({
            url: "enregistrer",
            method: "POST",
            data: formDatas,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            dataType: "json",
            success: function (data) {
                // Si la recette a été modifiée
                if (data.success) {
                    // Afficher un message de succès
                    enregistrerRecette.html('<i class="fas fa-check"></i> Enregistré !');
                    // On change la couleur du bouton
                    enregistrerRecette.css('background-color', '#28a745');

                    // Redirection vers la page de la recette
                    setTimeout(function () {
                        window.location.href = "modifier?id=" + data.id;
                    }, 1000);
                }
                // Si la recette n'a pas été modifiée
                else {
                    // Afficher un message d'erreur
                    alert("Une erreur est survenue lors de l'enregistrement de la recette");

                    // Réactivation des champs du formulaire
                    disabledElements.forEach(function (element) {
                        element.prop("disabled", false);
                    });

                    // Suppression icone et texte de chargement (fontawesome)
                    enregistrerRecette.html(old_html);
                }
            },
            error: function (data) {
                // Afficher un message d'erreur
                alert("Une erreur inconue est survenue");

                // Réactivation des champs du formulaire
                disabledElements.forEach(function (element) {
                    element.prop("disabled", false);
                });

                // Suppression icone et texte de chargement (fontawesome)
                enregistrerRecette.html(old_html);
            }
        });
    });
});