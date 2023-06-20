var panier;

//cette fonction doit lire la variable de session Panier
function showData() {
    const panierDiv = document.getElementById('Panier');
    //panierDiv.innerHTML = sessionStorage.getItem('panier');

    //je créer la variable qui stock la composition du panier


    //ici je récupère la variable de session panier en faisant une requête ajax;

    $.ajax({
        url: "panier/getSessionPanier",
        method: "POST",
        dataType: "JSON",
        success: function (response) {
            console.log("responseGOOD");
            console.log(response);
            panier = response;
            console.log(panier[0]);
            for (var i = 0; i < panier.length; i++) {
                console.log("zzzz");
                
                for (let u = 0; u < panier[i]['ingredientsFinaux'].length; u++) {

                    if ('ordre' in panier[i]['ingredientsFinaux'][u]) {
                        // Sauvegarde de l'ingrédient optionnel
                        let saveOptionnel = panier[i]['ingredientsFinaux'][u];

                        // Sauvegarde de l'ingrédient basique (je vais le mettre à ordre + 1)
                        let saveBasique = panier[i]['ingredientsFinaux'][panier[i]['ingredientsFinaux'][u].ordre - 1];

                        // Mettre les deux éléments à la bonne place
                        panier[i]['ingredientsFinaux'].splice(panier[i]['ingredientsFinaux'][u].ordre - 1, 0, saveOptionnel);
                        panier[i]['ingredientsFinaux'].splice(u + 1, 1);
                    }

                }
                let ordreIngredient = 0;
                for (var u = 0; u < panier[i]['ingredientsFinaux'].length; u++) {
                    console.log(panier[i]['ingredientsFinaux'][u]);
                    if ('ordre' in panier[i]['ingredientsFinaux'][u]) {
                        ++ordreIngredient;
                        console.log(ordreIngredient + " optionnel");
                    };
                    if (!('ordre' in panier[i]['ingredientsFinaux'][u])) {
                        panier[i]['ingredientsFinaux'][u].ordre = ++ordreIngredient;
                        console.log(ordreIngredient + " basique")
                    }
                }
            }
            setPanier(panier);

            
            console.log(panier.length);

            // Appeler la fonction de traitement du panier
            processPanier(panier);
        },
        error: function (xhr, status, error) {
            console.log("Erreur lors de la requête AJAX : " + error);
            console.log(xhr.responseText);
        }
    });
}


