// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Inventaire.js');

    actualiserTableau();

    // Evènements
    $('#bouton_mise_a_jour').on('click', validationInventaire);
    $("#ajouter_ingredient").on('click', onAjouterNewIngredient);
    $('#bouton_annuler_ajouter_ingredient').on('click',onAnnulerAjouterIngredient);
});

/*****************
 *** FONCTIONS ***
 ****************/
/**
 * Méthode pour valider l'inventaire
 * @returns {void}
 */
let validationInventaire = function () {
    console.log('Inventaire.js - validationInventaire');

    // vérifier si on a des lignes dans le tableau
    if ($('#tableau_inventaire>tbody>tr[data_type]').length == 0) {
        alert("Vous n'avez aucun ingrédient à mettre à jour");
        return;
    }
    // déclaration des variables
    let json = new Array();
    let error = false;
    // TODO : modifier le foreach pour mettre une autre boucle afin de l'arrêter en cas d'erreur
    // on boucle pour récupérer les données et ainsi préparer le json à envoyer à la méthode ajax pour la mise à jour
    $('#tableau_inventaire>tbody>tr[data_type]').each(function () {
        let id = $(this).attr('data_id');
        let nom = $(this).find('td:nth-child(2)').text();
        let stock = $(this).find('td:nth-child(4)>div>input').val();
        // on vérifie que le stock n'est pas vide , null ou négatif
        if (stock === null || stock === "" || stock < 0) {
            alert("Le stock de l'ingrédient " + nom + " est vide.\nVeuillez entrer une valeur ou supprimer l'ingrédient de l'inventaire");
            // on focus l'élément pour que l'utilisateur puisse le modifier
            $(this).find('td:nth-child(4)>div>input').focus();
            error = true;
            return;
        }
        if (stock < 0) {
            alert("Le stock de l'ingrédient " + nom + " est négatif.\nVeuillez entrer une valeur positive ou supprimer l'ingrédient de l'inventaire");
            // on focus l'élément pour que l'utilisateur puisse le modifier
            $(this).find('td:nth-child(4)>div>input').focus();
            error = true;
            return;
        }
        json.push({
            id: id,
            stock: stock
        });
    });

    // on format les données en json
    json = JSON.stringify(json);

    // si on a détecté une erreur, on arrête la fonction - vérification en + que le html
    if (error == true) {
        return;
    }

    // on envoie le json à la méthode ajax
    $.ajax({
        url: 'inventaire/miseAJourInventaire',
        type: 'POST',
        dataType: 'json',
        data: {
            data: json
        },
        success: function (data) {
            // message dans la console
            console.log('Inventaire.js - mise à jour inventaire - success');
            console.log(data);

            if (data.success == false) {
                // On notifie l'échec de la mise à jour
                alert("La mise à jour de l'inventaire a échoué : " + data.message);
                return;
            }
            // On notifie la réussite de la mise à jour -> peut-être voir pour rendre ça plus joli
            alert("La mise à jour de l'inventaire a été effectuée avec succès");

            // on actualise le tableau
            actualiserTableau();
        },
        error: function (data) {
            // message dans la console
            console.log('Inventaire.js - mise à jour inventaire - error');

            // On notifie l'échec de la mise à jour
            alert("La mise à jour de l'inventaire a échoué");
        }
    });
}

/**
 * Fonction qui actualise le tableau des ingrédients
 * @returns {void}
 */
let actualiserTableau = function () {
    $.ajax({
        url: 'inventaire/refreshTableauInventaire',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log('Inventaire.js - refreshTableauInventaire - success');

            // on récupère notre tableau, précisément le tbody
            let tbody = $('#tableau_inventaire>tbody');

            // on retire tout ce qu'il y a dans le tbody
            tbody.empty();

            data.forEach(element => {
                ajouterLigneTBody(element.id, element.nom, element.photo, element.stock, element.unite);
            });
        },
        error: function (data) {
            // message dans la console
            console.log('Inventaire.js - refreshTableauInventaire - error');

            // on ajoute une ligne dans le tableau avec un message d'erreur
            ligneDeTexteTBody("Aucun ingrédient n'a été trouvé dans la base de données");
        }
    });
};

let ajouterLigneTBody = function (id, nom, photo, stock, unite) {
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

    // Troisième cellule
    let td3 = $("<td></td>");
    let div1 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    let input1 = $("<input>").addClass("input").attr({
        "type": "number",
        "min": 0,
        "step": 1,
        "disabled": true,
        "value": stock
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
        "step": 0.01
    });
    div2.append(input2);
    uniteTexte = $("<span>").text(unite);
    div2.append(uniteTexte);
    td4.append(div2);

    // Cinquième cellule
    let td5 = $("<td></td>");
    let div3 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    let button = $("<button></button>").addClass("bouton");
    let icon = $("<i></i>").addClass("fa-solid fa-trash");
    button.append(icon);
    button.on("click", suppressionIngredient);
    div3.append(button);
    td5.append(div3);

    tr.append(td1, td2, td3, td4, td5);

    tbody.append(tr);
};

/**
 * Fonction qui ajoute une ligne dans le tableau pour afficher un message
 * @param {string} texte
 * @returns {void}
 */
let ligneDeTexteTBody = function (texte) {
    let tbody = $('#tableau_inventaire>tbody');

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
};

/**
 * Fonction qui supprime une ligne dans le tableau
 * @returns {void}
 */
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
};

// Fonctions pour gérer le bouton ajouter un ingrédient 
// Lors de l'ajout d'un nouvel ingrédient
function onAjouterNewIngredient() {
    console.log
    // Ajout d'un icone et texte de chargement (fontawesome)
    let boutonAjouterNewIngredient = $("#ajouter_ingredient");
    let old_html = boutonAjouterNewIngredient.html();
    boutonAjouterNewIngredient.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');
    boutonAjouterNewIngredient.prop("disabled", true);

    // on récupère le data_id de toutes les lignes du tbody
    let data_id = new Array();
    $('#tableau_inventaire tbody tr').each(function () {
        data_id.push($(this).attr('data_id'));
    });
    console.log (data_id);
    // on transforme en json
    data_id = JSON.stringify(data_id);
    console.log(data_id);

    // Récupération des ingrédients
    $.ajax({
        url: "inventaire/refreshListeIngredients",
        method: "POST",
        dataType: "json",
        data: {
            data: data_id
        },
        success: function (data) {
            if (data.length == 0) {
                alert("Tous les ingrédients de la base de données sont déjà dans l'inventaire");
                // Réafficher le bouton d'ajout d'ingrédient
                boutonAjouterNewIngredient.html(old_html);
                boutonAjouterNewIngredient.prop("disabled", false);
                return;
            }

            // Cacher le bouton d'ajout d'ingrédient
            boutonAjouterNewIngredient.hide();
            boutonAjouterNewIngredient.html(old_html);
            boutonAjouterNewIngredient.prop("disabled", false);

            // Afficher le formulaire d'ajout d'ingrédient
            $("#ajouter_ingredient_div").show();

            // Suppression des options du select
            selectAjouterIngredient = $("#select_ajouter_ingredient");
            selectAjouterIngredient.empty();

            // Ajout des options dans le select
            selectAjouterIngredient.append('<option></option>');
            console.log (data);
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
    ajouterLigneTBody(ingredient.id , ingredient.nom, ingredient.photo, ingredient.stock, ingredient.unite);

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