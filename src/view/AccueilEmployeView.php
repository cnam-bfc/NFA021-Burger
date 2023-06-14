<link rel="stylesheet" href="<?php echo CSS ?>AccueilEmploye.css">

<script src="<?php echo JS ?>AccueilEmploye.js"></script>

<div class="wrapper axe_colonne main_axe_space_around margin_auto grow" id="wrapper_accueil">
    <?php if ($typeCompte == "gerant") { ?>
    <div id="espace_gerant" class="wrapper axe_ligne wrap width_auto height_50 main_axe_space_around margin_bottom_top_large main_axe_center">
        <h1 class="width_100 margin_large bold">Espace Gérant</h1>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/statistiques" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Statistiques</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/stock" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Stock</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/recettes" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Recettes</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/listeproduits" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Produits</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/inventaire" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Inventaire</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/historique" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Historique<br>Commande</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>gerant/listebdc" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Bons<br>Commandes</h2>
            </a>
        </div>
    </div>
    <?php } ?>
    <?php if ($typeCompte === "cuisinier" || $typeCompte === "gerant") { ?>
    <div id="espace_cuisinier" class="wrapper axe_ligne wrap width_auto height_25 main_axe_space_around margin_bottom_top_large main_axe_center">
        <h1 class="width_100 margin_large bold">Espace Cuisinier</h1>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>cuisinier" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Prep.<br>Commandes</h2>
            </a>
        </div>
    </div>
    <?php } ?>
    <?php if ($typeCompte === "livreur" || $typeCompte === "gerant") { ?>
    <div id="espace_livreur" class="wrapper axe_ligne wrap width_auto height_100 main_axe_space_around margin_bottom_top_large main_axe_center">
        <h1 class="width_100 margin_large bold">Espace Livreur</h1>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>livreur/livraisons" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Livraisons</h2>
            </a>
        </div>
        <div class="box wrapper axe_colonne margin_large main_axe_center second_axe_center">
            <a href="<?php echo PUBLIC_FOLDER ?>livreur/itineraire" class="wrapper wrap axe_colonne main_axe_space_evenly main_axe_center second_axe_center grow">
                <i class="fa-solid fa-display-chart-up"></i>
                <h2 class="bold">Trajet</h2>
            </a>
        </div>
    </div>
    <?php } ?>
</div>

