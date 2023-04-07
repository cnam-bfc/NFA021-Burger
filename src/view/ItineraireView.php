<!-- Leaflet : Bibliothèque pour intégrer une carte -->
<link rel="stylesheet" href="<?php echo ASSETS ?>leaflet/leaflet.css">
<script src="<?php echo ASSETS ?>leaflet/leaflet.js"></script>
<link rel="stylesheet" href="<?php echo CSS ?>Itineraire.css">
<script src="<?php echo JS ?>Itineraire.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="padding_default grow">
    <h1 class="titre margin_left_right_auto">Itinéraire</h1>

    <div id="map" class="margin_bottom_top_large"></div>

    <div class="wrapper main_axe_space_around">
        <button id="livraisons" class="bouton bouton_primaire margin_left_right_auto">Voir les livraisons</button>
    </div>
</div>