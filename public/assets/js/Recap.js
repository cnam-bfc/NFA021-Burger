

var showDataCalled = false;
var infosLivraison;
var panier;

function showData() {
    if (showDataCalled) {
        return Promise.resolve(); // Retourner une promesse résolue si la fonction a déjà été appelée
    }

    showDataCalled = true;

    return new Promise(function (resolve, reject) {
        const panierDiv = document.getElementById('Panier');
        //panierDiv.innerHTML = sessionStorage.getItem('panier');

        //je créer la variable qui stock la composition du panier


        //ici je récupère la variable de session concernant les infos sur la livraison
        var getInfoPromise = new Promise(function (resolve, reject) {
            $.ajax({
                url: "recap/getInfos",
                method: "POST",
                dataType: "JSON",
                success: function (response) {
                    console.log("responseGOODPanierInfos");
                    console.log(response);
                    infosLivraison = response;
                    processLivraison(infosLivraison);

                    // Appeler la fonction de traitement du panier

                    // Réaliser la résolution de la promesse ici avec les paramètres nécessaires
                    resolve(infosLivraison);
                },
                error: function (xhr, status, error) {
                    console.log("Erreur lors de la requête AJAX : " + error);
                    console.log(xhr.responseText);

                    // Rejeter la promesse en cas d'erreur
                    reject(error);
                }
            });
        });

        //ici je récupère la variable de session panier en faisant une requête ajax;
        var getSessionPanierPromise = new Promise(function (resolve, reject) {
            $.ajax({
                url: "panier/getSessionPanier",
                method: "POST",
                dataType: "JSON",
                success: function (response) {
                    console.log("responseGOOD");
                    console.log(response);
                    panier = response;
                    console.log(panier.length);

                    // Appeler la fonction de traitement du panier
                    processPanier(panier);

                    // Réaliser la résolution de la promesse ici avec les paramètres nécessaires
                    resolve(panier);
                },
                error: function (xhr, status, error) {
                    console.log("Erreur lors de la requête AJAX : " + error);
                    console.log(xhr.responseText);

                    // Rejeter la promesse en cas d'erreur
                    reject(error);
                }
            });
        });

        Promise.all([getInfoPromise, getSessionPanierPromise])
            .then(function (data) {
                var infosLivraison = data[0];
                var panier = data[1];
                // Appeler writeBDD() avec les bons paramètres
                writeBDD(infosLivraison, panier);
                resolve();
            })
            .catch(function (error) {
                reject(error);
            });
    });
}








