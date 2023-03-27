<div class="wrapper_colonne" id="wrapper_accueil">
    <img src=<?php echo $backgroundImage?> class="accueil_margin">
    <div class="accueil_margin" id="top_recette">
        <div class="top_recette_accueil_div">
            <img src=<?php echo $topRecette[0]["img"]?>>
            <p><?php echo $topRecette[0]["nom"]?></p>
        </div>
        <div class="top_recette_accueil_div">
            <img src=<?php echo $topRecette[1]["img"]?>>
            <p><?php echo $topRecette[1]["nom"]?></p>
        </div>
        <div class="top_recette_accueil_div">
            <p><?php echo $topRecette[2]["nom"]?></p>
            <img src=<?php echo $topRecette[2]["img"]?>>
        </div>
    </div>
    <div class="wrapper_colonne_center background_primaire accueil_margin">
        <h2 class="color_secondaire bold">Nos restaurants</h2>
        <img src="<?php echo IMG."carte_with_ping_name.png" ?>" id="accueil_map">
    </div>
    <article class="wrapper_colonne_center accueil_margin">
        <h2 class="color_secondaire bold"><?php echo $news["title"];?></h2>
        <p class ="text-justify"><?php echo $news["message"];?></p>
    </article>
</div>