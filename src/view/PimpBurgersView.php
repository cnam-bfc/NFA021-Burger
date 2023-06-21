<link rel="stylesheet" href="<?php echo CSS; ?>VisuBurger.css">
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="<?php echo (JS) ?>PimpBurger.js"></script>

<!-- <?php echo IMG; ?> -->


<div class="wrapper axe_colonne text-center">
    <!-- <script type="text/javascript">
        var chargement = $("<p><i class='fa-solid fa-spinner fa-spin'></i> Chargement des données</p>");
        document.append(chargement);
    </script> -->
    <div id="title" class="wrapper main_axe_space_around">

        <h1 class="titre_souligne titre_margin_top titre_margin_bottom">Vos Ingrédients</h1>
        <p id="descriptif"></p>


    </div>

    <div id="affichage">

    </div><!--Affichage-->



    <div id="ModifsBurgers">




        <!-- ************************* DEBUT - EXEMPLE TABLEAU ************************* -->
        <div class="wrapper axe_colonne second_axe_center" id="modifier">


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

                            <button class="bouton" id="bouton_ajouter_supplement"><i class="fa-solid fa-plus"></i> Ajouter un Supplément</button>
                            <div id="ajouter_ingredient" hidden>
                                <select id="select_ajouter_ingredient">

                                </select>
                                <button type="button" class="bouton" id="bouton_annuler_ajouter_ingredient"><i class="fa-solid fa-times"></i></button>
                            </div>
                        </td>

                    </tr>
                    <tr></tr>
                    <tr>
                        <td colspan="6">
                            <ul id="ulSupp">


                            </ul>

                        </td>
                    </tr>
                </tfoot>
            </table>
        </div><!--#modifier-->
        <!-- ************************* FIN - EXEMPLE TABLEAU ************************* -->


        <!--#supplements-->
    </div><!--#ModifsBurgers-->


    <div id="Paiement">

        <div id="Prix">
            <p id="Montant">
            </p>
            <p>€</p>
        </div>

        <button id="Ajouter" class="animation-grow"> Ajouter au panier</button>
    </div>

</div>

<script type="text/javascript">
    // Récupération des informations de la recette dans l'url
    const url = new URL(window.location.href);
    // Récupération de l'id de la recette
    let idBurger = url.searchParams.get("id");
    $(document).ready(function() {
        console.log("html");
        showData(idBurger);
    });
</script>
<!--#Wrapper-->