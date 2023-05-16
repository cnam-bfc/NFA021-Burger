$(function () {
    /*******************************
     ********** VARIABLES **********
     *******************************/

    // Récupération des informations de la recette dans l'url
    const url = new URL(window.location.href);

    // Récupération des élements du DOM
    const formRecette = $("#form_recette");
    const enregistrerRecette = $("#enregistrer");
    const bodyTableauComposition = $("#tableau_composition tbody");
    const boutonAjouterNewIngredient = $("#bouton_ajouter_new_ingredient");
    const ajouterIngredient = $("#ajouter_ingredient");
    const selectAjouterIngredient = $("#select_ajouter_ingredient");
    const boutonAnnulerAjouterIngredient = $("#bouton_annuler_ajouter_ingredient");

    let tableauCompositionEmpty = true;

    /*****************************
     ********* FONCTIONS *********
     *****************************/

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
            type: "number",
            min: 0,
            minlenght: 1,
            max: 999999,
            step: 1,
            value: data.quantite,
            required: true
        }).addClass("input quantite_ingredient");
        celluleDiv.append(inputQuantite);
        // Ajouter l'unité
        celluleDiv.append($("<span>").text(data.unite));
        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Choix multiple
        cellule = $("<td>");
        celluleDiv = $("<div>");
        celluleDiv.addClass("wrapper main_axe_center second_axe_center");
        let selectChoixMultiple = $("<select>").addClass("choix_multiple_ingredient");
        let optionNotMultiple = $("<option>").attr("value", "0").text("Non");
        selectChoixMultiple.append(optionNotMultiple);
        celluleDiv.append(selectChoixMultiple);
                // Ajout de la bibliothèque select2
                selectChoixMultiple.select2({
                    width: 'element',
                    placeholder: "Choix multiple",
                });
        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Optionnel
        cellule = $("<td>");
        celluleDiv = $("<div>");
        celluleDiv.addClass("wrapper main_axe_center second_axe_center");
        let inputOptionnel = $("<input>").attr({
            type: "checkbox",
            checked: data.optionnel
        }).addClass("input optionnel_ingredient");
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
        }).addClass("input prix_ingredient");
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
        let boutonMonter = $("<button>").attr("type", "button").addClass("bouton");
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
        let boutonDescendre = $("<button>").attr("type", "button").addClass("bouton");
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
        let boutonSupprimer = $("<button>").attr("type", "button").addClass("bouton");
        boutonSupprimer.click(function () {
            // Supprimer la ligne
            ligne.remove();

            // Si le tableau est vide
            if (bodyTableauComposition.children().length === 0) {
                // Ajouter la ligne vide
                tableauCompositionEmpty = true;
                let ligne = $("<tr>");
                let cellule = $("<td>");
                cellule.attr("colspan", 7);
                cellule.html("<br>Aucun ingrédients<br><br>");
                ligne.append(cellule);
                bodyTableauComposition.append(ligne);
            }
        });
        boutonSupprimer.append($("<i>").addClass("fa-solid fa-trash"));
        celluleDiv.append(boutonSupprimer);

        cellule.append(celluleDiv);
        ligne.append(cellule);

        // Supprimer la ligne vide si elle existe
        if (tableauCompositionEmpty) {
            bodyTableauComposition.empty();
            tableauCompositionEmpty = false;
        }

        // Ajout de la ligne au tableau
        bodyTableauComposition.append(ligne);
    }

    // Fonction permettant d'actualiser le tableau de composition de la recette
    function refreshIngredients() {
        // Désactiver l'ajout d'ingrédient
        boutonAjouterNewIngredient.prop("disabled", true);

        // Récupération de l'id de la recette
        let idRecette = url.searchParams.get("id");

        // Supprimer le contenu du tableau
        bodyTableauComposition.empty();

        // Ajout ligne de chargement
        let ligne = $("<tr>");
        let cellule = $("<td>");
        cellule.attr("colspan", 7);
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
                    tableauCompositionEmpty = true;
                    let ligne = $("<tr>");
                    let cellule = $("<td>");
                    cellule.attr("colspan", 7);
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

                // Activer l'ajout d'ingrédient
                boutonAjouterNewIngredient.prop("disabled", false);
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauComposition.empty();

                // Ajout ligne d'erreur
                let ligne = $("<tr>");
                let cellule = $("<td>");
                cellule.attr("colspan", 7);
                cellule.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement des ingrédients<br><br>");
                ligne.append(cellule);
                bodyTableauComposition.append(ligne);
            }
        });
    }

    // Lors de la soumission du formulaire
    function onFormRecetteSubmit(formDatas) {
        // Si on modifie la recette
        if (url.pathname.endsWith("/recettes/modifier")) {
            // Récupération de l'id de la recette
            let idRecette = url.searchParams.get("id");
            formDatas.append("id_recette", idRecette);
        }

        // Récupération des ingrédients
        let ingredients_recette = [];
        bodyTableauComposition.children().each(function () {
            let ingredient_recette = {};
            // Récupération de l'id de l'ingrédient
            ingredient_recette.id_ingredient = $(this).attr("data-id");
            ingredient_recette.quantite_ingredient = $(this).find("input[class~='quantite_ingredient']").val();
            ingredient_recette.optionnel_ingredient = $(this).find("input[class~='optionnel_ingredient']").prop("checked");
            if (ingredient_recette.optionnel_ingredient) {
                ingredient_recette.prix_ingredient = $(this).find("input[class~='prix_ingredient']").val();
            }
            ingredients_recette.push(ingredient_recette);
        });
        formDatas.append("ingredients_recette", JSON.stringify(ingredients_recette));

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

        // Déplacement de l'image de la recette de l'input vers l'élément img
        let inputImage = formRecette.find("input[name='image_recette']");
        let imageRecette = formRecette.find("img[id='image_recette_preview']");
        if (inputImage[0].files.length > 0) {
            imageRecette.attr("src", URL.createObjectURL(inputImage[0].files[0]));
            // Suppression de l'image de la recette de l'input
            inputImage.val("");
            // Suppression de l'attribut "required" de l'input (si présent)
            inputImage.removeAttr("required");
        }

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
                        // Si on modifie la recette
                        if (url.pathname.endsWith("/recettes/modifier")) {
                            // Réactivation des champs du formulaire
                            disabledElements.forEach(function (element) {
                                element.prop("disabled", false);
                            });

                            // Suppression icone et texte de chargement (fontawesome)
                            enregistrerRecette.html(old_html);

                            // On enlève la couleur du bouton
                            enregistrerRecette.css('background-color', '');

                            // On actualise la composition de la recette
                            refreshIngredients();
                        }
                        // Sinon si on ajoute une recette, on redirige vers la page de modification de la recette
                        else {
                            window.location.href = "modifier?id=" + data.id;
                        }
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
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }

                // Réactivation des champs du formulaire
                disabledElements.forEach(function (element) {
                    element.prop("disabled", false);
                });

                // Suppression icone et texte de chargement (fontawesome)
                enregistrerRecette.html(old_html);
            }
        });
    }

    // Lors de l'ajout d'un nouvel ingrédient
    function onAjouterNewIngredient() {
        // Ajout d'un icone et texte de chargement (fontawesome)
        let old_html = boutonAjouterNewIngredient.html();
        boutonAjouterNewIngredient.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');
        boutonAjouterNewIngredient.prop("disabled", true);

        // Récupération des ingrédients
        $.ajax({
            url: "ingredients",
            method: "GET",
            dataType: "json",
            success: function (data) {
                // Cacher le bouton d'ajout d'ingrédient
                boutonAjouterNewIngredient.hide();
                boutonAjouterNewIngredient.html(old_html);
                boutonAjouterNewIngredient.prop("disabled", false);

                // Afficher le formulaire d'ajout d'ingrédient
                ajouterIngredient.show();

                // Suppression des options du select
                selectAjouterIngredient.empty();

                // Ajout des options dans le select
                selectAjouterIngredient.append('<option></option>');
                data['data'].forEach(function (ingredient) {
                    // Ajout de l'option dans le select (dans value mettre l'ingrédient en JSON)
                    selectAjouterIngredient.append('<option value=\'' + JSON.stringify(ingredient) + '\'>' + ingredient.nom + '</option>');
                });

                // Ajout de la bibliothèque select2
                selectAjouterIngredient.select2({
                    width: 'element',
                    placeholder: 'Choisir un ingrédient'
                });

                // Lors de la sélection d'un ingrédient
                selectAjouterIngredient.on('select2:select', function (e) {
                    onIngredientSelected(e.params.data);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status !== 0) {
                    let alertMessage = 'Erreur ' + jqXHR.status;
                    // Si errorThrown contient des informations (est une chaîne de caractères)
                    if (typeof errorThrown === 'string') {
                        alertMessage += ' : ' + errorThrown.replace(/<br>/g, "\n");
                    }
                    alert(alertMessage);
                } else {
                    alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                }

                // Réafficher le bouton d'ajout d'ingrédient
                boutonAjouterNewIngredient.html(old_html);
                boutonAjouterNewIngredient.prop("disabled", false);
            }
        });
    }

    // Lors de l'annulation de l'ajout d'un nouvel ingrédient
    function onAnnulerAjouterIngredient() {
        // Suppression de la bibliothèque select2
        selectAjouterIngredient.select2('destroy');
        selectAjouterIngredient.off('select2:select');

        // Cacher le formulaire d'ajout d'ingrédient
        ajouterIngredient.hide();

        // Suppression des options du select
        selectAjouterIngredient.empty();

        // Afficher le bouton d'ajout d'ingrédient
        boutonAjouterNewIngredient.show();
    }

    // Lors de la sélection d'un ingrédient
    function onIngredientSelected(data) {
        // Récupération de l'ingrédient sélectionné
        let ingredient = JSON.parse(data.id);

        // Ajout de l'ingrédient dans la liste des ingrédients
        addIngredient(ingredient);

        // Suppression de la bibliothèque select2
        selectAjouterIngredient.select2('destroy');
        selectAjouterIngredient.off('select2:select');

        // Cacher le formulaire d'ajout d'ingrédient
        ajouterIngredient.hide();

        // Suppression des options du select
        selectAjouterIngredient.empty();

        // Afficher le bouton d'ajout d'ingrédient
        boutonAjouterNewIngredient.show();
    }

    /*****************************************
     *************** PRINCIPAL ***************
     *****************************************/

    // Lors de la soumission du formulaire
    formRecette.submit(function (event) {
        // On empêche le formulaire de se soumettre
        event.preventDefault();

        // Récupération des champs du formulaire
        let formDatas = new FormData(this);

        onFormRecetteSubmit(formDatas);
    });

    // Lors du clic sur le bouton d'ajout d'un nouvel ingrédient
    boutonAjouterNewIngredient.click(function () {
        onAjouterNewIngredient();
    });

    // Lors du clic sur le bouton d'annulation de l'ajout d'un nouvel ingrédient
    boutonAnnulerAjouterIngredient.click(function () {
        onAnnulerAjouterIngredient();
    });

    // Si on est sur la page de modification d'une recette (pathname de l'url si termine par /recettes/modifier)
    if (url.pathname.endsWith("/recettes/modifier")) {
        // On actualise la composition de la recette
        refreshIngredients();
    }
});