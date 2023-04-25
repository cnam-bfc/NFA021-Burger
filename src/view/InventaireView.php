<div class="wrapper axe_colonne second_axe_center main_axe_space_between grow">

    <h1 class="titre_souligne">Inventaire</h1>

    <div class="width_75">
        <table class="tableau" id="tableau_ingredients">
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
                <tr>
                    <td><img src="<?= IMG . 'ingredient/tomate.png' ?>"></td>
                    <td>Tomate</td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99" step="1" disabled value=10>
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99.99" step="0.01">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <button class="bouton"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><img src="<?= IMG . 'ingredient/salade.png' ?>"></td>
                    <td>Salade</td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99" step="1" disabled value=5>
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99.99" step="0.01">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <button class="bouton"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr></tr>
                <tr>
                    <td colspan="6">
                        <button class="bouton" id="ajouter_ingredient"><i class="fa-solid fa-plus"></i> Ajouter un ingrédient</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="center_items_horizontal">
        <button class="bouton bouton_primaire margin_bottom_top_large">Exporter</button>
    </div>
</div>