<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>RecetteEdit.css">

<!-- On ajoute le script associé à la page -->
<script src="<?php echo JS ?>RecetteEdit.js"></script>

<!-- Wrapper (contenu de la page) -->
<div class="padding_default grow">
    <h1 class="titre_bulle"><?= $titre ?></h1>

    <!-- Formulaire pour ajouter/modifier une recette -->
    <form id="form_recette">
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
                        <textarea id="description_recette" name="description_recette" placeholder="Description de la recette" required minlength=1 maxlength=1000><?php if (isset($recetteDescription)) echo $recetteDescription; ?></textarea>
                    </div>
                    <!-- Champ pour le prix de la recette -->
                    <div class="form-input">
                        <label for="prix_recette">Prix <i>(en €)</i></label>
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
                    <table class="tableau" id="tableau_composition">
                        <thead>
                            <tr>
                                <th><!-- Image --></th>
                                <th>Nom</th>
                                <th>Quantité</th>
                                <th>Supplément</th>
                                <th>Prix</th>
                                <th><!-- Bouton actions rapide --></th>
                            </tr>
                            <tr></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <br>Aucun ingrédients<br><br>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr></tr>
                            <tr>
                                <td colspan="6">
                                    <div>
                                        <div>
                                            <!-- Annuler la sélection multiple -->
                                            <button type="button" class="bouton" id="bouton_annuler_selection_multiple" hidden><i class="fa-solid fa-times"></i> Annuler la sélection multiple</button>
                                        </div>

                                        <!-- Ajout d'un ingrédient -->
                                        <div>
                                            <button type="button" class="bouton" id="bouton_ajouter_new_ingredient"><i class="fa-solid fa-carrot"></i> Ajouter un ingrédient</button>
                                            <div id="ajouter_ingredient" hidden>
                                                <select id="select_ajouter_ingredient">

                                                </select>
                                                <button type="button" class="bouton" id="bouton_annuler_ajouter_ingredient"><i class="fa-solid fa-times"></i></button>
                                            </div>
                                        </div>

                                        <div>
                                            <!-- Ajout d'une sélection multiple -->
                                            <button type="button" class="bouton" id="bouton_ajouter_new_selection_multiple"><i class="fa-solid fa-rectangle-list"></i> Ajouter une sélection multiple</button>
                                            <!-- Enregistrer la sélection multiple -->
                                            <button type="button" class="bouton" id="bouton_enregistrer_selection_multiple" hidden><i class="fa-solid fa-check"></i> Enregistrer la sélection multiple</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div id="boutons" class="wrapper main_axe_center">
            <!-- Bouton pour annuler les modifications -->
            <button type="button" id="annuler" class="bouton bouton_secondaire">Annuler</button>

            <!-- Bouton pour enregistrer les modifications -->
            <button type="submit" id="enregistrer" class="bouton bouton_primaire">Enregistrer</button>
        </div>
    </form>
</div>