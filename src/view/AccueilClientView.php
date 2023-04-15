<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>AccueilClient.css">

<!-- On ajoute la feuille de js associé à la page -->
<script src="<?php echo JS ?>AccueilClient.js"></script>

<div class="wrapper axe_colonne" id="wrapper_accueil">
    <img src=<?php echo $backgroundImage ?> class="accueil_margin">
    <div class="wrapper axe_ligne width_80 main_axe_space_between second_axe_center bold margin_auto font_size_large gap_left_right_moyen accueil_margin hidding" id="top_recette">
        <div class="top_recette_accueil_div">
            <img>
            <p></p>
        </div>
        <div class="top_recette_accueil_div">
            <img>
            <p></p>
        </div>
        <div class="top_recette_accueil_div">
            <p></p>
            <img>
        </div>
    </div>
    <div class="wrapper axe_colonne second_axe_center background_primaire accueil_margin">
        <h2 class="color_secondaire bold">Nos restaurants</h2>
        <img src="<?php echo $carte; ?>" id="accueil_map">
    </div>
    <article class="wrapper axe_colonne second_axe_center accueil_margin">
        <h2 class="color_secondaire bold"><?php echo $news["title"]; ?></h2>
        <p class="text-justify"><?php echo $news["message"]; ?></p>
    </article>
</div>