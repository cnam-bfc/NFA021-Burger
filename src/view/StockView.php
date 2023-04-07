<!-- on inclut la feuille de style -->
<link rel="stylesheet" href="<?php echo CSS; ?>Stock.css">

<div class="wrapper axe_colonne second_axe_center main_axe_space_between grow">

    <h1 class="titre_souligne">Réception de commande</h1>

    <section class="wrapper axe_colonne second_axe_center main_axe_space_between">
        <div> <!-- Bon commande -->
            <label for="bon_de_commande">Bon de commande</label>
            <select name="bon_de_commande" id="bon_de_commande" required>
                <option value="0">Choisir un bon de commande</option>
                <option value="1">BDC 1</option>
                <option value="2">BDC 2</option>
                <option value="3">BDC 3</option>
            </select>
        </div>
        <div id="" class="hidding"> <!-- Fournisseur -->
            <label for="fournisseur">Fournisseur</label>
            <select name="fournisseur" id="fournisseur">
                <option value="0">Choisir un fournisseur</option>
                <option value="1">Fournisseur 1</option>
                <option value="2">Fournisseur 2</option>
                <option value="3">Fournisseur 3</option>
            </select>
        </div>
    </section>

    <hr class="delimitation_trait">

    <section class ="width_75"> <!-- début tableau -->
        <table class="tableau" id="tableau_ingredients">
            <thead>
                <tr>
                    <th><!-- Image --></th>
                    <th>Ingrédient</th>
                    <th>Quantité attendue</th>
                    <th>Quantité reçu</th>
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
    </section> <!-- Fin tableau -->

    <div class="center_items_horizontal">
        <button class="bouton bouton_primaire margin_bottom_top_large">Exporter</button>
    </div>
</div>