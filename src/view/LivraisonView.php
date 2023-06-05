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
                    <th>Heure de livraison</th>
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