<link rel="stylesheet" href="<?php echo CSS; ?>VisuBurger.css">
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="<?php echo (JS) ?>PimpBurger.js"></script>

<!-- <?php echo IMG; ?> -->


<div class="wrapper axe_colonne text-center">
    <div class="wrapper main_axe_space_around">

        <h3 class="titre titre_margin_top titre_margin_bottom">Vos Ingrédients</h1>


    </div>



    <div id="affichage">



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




        <!-- ************************* DEBUT - EXEMPLE TABLEAU ************************* -->
        <div class="wrapper axe_colonne second_axe_center" id="modifier">
            <h2 class="zoneTxtGris">Modifier la recette</h2>

            <!-- Tableau contenant les ingrédients de la recette -->
            <table class="tableau">
                <thead>
                    <tr>
                        <th><!-- Image --></th>
                        <th>ingrédient</th>
                        <th>Quantité</th>
                        <th><!-- Bouton actions rapide --></th>
                    </tr>
                    <tr></tr>
                </thead>
                <tbody id="tbodyMod">

                </tbody>
                <tfoot>
                    <tr></tr>
                    <tr>
                        <td colspan="6">
                            <button class="bouton" id="ajouter_ingredient"><i class="fa-solid fa-plus"></i> Ajouter un ingrédient</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div><!--#modifier-->
        <!-- ************************* FIN - EXEMPLE TABLEAU ************************* -->





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


        <button id="Ajouter"> Ajouter au panier</button>
    </div>

</div>
<!--#Wrapper-->