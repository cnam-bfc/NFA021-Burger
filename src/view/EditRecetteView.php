<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>EditRecette.css">

<!-- Wrapper (contenu de la page) -->
<div class="padding_default">
    <div class="wrapper main_axe_space_around">
        <h1 class="titre"><?= $titre ?></h1>
    </div>

    <!-- Ligne contenant les informations générales et la composition de la recette -->
    <div id="boxs" class="wrapper axe_ligne wrap padding_bottom_top_large">
        <!-- Box informations générales -->
        <div class="box" id="informations_generales">
            <h2 class="box_titre">Informations générales</h2>
            <div class="box_contenu">
                <!-- Champ pour le nom de la recette -->
                <div class="form-input">
                    <label for="nom_recette">Nom</label>
                    <input type="text" id="nom_recette" name="nom_recette" placeholder="Nom de la recette" required>
                </div>
                <!-- Champ pour la description de la recette -->
                <div class="form-input">
                    <label for="description_recette">Description</label>
                    <textarea id="description_recette" name="description_recette" placeholder="Description de la recette" required rows=5 minlength=1 maxlength=250></textarea>
                </div>
                <!-- Champ pour le prix de la recette -->
                <div class="form-input">
                    <label for="prix_recette">Prix</label>
                    <input type="number" min="0" step="0.01" id="prix_recette" name="prix_recette" placeholder="Prix de la recette" required>
                </div>
                <!-- Champ pour l'image de la recette -->
                <div class="form-input">
                    <label for="image_recette">Image</label>
                    <input type="file" id="image_recette" name="image_recette" accept="image/*" required>
                </div>
            </div>
        </div>

        <!-- Box composition de la recette -->
        <div class="box" id="composition">
            <h2 class="box_titre">Composition</h2>
            <div class="box_contenu">

            </div>
        </div>
    </div>

    <div class="wrapper main_axe_space_around">
        <button id="enregistrer" class="bouton bouton_primaire">Enregistrer</button>
    </div>
</div>