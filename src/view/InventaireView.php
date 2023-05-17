<!-- on inclut la feuille de style -->
<link rel="stylesheet" href="<?php echo CSS; ?>Inventaire.css">

<!-- On ajoute la feuille de js associé à la page -->
<script src="<?php echo JS ?>Inventaire.js"></script>

<div class="wrapper axe_colonne second_axe_center main_axe_space_between grow">

    <h1 class="titre_souligne">Inventaire</h1>

    <div class="width_75">
        <table class="tableau" id="tableau_inventaire">
            <thead>
                <tr>
                    <th><!-- Image --></th>
                    <th>Ingrédient</th>
                    <th>Stock</th>
                    <th>Inventaire</th>
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
                        <button class="bouton" id="ajouter_ingredient"><i class="fa-solid fa-plus"></i> Ajouter un ingrédient</button>
                        <div id="ajouter_ingredient_div" hidden>
                            <select id="select_ajouter_ingredient">

                            </select>
                            <button type="button" class="bouton" id="bouton_annuler_ajouter_ingredient"><i class="fa-solid fa-times"></i></button>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="center_items_horizontal">
        <button class="bouton bouton_primaire margin_bottom_top_large" id="bouton_mise_a_jour">Valider</button>
    </div>
</div>