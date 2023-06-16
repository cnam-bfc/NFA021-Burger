<!-- Leaflet : Bibliothèque pour intégrer une carte -->
<!-- Bibliothèque Leaflet -->
<link rel="stylesheet" href="<?php echo ASSETS ?>leaflet/leaflet.css">
<script src="<?php echo ASSETS ?>leaflet/leaflet.js"></script>

<!-- Bibliothèque Leaflet Routing Machine -->
<link rel="stylesheet" href="<?php echo ASSETS ?>leaflet-routing-machine/leaflet-routing-machine.css">
<script src="<?php echo ASSETS ?>leaflet-routing-machine/leaflet-routing-machine.min.js"></script>

<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>Livraison.css">

<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>Livraison.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="padding_default grow">
    <h1 class="titre_bulle">Livraisons</h1>

    <!-- Tableau des livraisons -->
    <div class="margin_bottom_top_large">
        <table class="tableau" id="tableau_livraisons">
            <thead>
                <tr>
                    <th>Numéro de commande</th>
                    <th>Adresse de départ</th>
                    <th>Adresse de destination</th>
                    <th>Distance</th>
                    <th>Temps de trajet</th>
                    <th>Heure de livraison</th>
                    <th>Status</th>
                    <th>Client</th>
                    <th><!-- Bouton actions rapide --></th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="wrapper main_axe_space_around">
        <button id="iteneraire" class="bouton bouton_primaire">Voir l'itinéraire</button>
    </div>
</div>