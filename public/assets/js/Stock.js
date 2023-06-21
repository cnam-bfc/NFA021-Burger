// variables global du fichier
var bdcActuel = [];
// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Stock.js');

    // évènements sur les boutons
    $("#ajouter_ingredient").on('click', onAjouterNewIngredient);
    $('#bouton_annuler_ajouter_ingredient').on('click', onAnnulerAjouterIngredient);
    $('#bouton_mise_a_jour').on('click', validationFormulaire);

    // on récupère les bons de commandes en ajax et on met à jour le select
    $.ajax({
        url: 'stock/getBonsCommandesAJAX',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log('Stock.js - récupération bon de commande - success');

            // on récupère notre select
            let select = $('#select_bon_commande');

            // on vide le select
            select.empty();

            // on ajoute une option par défaut
            let option = $("<option></option>").attr({
                "id_bdc": 0,
                "id_fournisseur": 0
            }).text("Sélectionner un bon de commande");
            select.append(option);

            // on ajoute un bon de commande non référencé
            option = $("<option></option>").attr({
                "id_bdc": -1,
                "id_fournisseur": -1
            }).text("Bon de commande non référencé");
            select.append(option);

            // on ajoute les options
            data.forEach(element => {
                let option = $("<option></option>").attr({
                    "id_bdc": element.id_commande,
                    "id_fournisseur": element.id_fournisseur_fk,
                }).text("Bon de commande : " + element.id_commande);
                select.append(option);
            });
        },
        error: function (data) {
            // message dans la console
            console.log('Stock.js - récupération bon de commande - error');

            // On notifie l'échec de la mise à jour
            alert("La récupération des bons de commandes a échoué");
        }
    });


    // fonction pour récupérer tous les fournisseurs
    $.ajax({
        url: 'stock/getFournisseursAJAX',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log('Stock.js - récupération fournisseurs - success');

            // on récupère notre select
            let select = $('#select_fournisseur');

            // on vide le select
            select.empty();

            // on ajoute une option par défaut
            let option = $("<option></option>").attr({
                "id_fournisseur": 0
            }).text("Sélectionner un bon de commande");
            select.append(option);

            // on ajoute les options
            data.forEach(element => {
                let option = $("<option></option>").attr({
                    "id_fournisseur": element.id_fournisseur
                }).text(element.nom_fournisseur);
                select.append(option);
            });
        },
        error: function (data) {
            // message dans la console
            console.log('Stock.js - récupération fournisseurs - error');

            // On notifie l'échec de la mise à jour
            alert("La mise à jour de l'inventaire a échoué");
        }
    });

    // on ajoute un evenement sur les bons de commandes pour récupérer les ingrédients et disabled le select fournisseur si un bon de commande est sélectionné
    $('#select_bon_commande').on('change', function () {
        // message dans la console
        console.log('Stock.js - changement bon de commande');

        // on récupère l'id du fournisseur  et on met à jour le select fournisseur
        let id_fournisseur = $(this).find(':selected').attr('id_fournisseur');
        mettreAJourFournisseur(id_fournisseur);

        // on récupère l'id du bon de commande et on met à jour le tableau
        let id_bdc = $(this).find(':selected').attr('id_bdc');
        refreshTableau(id_bdc);
    });

    // on met notre valeur par défaut dans le select bdc
    mettreAJourFournisseur(0);
    refreshTableau(0);
});

