
// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Inventaire.js');

    actualiserTableau();

    $('#bouton_mise_a_jour').on('click', validationInventaire);
});


/*****************
 *** FONCTIONS ***
 ****************/


 /**
  * Méthode pour valider l'inventaire
  * @returns {void}
  */
let validationInventaire = function () {
    // déclaration des variables
    let json = new Array();
    let error = false;
    // TODO : modifier le foreach pour mettre une autre boucle afin de l'arrêter en cas d'erreur
    // on boucle pour récupérer les données et ainsi préparer le json à envoyer à la méthode ajax pour la mise à jour
    $('#tableau_inventaire>tbody>tr').each(function () {
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
        "max": 99,
        "step": 1,
        "disabled": true,
        "value": stock
    });
    div1.append(input1);
    let uniteTexte = $("<p></p>").text(unite);
    div1.append(unite);
    td3.append(div1);

    // Quatrième cellule
    let td4 = $("<td></td>");
    let div2 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
    let input2 = $("<input>").addClass("input").attr({
        "type": "number",
        "min": 0,
        "max": 99.99,
        "step": 0.01
    });
    div2.append(input2);
    uniteTexte = $("<p></p>").text(unite);
    div2.append(unite);
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

    let tr = $("<tr></tr>");
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