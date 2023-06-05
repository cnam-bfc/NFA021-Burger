<div class="padding_default grow">
    <!-- ************************* DEBUT - EXEMPLE TITRE BULLE ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple de titre générique (Titre bulle)</h2>
        <h2 class="titre_bulle">Exemple</h2>
    </div>
    <!-- ************************* FIN - EXEMPLE TITRE BULLE ************************* -->

    <hr>

    <!-- ************************* DEBUT - EXEMPLE TITRE SOULIGNÉ ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple de titre générique (Titre souligné)</h2>
        <h2 class="titre_souligne">Exemple</h2>
    </div>
    <!-- ************************* FIN - EXEMPLE TITRE SOULIGNÉ ************************* -->

    <hr>

    <!-- ************************* DEBUT - EXEMPLE TABLEAU ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple de tableau générique</h2>
        <!-- Tableau contenant les ingrédients de la recette -->
        <table class="tableau">
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

    <hr>

    <!-- ************************* DEBUT - EXEMPLE BOX ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple de box générique</h2>
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
                    <input type="file" id="image_recette" name="image_recette" accept="image/*" required>
                </div>
                <!-- Champ select -->
                <div class="form-input">
                    <label for="type_recette">Type de recette</label>
                    <select id="type_recette" required>
                        <option value="" selected>Choisissez un type de recette</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- ************************* FIN - EXEMPLE BOX ************************* -->

    <hr>

    <!-- ************************* DEBUT - EXEMPLE BOUTON ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple de bouton générique</h2>
        <button class="bouton">Sauvegarder</button>
    </div>
    <!-- ************************* FIN - EXEMPLE BOUTON ************************* -->

    <hr>

    <!-- ************************* DEBUT - EXEMPLE INPUT ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple d'input générique</h2>

        <!-- Champ lambda -->
        <input class="input" type="number" min="0" max="99" step="1">

        <!-- Checkbox lambda -->
        <input class="input" type="checkbox">

        <!-- Champ select -->
        <div class="form-input">
            <label for="type_recette">Type de recette</label>
            <select id="type_recette" required>
                <option value="" selected>Choisissez un type de recette</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
        </div>

        <!-- Champ pour le nom de la recette -->
        <div class="form-input">
            <label for="nom_recette">Nom</label>
            <input type="text" id="nom_recette" name="nom_recette" placeholder="Nom de la recette" <?php if (isset($recetteNom)) echo 'value=' . json_encode($recetteNom); ?> required>
        </div>

        <!-- Champ pour la description de la recette -->
        <div class="form-input">
            <label for="description_recette">Description</label>
            <textarea id="description_recette" name="description_recette" placeholder="Description de la recette" disabled minlength=1 maxlength=250><?php if (isset($recetteDescription)) echo $recetteDescription; ?></textarea>
        </div>

        <!-- Champ pour le prix de la recette -->
        <div class="form-input">
            <label for="prix_recette">Prix</label>
            <input type="number" min="0" step="0.01" id="prix_recette" name="prix_recette" placeholder="Prix de la recette" <?php if (isset($recettePrix)) echo 'value=' . json_encode($recettePrix); ?> required>
        </div>

        <!-- Champ pour l'image de la recette -->
        <div class="form-input">
            <label for="image_recette">Image</label>
            <input type="file" id="image_recette" name="image_recette" accept="image/*" required>
        </div>
    </div>
    <!-- ************************* FIN - EXEMPLE INPUT ************************* -->

    <hr>

    <!-- ************************* DEBUT - EXEMPLE ONGLETS ************************* -->
    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="bold color_secondaire font_size_large margin_bottom_top_moyen text-center">Exemple d'onglets générique</h2>
        <div class="onglets">
            <div class="onglet">Onglet 1</div>
            <div class="onglet onglet_actif">Onglet 2</div>
            <div class="onglet">Onglet 3</div>
            <div class="onglet">Onglet 4</div>
        </div>
    </div>
    <!-- ************************* FIN - EXEMPLE ONGLETS ************************* -->
</div>

<div>
    <canvas id="myChart"></canvas>
</div>

<script src="<?php echo ASSETS; ?>chartjs/chart.umd.min.js"></script>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<p class="margin_left_right_auto color_primaire">Test</p>