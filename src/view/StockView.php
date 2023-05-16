<!-- on inclut la feuille de style -->
<link rel="stylesheet" href="<?php echo CSS; ?>Stock.css">

<!-- on inclut la feuille js -->
<script src="<?php echo JS; ?>Stock.js"></script>

<div class="wrapper axe_colonne second_axe_center main_axe_space_between grow">

    <h1 class="titre_souligne">Réception de commande</h1>

    <section class="wrapper axe_colonne second_axe_center main_axe_space_between gap_top_bottom_moyen">
        <div class="wrapper axe_ligne main_axe_center second_axe_center gap_left_right_moyen"> <!-- Bon commande -->
            <label for="bon_de_commande">Bon de commande</label>
            <select name="bon_de_commande" id="select_bon_commande" class="select" required>
            </select>
        </div>
        <div class="wrapper axe_ligne main_axe_center second_axe_center gap_left_right_moyen"> <!-- Fournisseur -->
            <label for="fournisseur">Fournisseur</label>
            <select name="fournisseur" id="select_fournisseur" class="select">
            </select>
        </div>
    </section>

    <hr class="delimitation_trait">

    <section class ="width_75"> <!-- début tableau -->
        <table class="tableau" id="tableau_inventaire">
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
            <tbody id = "test">
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
        <button class="bouton bouton_primaire margin_bottom_top_large" id="bouton_mise_a_jour">Valider</button>
    </div>
</div>