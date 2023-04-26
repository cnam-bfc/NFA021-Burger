function showData(BurgerID) {
    $.ajax({
        url: "visuModifsBurgers/ingredients",
        method: "POST",
        dataType: JSON,
        data: { id: BurgerID },
        success: function (response) {
            console.log("avantJson");
            console.log(response);
            console.log("aprèsJson");

            /*Boucle qui parcoutrs le tableau résultat (tableau qui contient les ingrédients à afficher) */
            for (var i = 0; i < response.length; i++) {
                afficherCompoBurger(response[i]);
            }
            /*var id = $(response).find("table #votre_id").attr("id");
            console.log(id);
            */
        }
    });

}

const decompositionBurger = document.getElementById("affichage");
function afficherCompoBurger(ingredient) {
    /*Déclaration de mes variables */
    var nbElem = decompositionBurger.childNodes.length;
    var div1Ligne = document.createElement("div").className = "wrapper axe_ligne";
    var divTxt = document.createElement("div").className = "txt";
    var divFleche = document.createElement("div").className = "Fleche";
    var divVide = document.createElement("div").className = "vide";
    var divPhoto = document.createElement("div").className = "centre";

    if (nbElem % 2 == 0) { /*Si il y a un nombre d'ingrédients paire déjà affiché */
        decompositionBurger.appendChild(div1Ligne);
        var lastLine = decompositionBurger.lastChild;

        /*Ajout de texte quin contient le nom de l'ingrédient */
        lastLine.appendChild(divTxt);

        /*Ajout de la flèche */
        var fleche = document.createElement("img");
        fleche.src = "<?php echo IMG; ?>Fleches/FlecheCourbeGauche"; /* */
        lastLine.appendChild(divFleche).appendChild(fleche);

        /*Ajout de la photo de l'ingrédient */
        lastLine.appendChild(divPhoto);
        var ingrPicture = document.createElement("img");
        /*ingrPicture.src = "<?php echo IMG; ?>......"; */


        lastLine.appendChild(divVide);
        lastLine.appendChild(divVide);


    } else { /*Si il y a un nombre d'ingrédients impaire déjà affiché */
        decompositionBurger.appendChild(div1Ligne);
        var lastLine = decompositionBurger.lastChild;
        lastLine.appendChild(divVide);
        lastLine.appendChild(divVide);

        /*Ajout de la photo de l'ingrédient */
        lastLine.appendChild(divPhoto);
        var ingrPicture = document.createElement("img");
        /*ingrPicture.src = "<?php echo IMG; ?>....";*/

        /*Ajout de la flèche */
        var fleche = document.createElement("img");
        fleche.src = "<?php echo IMG; ?>Fleches/FlecheCourbeDroite";
        lastLine.appendChild(divFleche).appendChild(fleche);

        /*Ajout de texte quin contient le nom de l'ingrédient */
        lastLine.appendChild(divTxt);

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

}

