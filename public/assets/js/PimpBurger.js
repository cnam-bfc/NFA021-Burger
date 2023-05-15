
function showData(BurgerID) {
    console.log(BurgerID + " = BurgerID");
    $.ajax({
        url: "visuModifsBurgers/ingredients",
        method: "POST",
        dataType: "JSON",
        data: { id: BurgerID },
        success: function (response) {
            //vide la div #affichage
            var affichageDiv = document.getElementById("affichage");
            affichageDiv.innerHTML = "";



            /* Boucle qui parcourt le tableau résultat (tableau qui contient les ingrédients à afficher) */

            for (var i = 0; i < response.length; i++) {
                afficherCompoBurger(response[i]);
                afficherTabModifBurger(response[i], response);
            }
            /*var id = $(response).find("table #votre_id").attr("id");
            console.log(id);
            */
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
    p.textContent = ingredient["nom"];



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
        fleche.src = "/NFA021-Burger/public/assets/img/Fleches/FlecheCourbeGauche";
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
        fleche.src = "/NFA021-Burger/public/assets/img/Fleches/FlecheCourbeDroite";
        divFleche.appendChild(fleche);
        lastLine.appendChild(divFleche);

        // Ajouter le texte contenant le nom de l'ingrédient
        lastLine.appendChild(divTxt);


    }
}


function afficherTabModifBurger(ingredient, response) {

    const tbodyModif = document.getElementById("tbodyMod");

    //Déclaration des constantes pour cette function

    const quantite = ingredient["quantite"];


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
    inputQuantIngr.setAttribute('id', 'inputQuantite' + ingredient["nom"]);
    inputQuantIngr.setAttribute('type', 'text');
    inputQuantIngr.setAttribute('readonly', 'readonly');
    inputQuantIngr.setAttribute('value', ingredient['quantite']);
    divQuantIngr.appendChild(inputQuantIngr);// ici on insert les éléments les uns dans les autres, en partant de la fin
    tdQuantiteIngr.appendChild(divQuantIngr);


    //bouton
    const tdBouton = document.createElement("td");
    const boutonRetirer = document.createElement("button");
    boutonRetirer.className = 'boutonRetirer';
    boutonRetirer.textContent = "RETIRER";
    boutonRetirer.addEventListener("click", function () {

        if (this.textContent == "RETIRER") {
            document.getElementById('inputQuantite' + ingredient['nom']).setAttribute("value", "0");
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
            /////////////////////////////////////////////////////////////////////////////////////////////
            //vide la div#affichage
            var affichageDiv = document.getElementById("affichage");
            affichageDiv.innerHTML = "";
            console.log("div affichage");
            console.log(affichageDiv.childNodes);

            //rempli la div affichage avec les nouvelles données
            for (var i = 0; i < response.length; i++) {
                if (tabNomIngrARemettre.includes(response[i]["nom"])) {
                    afficherCompoBurger(response[i]);
                }


            }
        }
        else {
            document.getElementById('inputQuantite' + ingredient['nom']).setAttribute("value", ingredient['quantite']);
            this.className = "boutonRetirer";
            this.textContent = "RETIRER";
            document.getElementsByClassName('boutonRemettre');

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