// Fonction de traitement du panier
function processPanier(panier) {
    console.log(panier);
    var prixTotal = 0;

    //je créer les élément html qui vont constituer mon panier
    const PanierDiv = document.getElementById("Commande");



    // Parcourir le panier pour afficher son contenu
    for (let i = 0; i < panier.length; i++) {

        //je créer les élément html qui vont constituer 1 "Article" dans mon panier
        //Nom de la recette
        const divBurger = document.createElement("div");
        divBurger.setAttribute('id', "Burger");

        //ici il faut créer un tableau
        //1ère Partie du tableau


        const theadBurger = document.createElement("thead");
        const tr1 = document.createElement("tr");
        const th1 = document.createElement("th");
        th1.setAttribute("colspan", 2);
        th1.textContent = panier[i]["nomRecette"];
        tr1.appendChild(th1);

        theadBurger.appendChild(tr1);





        //2ème Partie du tableau
        const tbodyBurger = document.createElement("tbody");

        //mettre la Partie 1 et la Partie 2 dans le tableau.

        const tab1Article = document.createElement('table');
        tab1Article.appendChild(theadBurger);
        tab1Article.appendChild(tbodyBurger);


        //Prix
        const divPrix = document.createElement("div");
        divPrix.setAttribute('id', 'Prix');
        divPrix.textContent = panier[i]["prixRecette"] + " €";

        //PrixTotal
        prixTotal = parseFloat(prixTotal);
        prixTotal = parseFloat(prixTotal) + parseFloat(panier[i]["prixRecette"]);
        prixTotal = prixTotal.toFixed(2);



        //ici une boucle for est nécessaire pour parcourir les ingrédients de la variable de Session['panier']
        if (panier[i]["carteburger"] === true) {
            for (let index = 0; index < panier[i]["ingredientsFinaux"].length; index++) {
                if (panier[i]["ingredientsFinaux"][index] === null) {
                    continue;
                } else {
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
    const divTotal = document.createElement("div");
    divTotal.setAttribute("id", "Total");
    divTotal.textContent = "Prix Total : " + prixTotal + " €";
    PanierDiv.appendChild(divTotal);
    console.log("divTotal OK");
}

function processLivraison(infosLivraison) {
    const divRecupInfos = document.getElementById('RecupCommande');



    var div = document.createElement('div');
    var cle;
    var valeur;


    //je convertie l'objet infosLivraison en tableau
    const infosLivraisonTab = Object.keys(infosLivraison).map(key => infosLivraison[key]);

    infosLivraisonTab.forEach((value, index) => {
        const key = Object.keys(infosLivraison)[index];
        console.log("Clé:" + key);
        console.log("Valeur:" + value);
        // Si clé commence par "OSM_", skip
        if (key.startsWith("OSM_")) {
            return;
        }
        const div = document.createElement("div"); // Créer un nouvel élément <div>
        cle = key;
        valeur = value;
        div.setAttribute("id", cle);
        div.textContent = cle + " : " + valeur;
        divRecupInfos.appendChild(div);
    });

    //ecrire en BDD

}

function writeBDD(infosLivraison, panier) {
    console.log("writeBDD");


    console.log(infosLivraison);
    console.log(panier);

    //définition de la date de la commande
    var date = new Date();

    var annee = date.getFullYear();
    var mois = date.getMonth() + 1;
    var jour = date.getDate();
    var heure = date.getHours();
    var minutes = date.getMinutes();
    var secondes = date.getSeconds();

    if (infosLivraison["Mode Récupération"] == "Click & Collect") {
        console.log(1);

        var prix = 0;
        for (let index = 0; index < panier.length; index++) {
            prix += parseFloat(panier[index].prixRecette);
        }
        //doit contenir Heure Retrait / Prix / Date_commande / emballage;
        var tabCommandeClientRetrait = {
            "heure Retrait": infosLivraison["Heure Collect"],
            "prix": prix,
            "emballage": infosLivraison["Emballage"]
        };

        $.ajax({
            url: "recap/writeOnBDD",
            method: "POST",
            dataType: "JSON",
            data: { tabCommandeClientRetrait, panier },
            success: function (response) {
                console.log("responseGOODPanierInfos");
                console.log(response);
                if (response) {
                    alert("Commande passé avec suuccès");
                } else {
                    alert("La commande a échouée");
                }

            },
            error: function (xhr, status, error) {
                console.log("Erreur lors de la requête AJAX : " + error);
                console.log(xhr.responseText);
                alert("La commande a échouée");

            }
        });


    } else {

        //doit contenir heure Livraion / adresse osm type / adress osm id / code postal / ville / rue / numéro voie / prix / date commande / emballage
        var prix = 0;
        for (let index = 0; index < panier.length; index++) {
            prix += parseFloat(panier[index].prixRecette);
        }
        var tabCommandeClientLivraison = {
            "heure Livraison": infosLivraison["Heure"],
            "osm type": infosLivraison["OSM_TYPE"],
            "osm id": infosLivraison["OSM_ID"],
            "code postal": parseInt(infosLivraison["Code Postal"]),
            "ville": infosLivraison["Ville"],
            "rue": infosLivraison["Voie"],
            "numero voie": parseInt(infosLivraison["NumVoie"]),
            "prix": prix,
            "emballage": infosLivraison["Emballage"]

        }
        console.log(tabCommandeClientLivraison);
        $.ajax({
            url: "recap/writeOnBDD",
            method: "POST",
            dataType: "JSON",
            data: { tabCommandeClientLivraison, panier },
            success: function (response) {
                console.log("responseGOODPanierInfos");
                console.log(response);

            },
            error: function (xhr, status, error) {
                console.log("Erreur lors de la requête AJAX : " + error);
                console.log(xhr.responseText);

            }
        });



    }



}

