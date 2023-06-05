$(function () {
    /*******************************
     ********** VARIABLES **********
     *******************************/

    // Récupération des informations de la recette dans l'url
    const url = new URL(window.location.href);

    // Récupération des élements du DOM
    const formRecette = $("#form_recette");
    const annulerRecette = $("#annuler");
    const enregistrerRecette = $("#enregistrer");
    const bodyTableauComposition = $("#tableau_composition tbody");
    const boutonAjouterNewIngredient = $("#bouton_ajouter_new_ingredient");
    const ajouterIngredient = $("#ajouter_ingredient");
    const selectAjouterIngredient = $("#select_ajouter_ingredient");
    const boutonAnnulerAjouterIngredient = $("#bouton_annuler_ajouter_ingredient");
    const boutonAjouterNewSelectionMultiple = $("#bouton_ajouter_new_selection_multiple");
    const boutonAnnulerSelectionMultiple = $("#bouton_annuler_selection_multiple");
    const boutonEnregistrerSelectionMultiple = $("#bouton_enregistrer_selection_multiple");

    let ingredients = [];
    let ingredientSelectionMultiple = null;
    let ingredientsSelectionMultiple = null;

    /*****************************
     ********* FONCTIONS *********
     *****************************/

    // Fonction permettant d'actualiser l'affichage du tableau de composition de la recette
    function refreshIngredients() {
        // Supprimer toutes les lignes du tableau
        bodyTableauComposition.empty();

        let selectionMultiple;
        let composition;
        if (ingredientsSelectionMultiple !== null) {
            selectionMultiple = true;
            composition = ingredientsSelectionMultiple;
        } else {
            selectionMultiple = false;
            composition = ingredients;
        }

        // Si aucun ingrédient n'est présent, afficher "Aucun résultats"
        if (composition.length == 0) {
            let ligne = $("<tr>");
            let cellule = $("<td>");
            cellule.attr("colspan", 6);
            cellule.html("<br>Aucun ingrédients<br><br>");
            ligne.append(cellule);
            bodyTableauComposition.append(ligne);
        }
        // Sinon, ajouter chaque ingrédient dans une nouvelle ligne
        else {
            composition.forEach(element => {
                let ligne = $("<tr>");
                ligne.attr("data-id", element.id);

                // Image
                let cellule = $("<td>");
                cellule.append($("<img>").attr("src", element.image));
                ligne.append(cellule);

                // Nom
                cellule = $("<td>");
                if (element.ingredients !== undefined) {
                    cellule.append("Sélection multiple : ");
                    element.ingredients.forEach(element => {
                        cellule.append($("<li>").text(element.quantite + element.unite + " " + element.nom));
                    });
                } else {
                    cellule.text(element.nom);
                }
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
                    value: element.quantite,
                    required: true
                }).addClass("input");
                celluleDiv.append(inputQuantite);
                // Ajouter l'unité
                celluleDiv.append($("<span>").text(element.unite));
                cellule.append(celluleDiv);
                ligne.append(cellule);

                // Actualiser la quantité de l'ingrédient dans le tableau javascript
                inputQuantite.change(function () {
                    element.quantite = inputQuantite.val();
                });

                // Optionnel
                cellule = $("<td>");
                celluleDiv = $("<div>");
                celluleDiv.addClass("wrapper main_axe_center second_axe_center");
                let inputOptionnel = $("<input>").attr({
                    type: "checkbox",
                    checked: element.optionnel
                }).addClass("input");
                celluleDiv.append(inputOptionnel);
                cellule.append(celluleDiv);
                ligne.append(cellule);

                // Si on est en sélection multiple, cacher le champ optionnel
                if (selectionMultiple) {
                    inputOptionnel.parent().hide();
                }

                // Si l'élément est une sélection multiple, cacher le champ optionnel
                if (element.ingredients !== undefined) {
                    inputOptionnel.parent().hide();
                }

                // Prix
                cellule = $("<td>");
                celluleDiv = $("<div>");
                celluleDiv.addClass("wrapper main_axe_center second_axe_center");
                let inputPrix = $("<input>").attr({
                    type: "number",
                    min: 0,
                    max: 99.99,
                    step: 0.01,
                    value: element.prix,
                    required: true
                }).addClass("input");
                celluleDiv.append(inputPrix);
                celluleDiv.append($("<span>").text("€"));
                cellule.append(celluleDiv);
                ligne.append(cellule);

                // A chaque changement de valeur du champ optionnel
                inputOptionnel.change(function () {
                    if (inputOptionnel.prop("checked")) {
                        element.optionnel = true;
                        inputPrix.prop("disabled", false);
                        // Si l'ingrédient possède un prix, l'afficher
                        if (element.prix !== undefined) {
                            inputPrix.val(element.prix);
                        }
                    } else {
                        element.optionnel = false;
                        inputPrix.prop("disabled", true);
                        // Si le champ prix possède une valeur, l'effacer dans le champ
                        if (inputPrix.val() !== "") {
                            inputPrix.val("");
                        }
                    }
                });

                // A chaque changement de valeur du champ prix
                inputPrix.change(function () {
                    element.prix = inputPrix.val();
                });

                // Désactiver le champ prix si l'ingrédient est obligatoire
                if (!element.optionnel) {
                    inputPrix.prop("disabled", true);
                }

                // Cacher le champ prix on est en sélection multiple
                if (selectionMultiple) {
                    inputPrix.parent().hide();
                }

                // Cacher le champ prix si l'ingrédient est une sélection multiple
                if (element.ingredients !== undefined) {
                    inputPrix.parent().hide();
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
                        // Dans la vue (HTML)
                        ligne.insertBefore(lignePrecedente);
                        // Dans le modèle (Javascript)
                        let index = composition.indexOf(element);
                        composition.splice(index, 1);
                        composition.splice(index - 1, 0, element);
                    }
                });
                boutonMonter.append($("<i>").addClass("fa-solid fa-arrow-up"));
                celluleDiv.append(boutonMonter);

                // Cacher le bouton monter si on est en sélection multiple
                if (selectionMultiple) {
                    boutonMonter.attr('hidden', true);
                }

                // Bouton descendre
                let boutonDescendre = $("<button>").attr("type", "button").addClass("bouton");
                boutonDescendre.click(function () {
                    // Récupérer la ligne suivante
                    let ligneSuivante = ligne.next();
                    // Si la ligne suivante existe
                    if (ligneSuivante.length > 0) {
                        // Déplacer la ligne actuelle après la ligne suivante
                        // Dans la vue (HTML)
                        ligne.insertAfter(ligneSuivante);
                        // Dans le modèle (Javascript)
                        let index = composition.indexOf(element);
                        composition.splice(index, 1);
                        composition.splice(index + 1, 0, element);
                    }
                });
                boutonDescendre.append($("<i>").addClass("fa-solid fa-arrow-down"));
                celluleDiv.append(boutonDescendre);

                // Cacher le bouton descendre si on est en sélection multiple
                if (selectionMultiple) {
                    boutonDescendre.attr('hidden', true);
                }

                // Bouton modifier
                let boutonModifier = $("<button>").attr("type", "button").addClass("bouton");
                boutonModifier.click(function () {
                    onModifierSelectionMultiple(element);
                });
                boutonModifier.append($("<i>").addClass("fa-solid fa-edit"));
                celluleDiv.append(boutonModifier);

                // Cacher le bouton modifier si l'élément n'est pas une sélection multiple
                if (element.ingredients === undefined) {
                    boutonModifier.attr('hidden', true);
                }

                // Bouton supprimer
                let boutonSupprimer = $("<button>").attr("type", "button").addClass("bouton");
                boutonSupprimer.click(function () {
                    // Supprimer la ligne
                    // Dans la vue (HTML)
                    ligne.remove();
                    // Dans le modèle (Javascript)
                    let index = composition.indexOf(element);
                    composition.splice(index, 1);

                    // Si le tableau est vide
                    if (bodyTableauComposition.children().length === 0) {
                        // Ajouter la ligne vide
                        let ligne = $("<tr>");
                        let cellule = $("<td>");
                        cellule.attr("colspan", 6);
                        cellule.html("<br>Aucun ingrédients<br><br>");
                        ligne.append(cellule);
                        bodyTableauComposition.append(ligne);
                    }
                });
                boutonSupprimer.append($("<i>").addClass("fa-solid fa-trash"));
                celluleDiv.append(boutonSupprimer);

                cellule.append(celluleDiv);
                ligne.append(cellule);

                // Ajout de la ligne au tableau
                bodyTableauComposition.append(ligne);
            });
        }
    }

    // Fonction permettant d'actualiser le tableau de composition de la recette
    function refreshDataIngredients() {
        // Désactiver les boutons
        boutonAjouterNewIngredient.prop("disabled", true);
        boutonAjouterNewSelectionMultiple.prop("disabled", true);

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
                // Actualisation des ingrédients
                ingredients = data['data'];
                refreshIngredients();

                // Activer les boutons
                boutonAjouterNewIngredient.prop("disabled", false);
                boutonAjouterNewSelectionMultiple.prop("disabled", false);
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

    // Lors de l'annulation des modifications
    function onAnnuler() {
        // On recharge la page
        window.location.reload();
    }

    // Lors de la soumission du formulaire
    function onFormRecetteSubmit(formDatas) {
        // Si on modifie la recette
        if (url.pathname.endsWith("/recettes/modifier")) {
            // Récupération de l'id de la recette
            let idRecette = url.searchParams.get("id");
            formDatas.append("id_recette", idRecette);
        }

        // Construction de l'ordre des ingrédients
        let ordre = 1;
        ingredients.forEach(function (element) {
            element.ordre = ordre;
            ordre++;
        });
        // Ajout des ingrédients au formulaire
        formDatas.append("ingredients_recette", JSON.stringify(ingredients));

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
                            refreshDataIngredients();
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

        let ingredientIgnorer = [];
        // Si on est en mode sélection multiple, on ignore les ingrédients déjà présents
        if (ingredientsSelectionMultiple !== null) {
            ingredientsSelectionMultiple.forEach(function (element) {
                ingredientIgnorer.push(element.id);
            });
        }

        // Récupération des ingrédients
        $.ajax({
            url: "ingredients",
            method: "POST",
            data: {
                ignorer: ingredientIgnorer
            },
            dataType: "json",
            success: function (data) {
                // Cacher le bouton d'ajout d'ingrédient
                boutonAjouterNewIngredient.attr('hidden', true);
                boutonAjouterNewIngredient.html(old_html);
                boutonAjouterNewIngredient.prop("disabled", false);

                // Afficher le formulaire d'ajout d'ingrédient
                ajouterIngredient.attr('hidden', false);

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
        ajouterIngredient.attr('hidden', true);

        // Suppression des options du select
        selectAjouterIngredient.empty();

        // Afficher le bouton d'ajout d'ingrédient
        boutonAjouterNewIngredient.attr('hidden', false);
    }

    // Lors de la sélection d'un ingrédient
    function onIngredientSelected(data) {
        // Récupération de l'ingrédient sélectionné
        let ingredient = JSON.parse(data.id);

        // Ajout de l'ingrédient dans la liste des ingrédients
        if (ingredientsSelectionMultiple !== null) {
            ingredientsSelectionMultiple.push(ingredient);
        } else {
            ingredients.push(ingredient);
        }

        // Actualisation de la liste des ingrédients
        refreshIngredients();

        // Suppression de la bibliothèque select2
        selectAjouterIngredient.select2('destroy');
        selectAjouterIngredient.off('select2:select');

        // Cacher le formulaire d'ajout d'ingrédient
        ajouterIngredient.attr('hidden', true);

        // Suppression des options du select
        selectAjouterIngredient.empty();

        // Afficher le bouton d'ajout d'ingrédient
        boutonAjouterNewIngredient.attr('hidden', false);
    }

    // Lors de l'ajout d'une sélection multiple d'ingrédients
    function onAjouterNewSelectionMultiple() {
        // Création de la liste des ingrédients
        ingredientsSelectionMultiple = [];

        // Actualisation de la liste des ingrédients
        refreshIngredients();

        // Cache le bouton d'ajout d'une sélection multiple d'ingrédients
        boutonAjouterNewSelectionMultiple.attr('hidden', true);

        // Afficher les boutons d'annulation et de validation de la sélection multiple d'ingrédients
        boutonAnnulerSelectionMultiple.attr('hidden', false);
        boutonEnregistrerSelectionMultiple.attr('hidden', false);
    }

    // Lors de la modification d'une sélection multiple d'ingrédients
    function onModifierSelectionMultiple(element) {
        // Création de la liste des ingrédients
        ingredientSelectionMultiple = element;
        // Duplication de la liste des ingrédients
        ingredientsSelectionMultiple = element.ingredients.slice();

        // Actualisation de la liste des ingrédients
        refreshIngredients();

        // Cache le bouton de modification d'une sélection multiple d'ingrédients
        boutonAjouterNewSelectionMultiple.attr('hidden', true);

        // Afficher les boutons d'annulation et de validation de la sélection multiple d'ingrédients
        boutonAnnulerSelectionMultiple.attr('hidden', false);
        boutonEnregistrerSelectionMultiple.attr('hidden', false);
    }

    // Lors de l'annulation de l'ajout d'une sélection multiple d'ingrédients
    function onAnnulerSelectionMultiple() {
        // Suppression de la liste des ingrédients
        ingredientSelectionMultiple = null;
        ingredientsSelectionMultiple = null;

        // Actualisation de la liste des ingrédients
        refreshIngredients();

        // Cache les boutons d'annulation et de validation de la sélection multiple d'ingrédients
        boutonAnnulerSelectionMultiple.attr('hidden', true);
        boutonEnregistrerSelectionMultiple.attr('hidden', true);

        // Afficher le bouton d'ajout d'une sélection multiple d'ingrédients
        boutonAjouterNewSelectionMultiple.attr('hidden', false);
    }

    // Lors de l'enregistrement de la sélection multiple d'ingrédients
    function onEnregistrerSelectionMultiple() {
        // Vérification que les champs sont valides (vérification HTML5)
        if (!formRecette[0].checkValidity()) {
            // Affichage des erreurs HTML5
            formRecette[0].reportValidity();
            return;
        }

        // Vérification que la liste des ingrédients n'est pas vide
        if (ingredientsSelectionMultiple.length === 0) {
            alert('La liste des ingrédients ne peut pas être vide !\nVeuillez ajouter au moins un ingrédient.');
            return;
        }

        // Si il s'agit d'un ajout d'une sélection multiple d'ingrédients
        if (ingredientSelectionMultiple === null) {
            // Ajout de la sélection multiple d'ingrédients dans la liste des ingrédients
            ingredients.push({
                ingredients: ingredientsSelectionMultiple
            });
        }
        // Si il s'agit d'une modification d'une sélection multiple d'ingrédients
        else {
            // Modification de la sélection multiple d'ingrédients dans la liste des ingrédients
            ingredientSelectionMultiple.ingredients = ingredientsSelectionMultiple;
        }

        // Suppression de la liste des ingrédients
        ingredientSelectionMultiple = null;
        ingredientsSelectionMultiple = null;

        // Actualisation de la liste des ingrédients
        refreshIngredients();

        // Cache les boutons d'annulation et de validation de la sélection multiple d'ingrédients
        boutonAnnulerSelectionMultiple.attr('hidden', true);
        boutonEnregistrerSelectionMultiple.attr('hidden', true);

        // Afficher le bouton d'ajout d'une sélection multiple d'ingrédients
        boutonAjouterNewSelectionMultiple.attr('hidden', false);
    }

    /*****************************************
     *************** PRINCIPAL ***************
     *****************************************/

    // Lors de l'annulation des changements
    annulerRecette.click(function () {
        onAnnuler();
    });

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

    // Lors du clic sur le bouton d'ajout d'une sélection multiple d'ingrédients
    boutonAjouterNewSelectionMultiple.click(function () {
        onAjouterNewSelectionMultiple();
    });

    // Lors du clic sur le bouton d'annulation de la sélection multiple d'ingrédients
    boutonAnnulerSelectionMultiple.click(function () {
        onAnnulerSelectionMultiple();
    });

    // Lors du clic sur le bouton d'enregistrement de la sélection multiple d'ingrédients
    boutonEnregistrerSelectionMultiple.click(function () {
        onEnregistrerSelectionMultiple();
    });

    // Si on est sur la page de modification d'une recette (pathname de l'url si termine par /recettes/modifier)
    if (url.pathname.endsWith("/recettes/modifier")) {
        // On actualise la composition de la recette
        refreshDataIngredients();
    }
});