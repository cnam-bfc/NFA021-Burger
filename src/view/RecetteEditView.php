<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>RecetteEdit.css">

<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>RecetteEdit.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="padding_default grow">
    <h1 class="titre margin_left_right_auto"><?= $titre ?></h1>

    <!-- Ligne contenant les informations générales et la composition de la recette -->
    <div id="boxs" class="wrapper axe_ligne wrap margin_bottom_top_large">
        <!-- Box informations générales -->
        <div class="box" id="informations_generales">
            <h2 class="box_titre">Informations générales</h2>
            <div class="box_contenu">
                <!-- Champ pour le nom de la recette -->
                <div class="form-input">
                    <label for="nom_recette">Nom</label>
                    <input type="text" id="nom_recette" name="nom_recette" placeholder="Nom de la recette" <?php if (isset($recetteNom)) echo 'value=' . json_encode($recetteNom); ?> required>
                </div>
                <!-- Champ pour la description de la recette -->
                <div class="form-input">
                    <label for="description_recette">Description</label>
                    <textarea id="description_recette" name="description_recette" placeholder="Description de la recette" required minlength=1 maxlength=250><?php if (isset($recetteDescription)) echo $recetteDescription; ?></textarea>
                </div>
                <!-- Champ pour le prix de la recette -->
                <div class="form-input">
                    <label for="prix_recette">Prix</label>
                    <input type="number" min="0" step="0.01" id="prix_recette" name="prix_recette" placeholder="Prix de la recette" <?php if (isset($recettePrix)) echo 'value=' . json_encode($recettePrix); ?> required>
                </div>
                <!-- Champ pour l'image de la recette -->
                <div class="form-input">
                    <label for="image_recette">Image</label>
                    <?php if (isset($recetteImage)) echo '<img src="' . $recetteImage . '" id="image_recette_preview">'; ?>
                    <input type="file" id="image_recette" name="image_recette" accept="image/*" <?php if (!isset($recetteImage)) echo 'required' ?>>
                </div>
            </div>
        </div>

        <!-- Box composition de la recette -->
        <div class="box" id="composition">
            <h2 class="box_titre">Composition</h2>
            <div class="box_contenu">
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
                                    <button class="bouton" disabled><i class="fa-solid fa-arrow-up"></i></button>
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
                        <tr>
                            <td><img src="<?= IMG . 'ingredient/steak.png' ?>"></td>
                            <td>Steak</td>
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
                            <td><img src="<?= IMG . 'ingredient/ketchup.png' ?>"></td>
                            <td>Ketchup</td>
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
                                    <button class="bouton" disabled><i class="fa-solid fa-arrow-down"></i></button>
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
        </div>
    </div>

    <div class="wrapper main_axe_space_around">
        <button id="enregistrer" class="bouton bouton_primaire">Enregistrer</button>
    </div>
</div>