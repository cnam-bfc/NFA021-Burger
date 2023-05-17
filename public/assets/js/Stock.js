/*
Dans une première version on ne cachera pas la colonne quantité attendu, on mettra 0 quand le bon est non référencé
Dans une deuxième version on cachera la colonne quantité attendu si bon est non référencé
*/

// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Stock.js');

    // fonction qui permet de mettre le bon fournisseur dans le select fournisseur
    mettreAJourFournisseur = function (id_fournisseur) {
        // message dans la console
        console.log('Stock.js - mise à jour fournisseur');

        // on récupère le select fournisseur
        let select_fournisseur = $('#select_fournisseur');

        if (id_fournisseur == -1) {
            // on désactive le select fournisseur
            $('#select_fournisseur').prop('disabled', false);
            let option = select_fournisseur.find('[id_fournisseur="0"]');
            // on dit au select de prendre cette option
            select_fournisseur.val(option.val());
        } else {
            // on active le select fournisseur
            $('#select_fournisseur').prop('disabled', true);
            let option = select_fournisseur.find('[id_fournisseur="' + id_fournisseur + '"]');
            // on dit au select de prendre cette option
            select_fournisseur.val(option.val());
        }
    }

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
        let tbody = $('#tableau_inventaire > tbody');

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

    // fonction qui permet de mettre à jour le tableau
    refreshTableau = function (idCommande) {
        // message dans la console
        console.log('Stock.js - mise à jour tableau');

        console.log(idCommande);

        // on vide le tbody 
        $('#tableau_inventaire > tbody').empty();

        if (idCommande > 0) {
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

                    // on récupère notre tableau, précisément le tbody
                    let tbody = $('#tableau_inventaire>tbody');

                    // on retire tout ce qu'il y a dans le tbody
                    tbody.empty();

                    if (data.length == 0) {
                        // On remplie avec une ligne qui dit pas d'ingrédients
                        ligneDeTexteTBody("Aucun ingrédient n'a été trouvé dans la base de données");
                        return;
                    }

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
                            "value": element.quantite_attendu
                        });
                        div1.append(input1);
                        let unite = $("<span>").text(element.unite);
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
                        unite = $("<span>").text(element.unite);
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
                    console.log('Stock.js - mise à jour tableau - error');

                    // On remplie avec une ligne qui dit pas d'ingrédients
                    ligneDeTexteTBody("La récupération des ingrédients a échoué");

                    // On notifie l'échec de la mise à jour
                    alert("La récupération de la commande a échoué");
                }
            });
        } else {
            // message dans la console
            console.log('Stock.js - mise à jour tableau - id 0 ou -1 - success');

            // On remplie avec une ligne qui dit pas d'ingrédients
            ligneDeTexteTBody("Pas d'ingrédient à afficher");
        }
    }


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

    // on met notre valeur par défaut dans le select bdc
    mettreAJourFournisseur(0);
    refreshTableau(0)

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

    let validationFormulaire = function () {
        // message dans la console
        console.log('Stock.js - validation formulaire');

        // on boucle sur toutes les lignes et on prépare un json
        let json = {} ;
        json["id_bdc"] = $('#select_bon_commande').find(':selected').attr('id_bdc');
        json["ingredients"] = [];

        let error = false;
        // note modifier le foreach pour mettre une autre boucle afin de l'arrêter en cas d'erreur
        $('#tableau_inventaire>tbody>tr').each(function () {
            let id = $(this).attr('data_id');
            let nom = $(this).find('td:nth-child(2)').text();
            let quantiteRecu = $(this).find('td:nth-child(4)>div>input').val();
            // on vérifie que le quantite n'est pas vide , null ou négatif
            if (quantiteRecu === null || quantiteRecu === "" || quantiteRecu < 0) {
                alert("La quantité reçue de l'ingrédient " + nom + " est vide.\nVeuillez entrer une valeur ou supprimer l'ingrédient de l'inventaire");
                // on focus l'élément pour que l'utilisateur puisse le modifier
                $(this).find('td:nth-child(4)>div>input').focus();
                error = true;
                return;
            }
            if (quantiteRecu < 0) {
                alert("Le quantité reçue de l'ingrédient " + nom + " est négatif.\nVeuillez entrer une valeur positive ou supprimer l'ingrédient de l'inventaire");
                // on focus l'élément pour que l'utilisateur puisse le modifier
                $(this).find('td:nth-child(4)>div>input').focus();
                error = true;
                return;
            }
            json["ingredients"].push({
                id: id,
                quantite_recu: quantiteRecu
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

                // On retire le bon de commande du select et on met à jour le tableau
                $('#select_bon_commande>option:selected').remove();
                // on met le select sur l'option dont la vue id_bdc = 0
                $("#select_bon_commande option[id_bdc='0']").attr('selected',true);
                mettreAJourFournisseur(0);
                refreshTableau();
            },
            error: function (data) {
                // message dans la console
                console.log('Stock.js - mise à jour stock - error');

                // On notifie l'échec de la mise à jour
                alert("La mise à jour de l'inventaire a échoué");
            }
        });

    }

    $('#bouton_mise_a_jour').on('click', validationFormulaire);
}); 