<link rel="stylesheet" href="<?php echo CSS; ?>Panier.css">
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="<?php echo (JS) ?>Recap.js"></script>






<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre_bulle">Recapitulatif de la Commande</h2>
    </div>

    <div class="conteneur">
        <div class="box_produit">
            <h2 class='titre_fenetre courbe'>Données Personnelles</h2><br>


            <div id="RecupCommande"></div>
            <br>
            <h2 class='titre_fenetre courbe'>Commande</h2><br>

            <div id="Commande"></div>



            <!-- Modification d'un produit existant -->


        </div>
    </div>

</div><br><br>


<script type="text/javascript">
    showData();
</script>