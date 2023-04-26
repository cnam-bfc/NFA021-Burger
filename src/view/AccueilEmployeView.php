<link rel="stylesheet" href="<?php echo CSS ?>AccueilEmploye.css">

<div class="wrapper axe_colonne main_axe_space_around margin_auto grow" id="wrapper_accueil">

    <div id="espace_gerant" class="wrapper axe_ligne wrap width_auto height_50 main_axe_space_around margin_bottom_top_large main_axe_center">
        <h1 class="width_100 margin_large bold">Espace Gérant</h1>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/statistiques" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[0]["img"] ?> class='img'>
                <h2 class="bold">Statistiques</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/stock" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[1]["img"] ?> class='img'>
                <h2 class="bold">Stock</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/recettes" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[2]["img"] ?> class='img'>
                <h2 class="bold">Recettes</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/listeproduits" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[3]["img"] ?> class='img'>
                <h2 class="bold">Produits</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/inventaire" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[4]["img"] ?> class='img'>
                <h2 class="bold">Inventaire</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/historique" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[5]["img"] ?> class='img'>
                <h2 class="bold">Historique<br>Commande</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/gerant/listebdc" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[6]["img"] ?> class='img'>
                <h2 class="bold">Bons<br>Commandes</h2>
            </a>
        </div>
    </div>

    <div id="espace_cuisinier" class="wrapper axe_ligne wrap width_auto height_25 main_axe_space_around margin_bottom_top_large main_axe_center">
        <h1 class="width_100 margin_large bold">Espace Cuisinier</h1>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/cuisinier" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[7]["img"] ?> class='img'>
                <h2 class="bold">Prep.<br>Commandes</h2>
            </a>
        </div>
    </div>

    <div id="espace_livreur" class="wrapper axe_ligne wrap width_auto height_100 main_axe_space_around margin_bottom_top_large main_axe_center">
        <h1 class="width_100 margin_large bold">Espace Livreur</h1>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/livreur/livraison" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[8]["img"] ?> class='img'>
                <h2 class="bold">Livraisons</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="http://localhost/NFA021-Burger/public/livreur/itineraire" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <img src=<?php echo $icones[9]["img"] ?> class='img'>
                <h2 class="bold">Trajet</h2>
            </a>
        </div>
    </div>

</div>