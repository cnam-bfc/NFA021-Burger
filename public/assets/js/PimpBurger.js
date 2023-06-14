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

var indice = 0;
var maxIndice;

var recette;


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
            recette = response;
            console.log("recette");
            console.log(recette);

            //vide la div #affichage
            var affichageDiv = document.getElementById("affichage");
            affichageDiv.innerHTML = "";
            console.log("response");
            console.log(response);
            dataBurger = response;



            /* Boucle qui parcourt le tableau résultat (tableau qui contient les ingrédients à afficher) */
            console.log("response Ajax");
            console.log(response);
            console.log(response[0][1]);
            prix = response[1];

            // je vide le tableau #tbodyModifs
            const tbodyModif = document.getElementById("tbodyMod");
            tbodyModif.innerHTML = "";

            for (var i = 0; i < response[0].length; i++) {
                HTMLFormControlsCollection.log


                afficherCompoBurger(response[0][i], indice);

                afficherTabModifBurger(response[0][i], response[0], indice);

            }
            //afficher le prix ici : 

            var montant = document.getElementById("Montant");
            montant.innerHTML = prix;
            // jusque ici OK
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status !== 0) {
                alert('Erreur ' + jqXHR.status + ' : ' + errorThrown);
                console.log('Erreur ' + jqXHR.status + ' : ' + errorThrown);
            } else {
                alert('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
                console.log('Une erreur inconue est survenue !\nVeuillez vérifier votre connexion internet.');
            }
        }
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////


    //document.getElementById("affichage").removeChild(decompositionBurger.childNodes[4]);
}