let validationFormulaire = function () {
    // message dans la console
    console.log('Stock.js - validation formulaire');

    // Vérification que les champs sont valides (vérification HTML5)
    let form_stock = $('#form_stock');
    if (!form_stock[0].checkValidity()) {
        // Affichage des erreurs HTML5
        form_stock[0].reportValidity();
        return;
    }

    // on vérifie si un bon de commande est bien sélectionné et si c'est pas un bon de commande non référencé
    if ($('#select_bon_commande').find(':selected').attr('id_bdc') == 0) {
        alert("Vous devez sélectionner un bon de commande");
        return;
    }

    // on vérifie si un fournisseur est bien sélectionné 
    // on vérifie si le fournisseur sélectionner n'est pas le fournisseur par défaut avec id_fournisseur = 0
    if ($('#select_fournisseur').find(':selected').attr('id_fournisseur') == 0) {
        alert("Vous devez sélectionner un fournisseur");
        return;
    }

    // vérifier si on a des lignes dans le tableau
    if ($('#tableau_inventaire>tbody>tr[data_id]').length == 0) {
        alert("Vous n'avez aucun ingrédient à mettre à jour");
        return;
    }

    // On change le titre de la box (Ajout icone de chargement)
    let boutonStock = $(this);
    let contenuBoutonStock = boutonStock.html();
    boutonStock.prop('disabled', true);
    boutonStock.html('<i class="fa-solid fa-spinner fa-spin"></i> ' + "En cours de validation...");

    // on boucle sur toutes les lignes et on prépare un json
    let json = {};
    json["id_bdc"] = $('#select_bon_commande').find(':selected').attr('id_bdc');
    json["id_fournisseur"] = $('#select_fournisseur').find(':selected').attr('id_fournisseur');
    json["ingredients"] = [];

    // note modifier le foreach pour mettre une autre boucle afin de l'arrêter en cas d'erreur
    $('#tableau_inventaire>tbody>tr').each(function () {
        let id = $(this).attr('data_id');
        let quantiteRecu = $(this).find('td:nth-child(4)>div>input').val();
        json["ingredients"].push({
            id: id,
            quantite_recu: quantiteRecu
        });
    });

    // on transforme en json
    json = JSON.stringify(json);

    // on envoie le json à la méthode ajax
    $.ajax({
        url: 'stock/validationBonCommandeAJAX',
        type: 'POST',
        dataType: 'json',
        data: {
            data: json
        },
        success: function (data) {
            // message dans la console
            console.log('Stock.js - mise à jour stock - success');
            console.log(data);

            // on vérifie si data (json) contient le boolean true ou false
            if (!data) {
                alert("La prise en comtpe du bon de commande a rencontré un problème");
                return;
            }
            // On notifie la réussite de la mise à jour
            alert("La prise en comtpe du bon de commande est un succès");
            bdcActuel = [];

            // On retire le bon de commande du select et on met à jour le tableau si c'est pas le -1
            if ($('#select_bon_commande').find(':selected').attr('id_bdc') != -1) {
                $('#select_bon_commande>option:selected').remove();
            }
            // on met le select sur l'option dont la vue id_bdc = 0
            $("#select_bon_commande option[id_bdc='0']").attr('selected', true);
            mettreAJourFournisseur(0);
            refreshTableau();
        },
        error: function (data) {
            // message dans la console
            console.log('Stock.js - mise à jour stock - error');

            // On notifie l'échec de la mise à jour
            alert("La mise à jour de l'inventaire a échoué");
        },
        complete: function (data) {
            boutonStock.html(contenuBoutonStock);
            boutonStock.prop('disabled', false);
        }
    });
}

// fonction qui permet de mettre à jour le tableau
refreshTableau = function (idCommande) {
    // message dans la console
    console.log('Stock.js - mise à jour tableau');

    console.log(idCommande);

    // on récupère notre tableau, précisément le tbody
    let tbody = $('#tableau_inventaire>tbody');

    // on vide le tbody 
    tbody.empty();

    // Ajout ligne de chargement
    let ligne = $("<tr>");
    let cellule = $("<td>");
    cellule.attr("colspan", 5);
    cellule.html("<br><i class='fa-solid fa-spinner fa-spin'></i> Chargement des ingrédients...<br><br>");
    ligne.append(cellule);
    tbody.append(ligne);

    if (idCommande > 0) {
        // on cache les td dans le tfoot
        $('#tableau_inventaire>tfoot>tr>td').hide();
        // on récupère tous les ingrédients associés à la commande avec une requête ajax
        $.ajax({
            url: 'stock/refreshTableauIngredientsAJAX',
            type: 'POST',
            dataType: 'json',
            data: {
                data: idCommande
            },
            success: function (data) {
                // message dans la console
                console.log('Stock.js - mise à jour tableau - success');

                // on retire tout ce qu'il y a dans le tbody
                tbody.empty();

                if (data.length == 0) {
                    // On remplie avec une ligne qui dit pas d'ingrédients
                    ligneDeTexteTBody("Aucun ingrédient n'a été trouvé dans la base de données");
                    // on re affiche le td dans le tfoot
                    $('#tableau_inventaire>tfoot>tr>td').show();
                    return;
                }

                bdcActuel = [];
                data.forEach(element => {
                    bdcActuel[element.id] = {
                        'id': element.id,
                        'nom': element.nom,
                        'photo': element.photo,
                        'quantite_attendu': element.quantite_attendu,
                        'unite': element.unite
                    };
                    ajouterLigneTBody(element.id, element.nom, element.photo, element.quantite_attendu, element.unite);
                });
                // on re affiche le td dans le tfoot
                $('#tableau_inventaire>tfoot>tr>td').show();
                // on met à jour le select des ingrédients
                onAjouterNewIngredient();
            },
            error: function (data) {
                // message dans la console
                console.log('Stock.js - mise à jour tableau - error');

                // on retire tout ce qu'il y a dans le tbody
                tbody.empty();

                // on re affiche le td dans le tfoot
                $('#tableau_inventaire>tfoot>tr>td').show();

                // On remplie avec une ligne qui dit pas d'ingrédients
                ligneDeTexteTBody("La récupération des ingrédients a échoué");

                // On notifie l'échec de la mise à jour
                alert("La récupération de la commande a échoué");
            }
        });
    } else {
        // message dans la console
        console.log('Stock.js - mise à jour tableau - id 0 ou -1 - success');

        // on retire tout ce qu'il y a dans le tbody
        tbody.empty();

        // On remplie avec une ligne qui dit pas d'ingrédients
        ligneDeTexteTBody("Pas d'ingrédient à afficher");
    }
}

