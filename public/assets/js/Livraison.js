$(function () {
    // Récupération des élements du DOM
    const bodyTableauLivraisons = $("#tableau_livraisons tbody");
    const itineraire = $("#iteneraire");

    // Fonction permettant d'ajouter une ligne contenant une livraison dans le tableau des livraisons
    function addLivraison(data) {
        let ligne = $("<tr>");

        // Id
        cellule = $("<td>");
        cellule.text(data.id);
        ligne.append(cellule);

        // Adresse départ
        cellule = $("<td>");
        let adresse = "";
        if (data.adresse_depart.numero !== undefined) {
            adresse += data.adresse_depart.numero + " ";
        }
        adresse += data.adresse_depart.rue + ", " + data.adresse_depart.code_postal + " " + data.adresse_depart.ville;
        cellule.text(adresse);
        // Ajout du lien vers l'itinéraire
        let adresseDepartItineraire = $("<button>").addClass("bouton bouton_itineraire");
        adresseDepartItineraire.attr("title", "Voir l'itinéraire jusqu'au restaurant");
        adresseDepartItineraire.append($("<i>").addClass("fa-solid fa-map-location"));
        adresseDepartItineraire.click(function () {
            // Redirection vers l'itinéraire
            window.location.href = 'itineraire?osm_type=' + data.adresse_depart.osm_type + '&osm_id=' + data.adresse_depart.osm_id;
        });
        cellule.append(adresseDepartItineraire);
        ligne.append(cellule);

        // Adresse arrivée
        cellule = $("<td>");
        adresse = "";
        if (data.adresse_arrivee.numero !== undefined) {
            adresse += data.adresse_arrivee.numero + " ";
        }
        adresse += data.adresse_arrivee.rue + ", " + data.adresse_arrivee.code_postal + " " + data.adresse_arrivee.ville;
        cellule.text(adresse);
        // Ajout du lien vers l'itinéraire
        let adresseArriveeItineraire = $("<button>").addClass("bouton bouton_itineraire");
        adresseArriveeItineraire.attr("title", "Voir l'itinéraire jusqu'à la livraison");
        adresseArriveeItineraire.append($("<i>").addClass("fa-solid fa-map-location"));
        adresseArriveeItineraire.click(function () {
            // Redirection vers l'itinéraire
            window.location.href = 'itineraire?osm_type=' + data.adresse_arrivee.osm_type + '&osm_id=' + data.adresse_arrivee.osm_id;
        });
        cellule.append(adresseArriveeItineraire);
        ligne.append(cellule);

        // Distance
        cellule = $("<td>");
        cellule.html(data.distance + "&nbsp;km");
        ligne.append(cellule);

        // Heure de livraison
        cellule = $("<td>");
        cellule.text(data.heure_livraison);
        ligne.append(cellule);

        // Status
        cellule = $("<td>");
        switch (data.status) {
            case "archive":
                cellule.text("Archivée");
                cellule.css("color", "grey");
                break;
            case "livre":
                cellule.text("Livrée");
                cellule.css("color", "green");
                break;
            case "en_livraison":
                cellule.text("En livraison");
                cellule.css("color", "lightgrey");
                break;
            case "pret":
                cellule.text("Prête");
                cellule.css("color", "blue");
                break;
            case "cuisine":
                cellule.text("En cuisine");
                cellule.css("color", "orange");
                break;
            case "attente":
                cellule.text("En attente");
                cellule.css("color", "purple");
                break;
            default:
                cellule.text("Inconnu");
                cellule.css("color", "black");
                break;
        }
        cellule.css("font-weight", "bold");
        ligne.append(cellule);

        // Client
        cellule = $("<td>");
        cellule.text(data.client.prenom + " " + data.client.nom);
        ligne.append(cellule);

        // Boutons d'action rapide
        cellule = $("<td>");
        // Conteneur des boutons
        let contenuCellule = $("<div>");
        contenuCellule.addClass('wrapper axe_ligne main_axe_center second_axe_center');

        // Bouton 'prendre la livraison'
        let boutonPrendreLivraison = $("<button>").addClass("bouton");
        boutonPrendreLivraison.click(function () {
            let oldBoutonPrendreLivraisonHTML = boutonPrendreLivraison.html();
            // Désactiver le bouton
            boutonPrendreLivraison.prop("disabled", true);
            // Remplacer l'icône par un spinner
            boutonPrendreLivraison.empty();
            boutonPrendreLivraison.append($("<i>").addClass("fa-solid fa-spinner fa-spin"));

            // Envoyer une requête pour prendre la livraison
            $.ajax({
                url: "livraisons/prendre",
                method: "POST",
                data: {
                    id: data.id
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        // Actualiser le tableau des livraisons
                        refreshLivraisons();
                    } else {
                        // Réactiver le bouton
                        boutonPrendreLivraison.prop("disabled", false);
                        // Remplacer le spinner par l'icône
                        boutonPrendreLivraison.empty();
                        boutonPrendreLivraison.html(oldBoutonPrendreLivraisonHTML);
                        // Avertir l'utilisateur
                        alert("Erreur lors de la prise de la livraison :\n" + data.message);
                    }
                },
                error: function (data) {
                    // Réactiver le bouton
                    boutonPrendreLivraison.prop("disabled", false);
                    // Remplacer le spinner par l'icône
                    boutonPrendreLivraison.empty();
                    boutonPrendreLivraison.html(oldBoutonPrendreLivraisonHTML);
                    // Avertir l'utilisateur
                    alert("Erreur lors de la prise de la livraison :\nVous devez être connecté en tant que livreur pour prendre une livraison !");
                }
            });
        });
        // Si la livraison est déjà prise, désactiver le bouton
        if (data.livreur !== undefined) {
            boutonPrendreLivraison.prop("disabled", true);

            // Si la livraison est prise par l'utilisateur, ajouter l'icône de l'utilisateur, son nom et prénom
            boutonPrendreLivraison.append($("<i>").addClass("fa-solid fa-user"));
            boutonPrendreLivraison.append(" " + data.livreur.prenom + " " + data.livreur.nom);
        }
        // Sinon, ajouter l'icône pour prendre la livraison
        else {
            boutonPrendreLivraison.append($("<i>").addClass("fa-solid fa-truck"));
            boutonPrendreLivraison.append(" Prendre la livraison");
        }
        contenuCellule.append(boutonPrendreLivraison);

        cellule.append(contenuCellule);
        ligne.append(cellule);

        // Si la livraison est déjà prise, changer le style de la ligne
        if (data.livreur !== undefined) {
            ligne.addClass("livraison_prise");
        }

        // Ajout de la ligne au tableau
        bodyTableauLivraisons.append(ligne);
    }

    // Fonction permettant d'actualiser le tableau des livraisons
    function refreshLivraisons() {
        // Supprimer le contenu du tableau
        bodyTableauLivraisons.empty();

        // Ajout ligne de chargement
        let ligne = $("<tr>");
        let cellule = $("<td>");
        cellule.attr("colspan", 8);
        cellule.html("<br><i class='fa-solid fa-spinner fa-spin'></i> Chargement des livraisons<br><br>");
        ligne.append(cellule);
        bodyTableauLivraisons.append(ligne);

        // Récupération des livraisons
        $.ajax({
            url: "livraisons/list",
            method: "GET",
            dataType: "json",
            success: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauLivraisons.empty();

                // Si aucune livraison n'a été trouvée, afficher "Aucun résultats"
                if (data['data'].length == 0) {
                    let ligne = $("<tr>");
                    let cellule = $("<td>");
                    cellule.attr("colspan", 8);
                    cellule.html("<br>Aucune livraison n'a été trouvée<br><br>");
                    ligne.append(cellule);
                    bodyTableauLivraisons.append(ligne);
                }
                // Sinon, ajouter chaque livraison dans une nouvelle ligne
                else {
                    data['data'].forEach(element => {
                        addLivraison(element);
                    });
                }
            },
            error: function (data) {
                // Supprimer la ligne de chargement
                bodyTableauLivraisons.empty();

                // Ajout ligne d'erreur
                let ligne = $("<tr>");
                let cellule = $("<td>");
                cellule.attr("colspan", 8);
                cellule.html("<br><i class='fa-solid fa-exclamation-triangle'></i> Erreur lors du chargement des livraisons<br><br>");
                ligne.append(cellule);
                bodyTableauLivraisons.append(ligne);
            }
        });
    }

    // Lorsque l'on appuie sur le bouton de l'itinéraire
    itineraire.click(function () {
        // Ouvrir la page d'itinéraire
        window.location.href = "itineraire";
    });

    // Rafraichir la liste des livraisons
    refreshLivraisons();
});