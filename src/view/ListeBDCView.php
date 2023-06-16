<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>ListeBDC.css">
<link rel="stylesheet" href="<?php echo CSS ?>style.css">



<div id="wrapper">

    <div class="padding_default grow">

        <!-- Balise div avec le titre -->
        <div id='box' class="wrapper axe_colonne second_axe_center">
            <h2 class="titre_bulle">Bon de commande</h2>

            <!-- Balise div avec le bouton qui redirige vers la page de création bdc -->
            <div style="display:flex; flex-direction: row">
                <button type="button" class='bouton' onclick="redirigerPageNouveauBdc()">Nouveau Bon de commande</button>
            </div><br>

        </div>

        <!-- Balise div qui va recevoir les bdc -->
        <div class="wrapper axe_ligne second_axe_center wrap" id='bdc'>
        </div>

    </div>

</div><br><br>

<script src="<?php echo JS ?>ListeBDC.js"></script>