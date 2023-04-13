<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>AccueilClient.css">

<!-- On ajoute la feuille de js associé à la page -->
<script src="<?php echo JS ?>AccueilClient.js"></script>

<div class="wrapper axe_colonne" id="wrapper_accueil">
    <img src=<?php echo $backgroundImage ?> class="accueil_margin">
    <div class="accueil_margin" id="top_recette">
        <?php foreach ($topRecette as $recette) { ?>
            <div class="top_recette_accueil_div">
                <img src=<?php echo $recette["img"] ?>>
                <p><?php echo $recette["nom"] ?></p>
            </div>
        <?php } ?>
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