//ajout de i en paramètre pour le cas ou l'ingrédient est a selection multiple
function afficherCompoBurger(ingredient, indice) {
    const decompositionBurger = document.getElementById("affichage");


    if (ingredient.selectMultiple == true) {
        maxIndice = ingredient.nom.length;


        // ingredient.nom = JSON.parse(ingredient.nom);
        // ingredient.quantite = JSON.parse(ingredient.quantite);
        // ingredient.unite = JSON.parse(ingredient.unite);
        // ingredient.imgEclatee = JSON.parse(ingredient.imgEclatee);


        //code pour selection multiple
        /*déclaration de mes const pour implémenter ma page de manière générique*/

        const nbElem = decompositionBurger.childNodes.length;
        const div1Ligne = document.createElement("div");
        div1Ligne.className = "wrapper axe_ligne";
        const divTxt = document.createElement("div");
        divTxt.className = "txt";
        const p = document.createElement("p");
        divTxt.appendChild(p);

        p.textContent = ingredient.quantite[indice] + " " + ingredient.unite[indice] + " " + ingredient.nom[indice];



        const divFleche = document.createElement("div");
        divFleche.className = "fleche";
        const divVide = document.createElement("div");
        divVide.className = "vide";
        const divVide2 = document.createElement("div");
        divVide2.className = "vide";

        const divPhoto = document.createElement("div");
        divPhoto.className = "centre";

        const ingrPicture = document.createElement("img");
        ingrPicture.src = ingredient.imgEclatee[indice];
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
            ingrPicture.src = ingredient.imgEclatee[indice];


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
    else {

        /*déclaration de mes const pour implémenter ma page de manière générique*/

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
}


function afficherTabModifBurger(ingredient, response, indice) {

    const tbodyModif = document.getElementById("tbodyMod");

    incrementPourLesInputs++;

    if (ingredient['selectMultiple']) {
        //Déclaration des constantes pour cette function


        const tr = document.createElement("tr");


        const tdImage = document.createElement("td");
        const ingrPicture = document.createElement("img");
        ingrPicture.src = ingredient.imgEclatee[indice];
        tdImage.appendChild(ingrPicture);


        const ingredientNom = ingredient.nom[indice];//
        const tdNom = document.createElement("td");
        tdNom.textContent = ingredientNom;

        const quantiteIngrdient = ingredient.quantite[indice];
        const tdQuantiteIngr = document.createElement("td");//
        const divQuantIngr = document.createElement("div");//
        divQuantIngr.className = "wrapper main_axe_center second_axe_center";
        const inputQuantIngr = document.createElement("input");//
        inputQuantIngr.className = 'quantiteIngr';

        inputQuantIngr.setAttribute('id', 'inputQuantite' + ingredient.nom[indice] + incrementPourLesInputs);
        inputQuantIngr.setAttribute('type', 'text');
        inputQuantIngr.setAttribute('readonly', 'readonly');
        inputQuantIngr.setAttribute('value', quantiteIngrdient + " " + ingredient.unite[indice]);

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
                for (let u = 0; u < nbElem; u++) {
                    // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                    const ligneEnfants = tabBodyModif.childNodes;
                    const elemEnfantsDeLigne = ligneEnfants[u].childNodes;



                    // Bouton
                    const elemBouton = elemEnfantsDeLigne[3];


                    //si la ligne de l'ingrédient a un bouton Retirer

                    if (elemBouton.childNodes[0].textContent == "RETIRER") {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": true
                        }
                        tabNomIngrARemettre.push(argument);

                    } else {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": false
                        }
                        tabNomIngrARemettre.push(argument);
                    }

                }
                console.log(tbodyModif);
                console.log("tabNomIngrARemettre");
                console.log(tabNomIngrARemettre);

                //parcourir le tableau et mettre tous les ingrédients qui ne sont pas à quantite 0;

                //vide la div#affichage
                var affichageDiv = document.getElementById("affichage");
                affichageDiv.innerHTML = "";






                //rempli la div affichage avec les nouvelles données
                for (var i = 0; i < response.length; i++) {


                    if (tabNomIngrARemettre[i]['remettre']) {

                        console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaaa");
                        console.log(response[i]);


                        afficherCompoBurger(response[i], indice);


                    }
                }
            }
            else {


                this.parentNode.parentNode.children[2].children[0].children[0].setAttribute('value', ingredient['quantite'][indice] + " " + ingredient['unite'][indice]);
                this.className = "boutonRetirer";
                this.textContent = "RETIRER";


                const tabBodyModif = document.getElementById("tbodyMod");
                const nbElem = tabBodyModif.childNodes.length;


                //à partir de ça, il faut que j'arrive à metre chaque ingrédient qui un bouton RETIRER, dans le tableau qui suit
                const tabNomIngrARemettre = [];





                //boucle qui parcours donc les lignes de mon tableau tabModifs
                for (let u = 0; u < nbElem; u++) {
                    // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                    const ligneEnfants = tabBodyModif.childNodes;
                    const elemEnfantsDeLigne = ligneEnfants[u].childNodes;



                    // Bouton
                    const elemBouton = elemEnfantsDeLigne[3];


                    //si la ligne de l'ingrédient a un bouton Retirer

                    if (elemBouton.childNodes[0].textContent == "RETIRER") {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": true
                        }
                        tabNomIngrARemettre.push(argument);

                    } else {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": false
                        }
                        tabNomIngrARemettre.push(argument);
                    }

                }
                console.log(tbodyModif);
                console.log("tabNomIngrARemettre");
                console.log(tabNomIngrARemettre);

                //parcourir le tableau et mettre tous les ingrédients qui ne sont pas à quantite 0;

                //vide la div#affichage
                var affichageDiv = document.getElementById("affichage");
                affichageDiv.innerHTML = "";






                //rempli la div affichage avec les nouvelles données
                for (var i = 0; i < response.length; i++) {


                    if (tabNomIngrARemettre[i]['remettre']) {

                        console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaaa");
                        console.log(response[i]);


                        afficherCompoBurger(response[i], indice);


                    }
                }


            };
        });
        tdBouton.appendChild(boutonRetirer);//


        //Créeation du bouton pour swap d'un ingredient à choix multiple à un autre
        var boutonSwap = document.createElement("button");
        boutonSwap.setAttribute("onclick", "swap()");
        boutonSwap.textContent = "SWAP";
        tdImage.appendChild(boutonSwap);

        /*<input class="input" type="number" min="0" max="99" step="1"> */

        //ajout de toute les cellules <td> décrites auparavant, à la ligne <tr> du tableau
        tr.appendChild(tdImage);
        tr.appendChild(tdNom);
        tr.appendChild(tdQuantiteIngr);
        tr.appendChild(tdBouton);
        tbodyModif.appendChild(tr);





        ////ajouter un bouton pour swap entre les aliments échangeables

        //faire l'Event Listener de ce bouton

    }
    else {
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
                for (let u = 0; u < nbElem; u++) {
                    // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                    const ligneEnfants = tabBodyModif.childNodes;
                    const elemEnfantsDeLigne = ligneEnfants[u].childNodes;



                    // Bouton
                    const elemBouton = elemEnfantsDeLigne[3];


                    //si la ligne de l'ingrédient a un bouton Retirer

                    if (elemBouton.childNodes[0].textContent == "RETIRER") {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": true
                        }
                        tabNomIngrARemettre.push(argument);

                    } else {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": false
                        }
                        tabNomIngrARemettre.push(argument);
                    }

                }

                console.log("tabNomIngrARemettre");
                console.log(tabNomIngrARemettre);

                //parcourir le tableau et mettre tous les ingrédients qui ne sont pas à quantite 0;

                //vide la div#affichage
                var affichageDiv = document.getElementById("affichage");
                affichageDiv.innerHTML = "";






                //rempli la div affichage avec les nouvelles données
                for (var i = 0; i < response.length; i++) {


                    if (tabNomIngrARemettre[i]['remettre']) {

                        console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaaa");
                        console.log(response[i]);


                        afficherCompoBurger(response[i], indice);


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
                for (let u = 0; u < nbElem; u++) {
                    // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                    const ligneEnfants = tabBodyModif.childNodes;
                    const elemEnfantsDeLigne = ligneEnfants[u].childNodes;

                    const elemBouton = elemEnfantsDeLigne[3];


                    //si la ligne de l'ingrédient a un bouton Retirer

                    if (elemBouton.childNodes[0].textContent == "RETIRER") {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": true
                        }
                        tabNomIngrARemettre.push(argument);

                    } else {
                        var argument = {
                            "ingredient": elemEnfantsDeLigne[1].textContent,
                            "ordre": u - 1,
                            "remettre": false
                        }
                        tabNomIngrARemettre.push(argument);
                    }

                }

                console.log("tabNomIngrARemettre");
                console.log(tabNomIngrARemettre);

                //parcourir le tableau et mettre tous les ingrédients qui ne sont pas à quantite 0;

                //vide la div#affichage
                var affichageDiv = document.getElementById("affichage");
                affichageDiv.innerHTML = "";



                //rempli la div affichage avec les nouvelles données
                for (var i = 0; i <= response.length; i++) {

                    console.log(tabNomIngrARemettre[i]['remettre']);
                    if (tabNomIngrARemettre[i]['remettre']) {

                        console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaaa");

                        console.log(response[i]);


                        afficherCompoBurger(response[i], indice);
                        console.log(tabNomIngrARemettre[i]['remettre']);

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


    };
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
            for (let u = 0; u < nbElem; u++) {
                // Récupération du nom de l'ingrédient dans une ligne du tableau modif 
                const ligneEnfants = tabBodyModif.childNodes;
                const elemEnfantsDeLigne = ligneEnfants[u].childNodes;


                //nom Ingredient


                // Bouton
                const elemBouton = elemEnfantsDeLigne[3];


                //si la ligne de l'ingrédient a un bouton Retirer

                if (elemBouton.childNodes[0].textContent == "RETIRER") {
                    var element = {
                        "ingredient": elemEnfantsDeLigne[1].textContent,
                        "quantite": elemEnfantsDeLigne[2].children[0].children[0].value

                    }

                    tabIngrFinaux.push(element);
                }


            }

            ///////////////////////////////
            
            const tabBurger = { "prixRecette": prix, "nomRecette": dataBurger[2], "idRecette": idRecette, "ingredientsFinaux": tabIngrFinaux };
            console.log(tabBurger);

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

function swap() {
    if (indice < maxIndice - 1) {
        indice++;
    } else {
        indice = 0;
    }

    var affichageDiv = document.getElementById("affichage");
    var tbodyModif = document.getElementById("tbodyMod");

    affichageDiv.innerHTML = "";
    tbodyModif.innerHTML = "";
    for (var i = 0; i < recette[0].length; i++) {
        afficherCompoBurger(recette[0][i], indice);

        afficherTabModifBurger(recette[0][i], recette[0], indice);
    }

}






