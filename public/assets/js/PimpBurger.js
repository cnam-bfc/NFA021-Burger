/* Variable Prix :  
je déclare cette varibale ici pour la définir dans la function showData(BurgerID) et qu'elle soit accessible dans tout le code
car je l'utilise dans la fonction showData et dans un Event Listener qui n'est pas dans cette fonction (pour le bouton Ajout au Panier)*/
var prix;
/*
Variable dataBurger : 
je déclare cette variable pour lui donné une valeur qui provient d'une requête Ajax
dans la fonction showData et la réutiliser dans l'eventListener de cet élément "document.getElementById("Ajouter");"/
*/
var dataBurger;


var idRecette;

var incrementPourLesInputs = 0;


function showData(BurgerID) {
    let chargement = $("<p><i class='fa-solid fa-spinner fa-spin'></i> Chargement des données</p>");
    $('#affichage').append(chargement);

    idRecette = BurgerID;
    //console.log(BurgerID + " = BurgerID");
    $.ajax({
        url: "visuModifsBurgers/ingredients",
        method: "POST",
        dataType: "JSON",
        data: { id: BurgerID },
        success: function (response) {
            //vide la div #affichage
            var affichageDiv = document.getElementById("affichage");
            affichageDiv.innerHTML = "";
            console.log("succes");
            dataBurger = response;



            /* Boucle qui parcourt le tableau résultat (tableau qui contient les ingrédients à afficher) */
            console.log("response Ajax");
            console.log(response);
            console.log(response[0][1]);
            prix = response[0][1];
            console.log(prix);
            for (var i = 0; i < response[0][0].length; i++) {


                afficherCompoBurger(response[0][0][i]);

                afficherTabModifBurger(response[0][0][i], response[0][0]);
            }
            //afficher le prix ici : 

            var montant = document.getElementById("Montant");
            montant.innerHTML = prix;
            // jusque ici OK
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status !== 0) {
                alert('Erreur ' + jqXHR.status + ' : ' + errorThrown);
            } else {
                alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
            }
        }
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////


    //document.getElementById("affichage").removeChild(decompositionBurger.childNodes[4]);
}






function afficherCompoBurger(ingredient) {

    /*déclaration de mes const pour implémenter ma page de manière générique*/
    const decompositionBurger = document.getElementById("affichage");
    const nbElem = decompositionBurger.childNodes.length;
    const div1Ligne = document.createElement("div");
    div1Ligne.className = "wrapper axe_ligne";
    const divTxt = document.createElement("div");
    divTxt.className = "txt";
    const p = document.createElement("p");
    divTxt.appendChild(p);
    p.textContent = ingredient["quantite"] + " " + ingredient['unite'] + " " + ingredient["nom"];



    const divFleche = document.createElement("div");
    divFleche.className = "fleche";
    const divVide = document.createElement("div");
    divVide.className = "vide";
    const divVide2 = document.createElement("div");
    divVide2.className = "vide";

    const divPhoto = document.createElement("div");
    divPhoto.className = "centre";

    const ingrPicture = document.createElement("img");
    ingrPicture.src = ingredient["imgEclatee"];
    divPhoto.appendChild(ingrPicture);

    /* fin de déclaration  des variables*/
    if (nbElem % 2 == 0) {
        // Ajouter une nouvelle ligne pour les ingrédients pairs
        decompositionBurger.appendChild(div1Ligne);
        const lastLine = decompositionBurger.lastChild;

        // Ajouter le texte contenant le nom de l'ingrédient
        lastLine.appendChild(divTxt);


        // Ajouter la flèche courbée vers la gauche
        const fleche = document.createElement("img");
        fleche.src = ingredient['flecheGauche'];
        divFleche.appendChild(fleche);
        lastLine.appendChild(divFleche);

        // Ajouter la photo de l'ingrédient
        lastLine.appendChild(divPhoto);


        // ingrPicture.src = "<?php echo IMG; ?>......";

        // Ajouter deux div vides pour aligner les ingrédients
        lastLine.appendChild(divVide);
        lastLine.appendChild(divVide2);
    } else {
        // Ajouter une nouvelle ligne pour les ingrédients impairs
        decompositionBurger.appendChild(div1Ligne);
        const lastLine = decompositionBurger.lastChild;

        // Ajouter deux div vides pour aligner les ingrédients
        lastLine.appendChild(divVide);
        lastLine.appendChild(divVide2);

        // Ajouter la photo de l'ingrédient
        lastLine.appendChild(divPhoto);
        const ingrPicture = document.createElement("img");
        ingrPicture.src = ingredient["imgEclatee"];

        // ingrPicture.src = "<?php echo IMG; ?>....";

        // Ajouter la flèche courbée vers la droite
        const fleche = document.createElement("img");
        fleche.src = ingredient['flecheDroite'];
        divFleche.appendChild(fleche);
        lastLine.appendChild(divFleche);

        // Ajouter le texte contenant le nom de l'ingrédient
        lastLine.appendChild(divTxt);


    }
}


function afficherTabModifBurger(ingredient, response) {
    incrementPourLesInputs++;

    const tbodyModif = document.getElementById("tbodyMod");

    //Déclaration des constantes pour cette function


    const tr = document.createElement("tr");


    const tdImage = document.createElement("td");
    const ingrPicture = document.createElement("img");
    ingrPicture.src = ingredient["imgEclatee"];
    tdImage.appendChild(ingrPicture);


    const ingredientNom = ingredient["nom"];//
    const tdNom = document.createElement("td");
    tdNom.textContent = ingredientNom;

    const quantiteIngrdient = ingredient["quantite"];
    const tdQuantiteIngr = document.createElement("td");//
    const divQuantIngr = document.createElement("div");//
    divQuantIngr.className = "wrapper main_axe_center second_axe_center";
    const inputQuantIngr = document.createElement("input");//
    inputQuantIngr.className = 'quantiteIngr';

    inputQuantIngr.setAttribute('id', 'inputQuantite' + ingredient["nom"] + incrementPourLesInputs);
    inputQuantIngr.setAttribute('type', 'text');
    inputQuantIngr.setAttribute('readonly', 'readonly');
    inputQuantIngr.setAttribute('value', quantiteIngrdient + " " + ingredient['unite']);

    divQuantIngr.appendChild(inputQuantIngr);// ici on insert les éléments les uns dans les autres, en partant de la fin
    tdQuantiteIngr.appendChild(divQuantIngr);


    //bouton
    const tdBouton = document.createElement("td");
    const boutonRetirer = document.createElement("button");
    boutonRetirer.className = 'boutonRetirer';
    boutonRetirer.textContent = "RETIRER";

    //EVENT LISTENER SUR LE BOUTON REMETTRE/RETIRER
    boutonRetirer.addEventListener("click", function () {


        if (this.textContent == "RETIRER") {
            ///////////////////////////////////////
            console.log(this.parentNode.parentNode.children[2].children[0].children[0]);
            this.parentNode.parentNode.children[2].children[0].children[0].setAttribute('value', 0);

            this.className = "boutonRemettre";
            this.textContent = "REMETTRE";



            const tabBodyModif = document.getElementById("tbodyMod");
            const nbElem = tabBodyModif.childNodes.length;


            //à partir de ça, il faut que j'arrive à metre chaque ingrédient qui un bouton RETIRER, dans le tableau qui suit
            const tabNomIngrARemettre = [];





            //boucle qui parcours donc les lignes de mon tableau tabModifs
            for (let index = 1; index < nbElem; index++) {
                // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                const ligneEnfants = tabBodyModif.childNodes;
                const elemEnfantsDeLigne = ligneEnfants[index].childNodes;
                console.log("tabModifs 1 ligne");
                console.log(elemEnfantsDeLigne);

                //nom Ingredient
                console.log(elemEnfantsDeLigne[1].textContent);
                console.log(elemEnfantsDeLigne);

                // Bouton
                const elemBouton = elemEnfantsDeLigne[3];


                //si la ligne de l'ingrédient a un bouton Retirer

                if (elemBouton.childNodes[0].textContent == "RETIRER") {
                    tabNomIngrARemettre.push(elemEnfantsDeLigne[1].textContent);


                    for (var q = 0; q < elemEnfantsDeLigne[2].firstChild.firstChild.value; q++) {
                        tabNomIngrARemettre.push(elemEnfantsDeLigne[1].textContent);
                        console.log("quantite truc : ")
                        console.log(elemEnfantsDeLigne[1].firstChild.textContent)

                        console.log(elemEnfantsDeLigne[2].firstChild.firstChild.value);

                    }
                }


            }
            console.log("tabIngrédients à remettre");
            console.log(tabNomIngrARemettre); //// CE TABLEAU EST OK

            //parcourir le tableau et mettre tous les ingrédients qui ne sont pas à quantite 0;
            /////////////////////////////////////////////////////////////////////////////////////////////
            //vide la div#affichage

            var affichageDiv = document.getElementById("affichage");
            affichageDiv.innerHTML = "";
            console.log("div affichage");
            console.log(affichageDiv.childNodes);


            //rempli la div affichage avec les nouvelles données
            console.log("response ligne 265");
            console.log(response);
            for (var i = 0; i < response.length; i++) {

                //if (tabNomIngrARemettre.includes(response[i]["nom"])) {
                if (tabNomIngrARemettre.includes(response[i]["nom"])) {


                    afficherCompoBurger(response[i]);
                }


            }
        }
        else {


            this.parentNode.parentNode.children[2].children[0].children[0].setAttribute('value', ingredient['quantite'] + " " + ingredient['unite']);
            this.className = "boutonRetirer";
            this.textContent = "RETIRER";


            //je vide ala div affichage pour ensuite la re-remplir avec les ingredient qui ont une quantité !=0 
            $("affichage").empty();

            //à partir de ça, il faut que j'arrive à metre chaque ingrédient qui un bouton Remmettre, dans la boucle for qui suit.
            const tabNomIngrARemettre = [];
            //variables qui vont me permettre de faire ça
            const tabBodyModif = document.getElementById("tbodyMod");
            const nbElem = tabBodyModif.childNodes.length;


            //boucle qui parcours donc les lignes de mon tableau
            for (let index = 1; index < nbElem; index++) {
                // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                const ligneEnfants = tabBodyModif.childNodes;
                const elemEnfantsDeLigne = ligneEnfants[index].childNodes;
                console.log("tabModifs 1 ligne");
                console.log(elemEnfantsDeLigne);
                console.log(elemEnfantsDeLigne[1].textContent); //nom Ingredient
                console.log(elemEnfantsDeLigne);
                const elemBouton = elemEnfantsDeLigne[3];
                console.log('elemBouton');
                console.log(elemBouton);

                //si la ligne de l'ingrédient a un bouton Retirer

                if (elemBouton.childNodes[0].textContent == "RETIRER")
                    tabNomIngrARemettre.push(elemEnfantsDeLigne[1].textContent);


            }
            console.log(tabNomIngrARemettre);

            //parcourir le tableau et mettre tous les ingrédients qui ne sont pas à quantite 0;

            //vide la div#affichage
            var affichageDiv = document.getElementById("affichage");
            affichageDiv.innerHTML = "";

            //rempli la div affichage avec les nouvelles données
            for (var i = 0; i < response.length; i++) {
                if (tabNomIngrARemettre.includes(response[i]["nom"])) {

                    afficherCompoBurger(response[i]);

                }

            }


        };
    });
    tdBouton.appendChild(boutonRetirer);//

    /*<input class="input" type="number" min="0" max="99" step="1"> */

    //ajout de toute les cellules <td> décrites auparavant, à la ligne <tr> du tableau
    tr.appendChild(tdImage);
    tr.appendChild(tdNom);
    tr.appendChild(tdQuantiteIngr);
    tr.appendChild(tdBouton);
    tbodyModif.appendChild(tr);


}




$(document).ready(function () {





    const boutonAjoutPanier = document.getElementById("Ajouter");
    boutonAjoutPanier.addEventListener("click", function () {

        //Empecher l'ajout au panier d'un burger dont tous les ingrédients ont été supprimé
        //////////////////////
        var sumValue = 0;


        var elements = document.getElementsByClassName('quantiteIngr');
        // Sélection des éléments dont l'ID commence par "inputIngrédient"
        for (var i = 0; i < elements.length; i++) {
            // Faites quelque chose avec chaque élément
            sumValue += parseInt(elements[i].value);

        }

        //avec une boucle if on vérifie que sumValue est différent de zéro :
        if (sumValue !== 0) {



            ///////////////////

            const tabBodyModif = document.getElementById("tbodyMod");
            const nbElem = tabBodyModif.childNodes.length;


            //à partir de ça, il faut que j'arrive à metre chaque ingrédient qui un bouton RETIRER, dans le tableau qui suit
            const tabIngrFinaux = [];


            //boucle qui parcours donc les lignes de mon tableau tabModifs
            for (let index = 1; index < nbElem; index++) {
                // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                const ligneEnfants = tabBodyModif.childNodes;
                const elemEnfantsDeLigne = ligneEnfants[index].childNodes;
                console.log("tabModifs 1 ligne");
                console.log(elemEnfantsDeLigne);

                //nom Ingredient
                console.log(elemEnfantsDeLigne[1].textContent);
                console.log(elemEnfantsDeLigne);

                // Bouton
                const elemBouton = elemEnfantsDeLigne[3];


                //si la ligne de l'ingrédient a un bouton Retirer

                if (elemBouton.childNodes[0].textContent == "RETIRER") {

                    if (!tabIngrFinaux.includes(elemEnfantsDeLigne[1].textContent))
                        tabIngrFinaux.push(elemEnfantsDeLigne[1].textContent, elemEnfantsDeLigne[2].firstChild.firstChild.value);

                }


            }
            console.log(dataBurger);
            console.log("tab Ingrédients Finaux")
            console.log(tabIngrFinaux); //// CE TABLEAU EST OK
            ///////////////////////////////
            const tabBurger = { "prixRecette": prix, "nomRecette": dataBurger[0][2], "idRecette": idRecette, "ingredientsFinaux": tabIngrFinaux };
            console.log("prix est = " + prix);
            console.log(dataBurger[0][2]);

            //Le tableau tabBurger est plein
            //Je l'envoie dans une requête Ajax pour qu'il soit incrémente la variable de session "Panier" (qui est un tableau)


            $.ajax({
                url: "visuModifsBurgers/ajouterAuPanier",
                method: "POST",
                dataType: "JSON",
                data: { burgerAjoute: tabBurger },
                success: function (response) {

                    console.log(response);
                    //modification de l'indicateur du nombre d'éléments dans le panier
                    document.getElementById('panier_indicateur').textContent = response.length;

                },
                error: function (xhr, status, error) {
                    console.log("Erreur lors de la requête AJAX : " + error);
                    console.log(xhr.responseText);
                }
            });

        }
    });
})

//requête pour mettre à jour l'indicateur du bouton panier concernant le nombre d'éléments dans le panier
$.ajax({
    url: "panier/getSessionPanier",
    method: "POST",
    dataType: "JSON",
    success: function (response) {
        console.log("responseGOOD");

        if (response.length != 0) {
            document.getElementById('panier_indicateur').textContent = response.length;
        } else {
            document.getElementById('panier_indicateur').textContent = "";
        };
    },
    error: function (xhr, status, error) {
        console.log("Erreur lors de la requête AJAX : " + error);
        console.log(xhr.responseText);
    }

});






