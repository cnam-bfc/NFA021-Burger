<link rel="stylesheet" href="<?php echo CSS; ?>nicoStyle.css">
<!-- <?php echo IMG; ?> -->

<div id="Wrapper">
    <div id="AffichageInfosBurger">
        <div id="titlePage">
            <h1>Vos Ingrédients</h1>
        </div>

    </div>
    <div id="Ingredients">


        <div id="affichage">
            <div class="UnIngredient">

                <div class="div1" style="background-color: white;"> Pain </div>
                <div class="div2" style="background-color: white; "> <img src="<?php echo IMG; ?>Fleches/FlecheCourbeGauche"> </div>
                <div class="div3" style="background-color: white;"><img src="<?php echo IMG; ?>Ingrédients/painMoelleux.webp"></div>
                <div class="div2" style="background-color: white;"></div>
                <div class="div1" style="background-color: white;"></div>
            </div><!--UnIngredient-->
            <div class="UnIngredient">


                <div style="background-color: white;"></div>
                <div style="background-color: white;"></div>
                <div class="div3" style="background-color: white;" class="centerDiv"><img src="<?php echo IMG; ?>Ingrédients/steakTexan.webp"></div>
                <div style="background-color: white;"><img src="<?php echo IMG; ?>Fleches/FlecheCourbeDroite"></div>
                <div style="background-color: white;"> Steak</div>
            </div>
            <div class="UnIngredient">


                <div style="background-color: white;"> Pain Bas </div>
                <div style="background-color: white;"> <img src="<?php echo IMG; ?>Fleches/FlecheCourbeGauche"> </div>
                <div class="div3" style="background-color: white;"><img src="<?php echo IMG; ?>Ingrédients/painMoelleuxBas.webp"></div>
                <div style="background-color: white;"></div>
                <div style="background-color: white;"></div>
            </div>

        </div><!--Affichage-->

        <div id="allergenes">
            <h2 class="zoneTxtGris">Allergènes</h2>

        </div><!--#allergenes-->

        <div id="lesAllergenes">
            <p class="zoneTxtGris">Soja</p>
            <p class="zoneTxtGris">Sésame</p>
            <p class="zoneTxtGris">Oeufs</p>

        </div><!--#lesAllergenes-->


        <div id="ModifsBurgers">

            <div id="modifier">
                <h2 class="zoneTxtGris">Modifier la recette</h2>

            </div>
            <!--#modifier-->
            <h2 class="zoneTxtGris">Ajouter des suppléments</h2>
            <div id="supplements">

            </div>
            <!--#supplements-->
        </div><!--#ModifsBurgers-->
    </div>
    <!--Ingredients-->

    <div id="Paiement">
        <div id="Prix">
            <p>Prix Total
            </p>
            <p>X $</p>
        </div>


        <button> Ajouter au panier</button>
    </div>

</div>
<!--#Wrapper-->