
// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Inventaire.js');

    // requête AJAX pour récupérer les 3 recettes les plus populaires
    $.ajax({
        url: 'inventaire/refreshTableauInventaire',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log('Inventaire.js - refreshTableauInventaire - success');

            // on récupère notre tableau, précisément le tbody
            let tbody = $('#tableau_inventaire>tbody');

            let suppressionIngredient = function () {
                // on récupère la ligne concernée
                let ligne = $(this).parent().parent().parent();
                // on la supprime
                ligne.remove();
            };

            data.forEach(element => {
                let tr = $("<tr></tr>");

                // Première cellule
                let td1 = $("<td></td>");
                let img = $("<img>").attr("src", element.photo);
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

            // on récupère notre tableau, précisément le tbody
            let tbody = $('#tableau_inventaire>tbody');

            // on ajoutera une ligne qui dit qu'il y a eu une erreur
            let tr = $("<tr></tr>");
            let td = $("<td></td>");
            td = $("<td></td>").attr("colspan", 5);
            let div = $("<div></div>").addClass("wrapper main_axe_center second_axe_center");
            div.addClass("padding_bottom_top_moyen");
            let p = $("<p></p>").text("Aucun ingrédient n'a été trouvé dans la base de données");
            div.append(p);
            td.append(div);
            tr.append(td);
            tbody.append(tr);
        }
    });

});