<!-- Ajout du css associé à la page -->
<link rel="stylesheet" href="<?= CSS ?>EditRecette.css">

<div class="wrapper">
    <h1 class="titre"><?= $titre ?></h1>

    <!-- Ligne contenant les informations générales et la composition de la recette -->
    <div id="boxs">
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
                    <textarea id="description_recette" name="description_recette" placeholder="Description de la recette" required rows=5 cols=50 minlength=1 maxlength=250></textarea>
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

    <div class="center_items_horizontal">
        <button id="enregistrer" class="bouton bouton_primaire">Enregistrer</button>
    </div>
</div>