// fonction qui permet d'ajouter une ligne dans le tableau
ajouterLigneTBody = function (id, nom, photo, quantite_attendu, unite) {
    // on récupère notre tableau, précisément le tbody
    let tbody = $('#tableau_inventaire>tbody');

    let tr = $("<tr></tr>").attr({
        "data_id": id
    });

    // Première cellule
    let td1 = $("<td></td>");
    let img = $("<img>").attr("src", photo);
    img.addClass("img_ingredient");
    td1.append(img);

    // Deuxième cellule
    let td2 = $("<td></td>").text(nom);

    if (quantite_attendu == null) {
        // on vérifie si l'id de l'ingrédient est dans le tableau bdcActuel
        if (typeof bdcActuel[id] !== 'undefined') {
            quantite_attendu = bdcActuel[id].quantite_attendu;
        }
    }
    // Troisième cellule
    let td3 = $("<td></td>");
    let div1 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    let input1 = $("<input>").addClass("input").attr({
        "type": "number",
        "min": 0,
        "step": 1,
        "disabled": true,
        "value": quantite_attendu
    });
    div1.append(input1);
    let uniteTexte = $("<span>").text(unite);
    div1.append(uniteTexte);
    td3.append(div1);

    // Quatrième cellule
    let td4 = $("<td></td>");
    let div2 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    let input2 = $("<input>").addClass("input").attr({
        "type": "number",
        "min": 0,
        "step": 1,
        required: true
    });
    div2.append(input2);
    unite = $("<span>").text(unite);
    div2.append(unite);
    td4.append(div2);

    // Cinquième cellule
    let td5 = $("<td></td>");
    let div3 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    if (!(typeof bdcActuel[id] !== 'undefined')) {
        let button = $("<button></button>").addClass("bouton");
        let icon = $("<i></i>").addClass("fa-solid fa-eye");
        button.append(icon);
        button.on("click", suppressionIngredient);
        div3.append(button);
    }
    td5.append(div3);

    tr.append(td1, td2, td3, td4, td5);

    tbody.append(tr);
}

// Fonctions
// fonction pour la suppression d'un ingrédient dans le tableau (voir si on peut optimiser)
let suppressionIngredient = function () {
    let tbody = $('#tableau_inventaire>tbody');

    // on récupère la ligne concernée
    let ligne = $(this).parent().parent().parent();
    // on la supprime
    ligne.remove();

    // savoir si tbody est vide
    if (tbody.children().length == 0) {
        // on ajoute une ligne dans le tableau avec un message d'erreur
        ligneDeTexteTBody("Vous n'avez plus d'ingrédient à mettre à jour");
    }

    $("#ajouter_ingredient").html('<i class="fa-solid fa-plus"></i> Ajouter un ingrédient');
};

let ligneDeTexteTBody = function (texte) {
    let tbody = $('#tableau_inventaire > tbody');

    let tr = $("<tr></tr>").addClass("ligne_texte");
    let td = $("<td></td>");
    td = $("<td></td>").attr("colspan", 5);
    let div = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    div.addClass("padding_bottom_top_moyen");
    let p = $("<p></p>").text(texte);
    div.append(p);
    td.append(div);
    tr.append(td);
    tbody.append(tr);
}

