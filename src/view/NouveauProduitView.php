<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauProduit.css">

<h1 class="titre_page">Nouveau Produit</h1>

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

            <label for="fournisseur">Fournisseur :</label><br>
            <input type="text" id="fournisseur" name="fournisseur" class="courbe remplir"><br><br>

            <label for="stock">Stock Initial :</label><br>
            <input id="stock" name="stock" class="courbe remplir"><br><br>

            <label for="stockAuto">Stock Auto-Manager :</label><br>
            <input type="checkbox" id="stockAuto" name="stockAuto" class='courbe'><br><br>

            <label for="stockMin">Stock mininum:</label><br>
            <input id="stockMin" name="stockMin" disabled class="courbe remplir"><br><br>

            <label for="cmdAuto">Commande Auto :</label><br>
            <input id="cmdAuto" name="cmdAuto" disabled class="courbe remplir"><br><br>

            <input type="submit" value="Valider" class='centrer valider courbe'>

        </form>
    </div>
</div><br><br>

<script src="<?php echo JS ?>NouveauProduit.js"></script>