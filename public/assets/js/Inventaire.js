
// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Inventaire.js');

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
    };

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
    }

    // requête AJAX pour récupérer les 3 recettes les plus populaires
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
                    let tr = $("<tr></tr>").attr({
                        "data_id": element.id
                    });

                    // Première cellule
                    let td1 = $("<td></td>");
                    let img = $("<img>").attr("src", element.photo);
                    img.addClass("img_ingredient");
                    td1.append(img);

                    // Deuxième cellule
                    let td2 = $("<td></td>").text(element.nom);

                    // Troisième cellule
                    let td3 = $("<td></td>");
                    let div1 = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
                    let input1 = $("<input>").addClass("input").attr({
                        "type": "number",
                        "min": 0,
                        "max": 99,
                        "step": 1,
                        "disabled": true,
                        "value": element.stock
                    });
                    div1.append(input1);
                    let unite = $("<p></p>").text(element.unite);
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
                    unite = $("<p></p>").text(element.unite);
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
    actualiserTableau();

    // requête AJAX pour actualiser la base de donnée avec les nouvelles valeurs
    let miseAJourTableau = function () {
        // on boucle sur toutes les lignes et on prépare un json
        let json = new Array();
        let error = false;
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
            // CORRIGER
            json.push({
                id: id,
                stock: stock
            });
        });

        // on transforme en json
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

                // On notifie la réussite de la mise à jour
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
    $('#bouton_mise_a_jour').on('click', miseAJourTableau);
});