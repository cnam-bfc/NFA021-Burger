
function showData(BurgerID) {
    console.log(BurgerID + " = BurgerID");
    $.ajax({
        url: "visuModifsBurgers/ingredients",
        method: "POST",
        dataType: "JSON",
        data: { id: BurgerID },
        success: function (response) {


            /* Boucle qui parcourt le tableau résultat (tableau qui contient les ingrédients à afficher) */
            for (var i = 0; i < response.length; i++) {
                afficherCompoBurger(response[i]);
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
    ingrPicture.src = "/NFA021-Burger/public/assets/img/" + ingredient["imgEclatee"];
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
        ingrPicture.src = "/NFA021-Burger/public/assets/img/" + ingredient["imgEclatee"];

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

/*
<div id="affichage">
        
        <div class="wrapper axe_ligne ">
 
            <div class="txt" class="div1" style="background-color: white;">
                <p>Pain</p>
            </div>
            <div class="fleche" style="background-color: white; "> <img src="<?php echo IMG; ?>Fleches/FlecheCourbeGauche"> </div>
            <div class="centre" style="background-color: white;"><img src="<?php echo IMG; ?>Ingrédients/painMoelleux.webp"></div>
            <div class="vide"></div>
            <div class="vide"></div>
        </div><!--UnIngredient-->
        <div class="wrapper axe_ligne "></div>
*/



