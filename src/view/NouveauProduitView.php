<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauProduit.css">

<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre">Nouveau Produit</h2>
    </div>

    <div class="conteneur">
        <div class="box_produit">
            <h2 class='titre_fenetre courbe'>Informations du produit</h2><br>
            <form>
                <label for="icone">Icone :</label><br>
                <input type="file" id="icone" name="icone"><br><br>

                <label for="eclate">Vue eclatee : </label><br>
                <input type="file" id="eclate" name="eclate"><br><br>

                <label for="nom"> Produit :</label><br>
                <input type="text" id="nom" name="nom" class="courbe remplir"><br><br>

                <label for="allergene">Allergene :</label><br>
                <input type="text" id="allergene" name="allergene" class="courbe remplir"><br><br>

                <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                <select class='courbe'><br><br>
                    <option value="Bio Maraichage">Bio Maraichage</option>
                    <option value="Le Royaume des Sauces">Le Royaume des Sauces</option>
                    <option value="La Boulangerie Bleue">La Boulangerie Bleue</option>
                </select><br><br>

                <label for="stock">Stock Initial :</label><br>
                <input id="stock" name="stock" class="courbe remplir"><br><br>

                <label for="stockAuto">Stock Auto-Manager :</label><br>
                <input type="checkbox" id="stockAuto" name="stockAuto" class='courbe'><br><br>

                <label for="stockMin">Stock Mininum:</label><br>
                <input id="stockMin" name="stockMin" disabled class="courbe remplir"><br><br>

                <label for="cmdAuto">Quantite Commande Auto :</label><br>
                <input id="cmdAuto" name="cmdAuto" disabled class="courbe remplir"><br><br>

                <div class="wrapper axe_colonne second_axe_center">
                    <button class="bouton">Sauvegarder</button>
                </div>

            </form>
        </div>
    </div>
</div><br><br>

<script src="<?php echo JS ?>NouveauProduit.js"></script>