// Fonctions pour gérer le bouton ajouter un ingrédient 
// Lors de l'ajout d'un nouvel ingrédient
function onAjouterNewIngredient() {
    console.log("onAjouterNewIngredient()");

    // on vérifie si un bon de commande est bien sélectionné et si c'est pas un bon de commande non référencé
    if ($('#select_bon_commande').find(':selected').attr('id_bdc') == 0) {
        alert("Vous devez sélectionner un bon de commande");
        return;
    }

    // Ajout d'un icone et texte de chargement (fontawesome)
    let boutonAjouterNewIngredient = $("#ajouter_ingredient");
    let old_html = boutonAjouterNewIngredient.html();
    boutonAjouterNewIngredient.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');
    boutonAjouterNewIngredient.prop("disabled", true);

    // on récupère le data_id de toutes les lignes du tbody
    let data_id = {};
    data_id['recette'] = new Array();
    data_id['fournisseur'] = $('#select_fournisseur').find(':selected').attr('id_fournisseur');
    $('#tableau_inventaire tbody tr').each(function () {
        data_id['recette'].push($(this).attr('data_id'));
    });
    console.log(data_id);
    data_id = JSON.stringify(data_id);
    console.log(data_id);

    // Récupération des ingrédients
    $.ajax({
        url: "stock/refreshListeIngredients",
        method: "POST",
        dataType: "json",
        data: {
            data: data_id
        },
        success: function (data) {
            if (data.length == 0) {
                // Réafficher le bouton d'ajout d'ingrédient
                boutonAjouterNewIngredient.text('Tous les ingrédients disponibles pour ce fournisseur sont déjà dans le tableau');
                boutonAjouterNewIngredient.prop("disabled", false);
                return;
            }

            // Cacher le bouton d'ajout d'ingrédient
            boutonAjouterNewIngredient.hide();
            boutonAjouterNewIngredient.html('<i class="fa-solid fa-plus"></i> Ajouter un ingrédient');
            boutonAjouterNewIngredient.prop("disabled", false);

            // Afficher le formulaire d'ajout d'ingrédient
            $("#ajouter_ingredient_div").show();

            // Suppression des options du select
            selectAjouterIngredient = $("#select_ajouter_ingredient");
            selectAjouterIngredient.empty();

            // Ajout des options dans le select
            selectAjouterIngredient.append('<option></option>');
            console.log(data);
            data.forEach(function (ingredient) {
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
    console.log("annuler");
    // Suppression de la bibliothèque select2
    selectAjouterIngredient = $("#select_ajouter_ingredient");
    selectAjouterIngredient.select2('destroy');
    selectAjouterIngredient.off('select2:select');

    // Cacher le formulaire d'ajout d'ingrédient
    $("#ajouter_ingredient_div").hide();

    // Suppression des options du select
    selectAjouterIngredient.empty();

    // Afficher le bouton d'ajout d'ingrédient
    $("#ajouter_ingredient").show();
}

// Lors de la sélection d'un ingrédient
function onIngredientSelected(data) {
    console.log("data " + data);
    // on supprime les lignes avec des messages (class ligne_texte)
    $('#tableau_inventaire>tbody>tr.ligne_texte').remove();

    // Récupération de l'ingrédient sélectionné
    let ingredient = JSON.parse(data.id);

    // Ajout de l'ingrédient dans la liste des ingrédients
    console.log(ingredient);
    ajouterLigneTBody(ingredient.id, ingredient.nom, ingredient.photo, null, ingredient.unite);

    // Suppression de la bibliothèque select2
    selectAjouterIngredient = $("#select_ajouter_ingredient");
    selectAjouterIngredient.select2('destroy');
    selectAjouterIngredient.off('select2:select');

    // Cacher le formulaire d'ajout d'ingrédient
    $("#ajouter_ingredient_div").hide();

    // Suppression des options du select
    selectAjouterIngredient.empty();

    // Afficher le bouton d'ajout d'ingrédient
    $("#ajouter_ingredient").show();
}

// fonction qui permet de mettre le bon fournisseur dans le select fournisseur
mettreAJourFournisseur = function (idFournisseur) {
    // message dans la console
    console.log('Stock.js - mise à jour fournisseur');

    // on récupère le select fournisseur
    let select_fournisseur = $('#select_fournisseur');

    if (idFournisseur == -1) {
        // on désactive le select fournisseur
        $('#select_fournisseur').prop('disabled', false);
        let option = select_fournisseur.find('[id_fournisseur="0"]');
        // on dit au select de prendre cette option
        select_fournisseur.val(option.val());
    } else {
        // on active le select fournisseur
        $('#select_fournisseur').prop('disabled', true);
        let option = select_fournisseur.find('[id_fournisseur="' + idFournisseur + '"]');
        // on dit au select de prendre cette option
        select_fournisseur.val(option.val());
    }
}