// Fonction de traitement du panier
function processPanier(panier) {
    console.log(panier);

    var prixTotal = 0;

    //je créer les élément html qui vont constituer mon panier
    const PanierDiv = document.getElementById("Panier");
    PanierDiv.innerHTML = "";


    // Parcourir le panier pour afficher son contenu
    for (let i = 0; i < panier.length; i++) {

        //je créer les élément html qui vont constituer 1 "Article" dans mon panier
        //Nom de la recette
        const divBurger = document.createElement("div");
        divBurger.setAttribute('id', "Burger");

        //ici il faut créer un tableau
        //1ère Partie du tableau

        // à coté du th1, mettre un bouton supprimer
        const theadBurger = document.createElement("thead");
        const tr1 = document.createElement("tr");
        const th1 = document.createElement("th");
        th1.setAttribute("colspan", 2);
        th1.textContent = panier[i]["nomRecette"];
        tr1.appendChild(th1);
        //le bouton pour supprimer un élément du panier (avec i qui correspond à l'indice de l'élément dans la variable de session['panier'])
        const buttonSupprimer = document.createElement("button");
        buttonSupprimer.setAttribute("id", "SupprimerPanieri" + i);
        buttonSupprimer.setAttribute("onClick", "supprimer('" + "SupprimerPanieri" + i + "')");
        buttonSupprimer.textContent = "Supprimer";
        theadBurger.appendChild(tr1);


        tr1.appendChild(buttonSupprimer);

        //2ème Partie du tableau
        const tbodyBurger = document.createElement("tbody");

        //mettre la Partie 1 et la Partie 2 dans le tableau.

        const tab1Article = document.createElement('table');
        tab1Article.appendChild(theadBurger);
        tab1Article.appendChild(tbodyBurger);


        //Prix
        const divPrix = document.createElement("div");
        divPrix.setAttribute('id', 'Prix');
        divPrix.textContent = panier[i]["prixRecette"] + "€";

        //PrixTotal
        prixTotal = parseFloat(prixTotal);
        prixTotal = parseFloat(prixTotal) + parseFloat(panier[i]["prixRecette"]);

        //arrondir à 2 décimales le prix total
        prixTotal = prixTotal.toFixed(2);

        console.log("panier i")
        console.log(panier[i]);
        //ici une boucle for est nécessaire pour parcourir les ingrédients de la variable de Session['panier']
        if (panier[i]["carteburger"] === true) {
            for (let index = 0; index < panier[i]["ingredientsFinaux"].length; index++) {

                const ingredient = panier[i]["ingredientsFinaux"][index]['nom'];
                const quantite = panier[i]["ingredientsFinaux"][index]['quantite'];

                //je créer la ligne qui contient 1 ingrédient
                const ligneIngr = document.createElement("tr");
                const cellIngr = document.createElement("td");
                const cellNumb = document.createElement("td");
                cellIngr.setAttribute('id', 'Ingredient');
                cellNumb.setAttribute('id', 'Quantite');
                cellIngr.textContent = ingredient;
                cellNumb.textContent = quantite;


                //je mets les 2 cellulles dans la ligne
                ligneIngr.appendChild(cellIngr);
                ligneIngr.appendChild(cellNumb);

                // je mets la ligne dans la 2nde partie du tableau
                tbodyBurger.appendChild(ligneIngr);

            }
        } else {
            for (let index = 0; index < panier[i]["ingredientsFinaux"].length; index++) {

                const ingredient = panier[i]["ingredientsFinaux"][index]['ingredient'];
                const quantite = panier[i]["ingredientsFinaux"][index]['quantite'];

                //je créer la ligne qui contient 1 ingrédient
                const ligneIngr = document.createElement("tr");
                const cellIngr = document.createElement("td");
                const cellNumb = document.createElement("td");
                cellIngr.setAttribute('id', 'Ingredient');
                cellNumb.setAttribute('id', 'Quantite');
                cellIngr.textContent = ingredient;
                cellNumb.textContent = quantite;


                //je mets les 2 cellulles dans la ligne
                ligneIngr.appendChild(cellIngr);
                ligneIngr.appendChild(cellNumb);

                // je mets la ligne dans la 2nde partie du tableau
                tbodyBurger.appendChild(ligneIngr);

            }
        }


        //je constitue ma divBurger
        divBurger.appendChild(tab1Article);
        divBurger.appendChild(divPrix);


        //j'ajoute ma divBurger à la fin du panier
        PanierDiv.appendChild(divBurger);

        console.log("a");
        console.log(panier[i]);

    }
    if (document.getElementById("Total")) {
        document.getElementById("Total").remove();
    }
    const divTotal = document.createElement("div");
    divTotal.setAttribute("id", "Total");
    divTotal.textContent = "Prix Total : " + prixTotal + " €";
    PanierDiv.insertAdjacentElement("afterend", divTotal);
    console.log("divTotal OK");
}


function supprimer(idElem) {

    // je dois récupèrer le dernier caractere de la chaine

    id = idElem.charAt(idElem.length - 1);
    console.log(id);

    //maintenant, dans la variable de session['panier'] ---action---> supprimer $_SESSION['panier'][id];
    //pour ça il faut faire une requête ajax, sans oublier

    $.ajax({
        url: 'panier/SupprimerElemPanier',
        method: 'POST',
        data: {
            idElem: id
        },
        success: function (response) {
            // La requête a réussi, la variable de session a été modifiée côté serveur
            console.log('Variable de session modifiée avec succès');

            panier = JSON.parse(response);
            console.log(panier);
            processPanier(panier);
            var panierIndicateur = document.getElementById("panier_indicateur");
            panierIndicateur.textContent = parseInt(panierIndicateur.textContent) - 1;


        },
        error: function (xhr, status, error) {
            // Une erreur s'est produite lors de la requête
            console.error('Erreur lors de la modification de la variable de session :', error);
        }
    });

}

function commander() {
    //je vérifie si le panier est vide ou non
    if (document.getElementById('Panier').innerHTML === "") {
        console.log("div vide");
        alert("Veuillez Ajouter 1 burger au panier");


    } else {

        // écrire les recettes finals en bdd
        // créer une commande en Bdd
        // amener à la page choix Livraison/Click & Collect
        console.log("div pas vide");

        // Remplacez l'URL par l'adresse de la page recap
        window.location.href = 'collectLivraison';

    }
}

function setPanier(){
    $.ajax({
        url: 'panier/setPanier',
        method: 'POST',
        data: {
            panierFinal: panier
        },
        success: function (response) {
            // La requête a réussi, la variable de session a été modifiée côté serveur
            console.log('Variable de session modifiée avec succès');

            

        },
        error: function (xhr, status, error) {
            // Une erreur s'est produite lors de la requête
            console.error('Erreur lors de la modification de la variable de session :', error);
        }
    });


}


