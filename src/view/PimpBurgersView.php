<link rel="stylesheet" href="<?php echo CSS; ?>nicoStyle.css">
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="<?php echo (JS) ?>PimpBurger.js"></script>

<!-- <?php echo IMG; ?> -->


<div class="wrapper axe_colonne text-center">
    <div class="wrapper main_axe_space_around">

        <h3 class="titre titre_margin_top titre_margin_bottom">Vos Ingrédients</h1>


    </div>



    <div id="affichage">

        <div class="wrapper axe_ligne">

            <div class="txt" style="background-color: white;">
                <p>Pain</p>
            </div>
            <div class="fleche" style="background-color: white; "> <img src="<?php echo IMG; ?>Fleches/FlecheCourbeGauche"> </div>
            <div class="centre" style="background-color: white;"><img src="<?php echo IMG; ?>Ingrédients/painMoelleuxHaut.webp"></div>
            <div class="vide"></div>
            <div class="vide"></div>
        </div><!--UnIngredient-->
        <div class="wrapper axe_ligne">


            <div class="vide"></div>
            <div class="vide"></div>
            <div class="centre" style="background-color: white;" class="centerDiv"><img src="<?php echo IMG; ?>Ingrédients/steakTexan.webp"></div>
            <div class="fleche" style="background-color: white;"><img src="<?php echo IMG; ?>Fleches/FlecheCourbeDroite"></div>
            <div class="txt" style="background-color: white;">
                <p>Steak</p>
            </div>
        </div>
        <div class="wrapper axe_ligne">


            <div class="txt" style="background-color: white;">
                <p>Pain Bas</p>
            </div>
            <div class="fleche" style="background-color: white;"> <img src="<?php echo IMG; ?>Fleches/FlecheCourbeGauche"> </div>
            <div class="centre" style="background-color: white;"><img src="<?php echo IMG; ?>Ingrédients/painMoelleuxBas.webp"></div>
            <div class="vide"></div>
            <div class="vide"></div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                console.log("html");
                showData(1);
            });
        </script>

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