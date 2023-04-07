<div class="wrapper grow axe_colonne main_axe_space_around second_axe_center">

<!-- ************************* DEBUT - EXEMPLE TABLEAU ************************* -->
    <div>
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple du tableau générique</h2>
        <!-- Tableau contenant les ingrédients de la recette -->
        <table class="tableau" id="tableau_ingredients">
            <thead>
                <tr>
                    <th><!-- Image --></th>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Optionnel</th>
                    <th>Prix</th>
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
                            <input class="input" type="number" min="0" max="99" step="1">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99.99" step="0.01">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <button class="bouton"><i class="fa-solid fa-arrow-up"></i></button>
                            <button class="bouton"><i class="fa-solid fa-arrow-down"></i></button>
                            <button class="bouton"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><img src="<?= IMG . 'ingredient/salade.png' ?>"></td>
                    <td>Salade</td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99" step="1">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <input class="input" type="number" min="0" max="99.99" step="0.01">
                        </div>
                    </td>
                    <td>
                        <div class="wrapper main_axe_center second_axe_center">
                            <button class="bouton"><i class="fa-solid fa-arrow-up"></i></button>
                            <button class="bouton"><i class="fa-solid fa-arrow-down"></i></button>
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
    <!-- ************************* FIN - EXEMPLE TABLEAU ************************* -->

</div>

<p class="margin_left_right_auto color_primaire">Test</p>