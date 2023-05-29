<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauBDC.css">

<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre_bulle">Bon de commande</h2>
    </div>

    <div class="conteneur">
        <div class="boxBDC">
            <h2 class='courbe titre_fenetre'>Bon de commande No 47</h2><br>
            <form action="nouveaubdc" method="post">

                <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                <select class='courbe' name='fournisseur' id='fournisseur' ><br><br>

                    <?php
                    foreach ($fournisseurs as $donnees) {
                    ?>
                        <option value=<?php echo $donnees->getId(); ?>><?php echo $donnees->getNom(); ?></option>
                    <?php
                    }
                    ?>

                </select><br><br>

                <div class="conteneur">
                    <table id='tableau' class='courbe'>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <button type="button" onclick="recupererProduits(false)" class='courbe bouton'>Nouvelle ligne</button><br><br>

                <div id='montant' class='bold'>
                    <p>Montant TTC :
                    <p>
                </div>

                <br><br>
                <div class="wrapper axe_colonne second_axe_center">
                    <input type="submit" class="bouton form-action" value ="Enregistrer">
                </div>

            </form>
        </div>
    </div>
</div><br><br>
<br><br>
<script src="<?php echo JS ?>NouveauBDC.js"></script>