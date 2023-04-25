<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>Recette.css">

<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>Recette.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="padding_default grow">
    <h1 class="titre_bulle">Recettes</h1>

    <!-- Tableau des recettes -->
    <div class="margin_bottom_top_large">
        <table class="tableau" id="tableau_recettes">
            <thead>
                <tr>
                    <th><!-- Image --></th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Ingrédients</th>
                    <th>Prix</th>
                    <th><!-- Bouton actions rapide --></th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr></tr>
                <tr>
                    <td colspan="6">
                        <button class="bouton" id="ajouter_recette"><i class="fa-solid fa-plus"></i> Ajouter une recette</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>