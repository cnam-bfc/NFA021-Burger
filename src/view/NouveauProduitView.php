<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauProduit.css">

<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre_bulle">Nouveau Produit</h2>
    </div>

    <div class="conteneur">
        <div class="box_produit">
            <h2 class='titre_fenetre courbe'>Informations du produit</h2><br>
            <form action="nouveauproduit" method="post">

                <?php if (!isset($ingredient)) { ?>

                    <label for="icone">Icone :</label><br>
                    <input type="file" id="icone" name="icone"><br><br>

                    <label for="eclate">Vue eclatee : </label><br>
                    <input type="file" id="eclate" name="eclate"><br><br>

                    <label for="nom"> Produit :</label><br>
                    <input type="text" id="nom" name="nom" class="courbe remplir"><br><br>

                    <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                    <select class='courbe' name='fournisseur'><br><br>

                        <?php
                        foreach ($fournisseur as $donnees) {
                        ?>
                            <option><?php echo $donnees->getNomFournisseur(); ?></option>
                        <?php
                        }
                        ?>

                    </select><br><br>

                    <label for="qteStock">Stock Initial :</label><br>
                    <input id="qteStock" name="qteStock" class="courbe remplir"><br><br>

                    <label for="stockAuto">Stock Wizard :</label><br>
                    <input type="checkbox" id="stockAuto" name="stockAuto" class='courbe'><br><br>

                    <label for="qteMin">Stock Mininum:</label><br>
                    <input id="qteMin" name="qteMin" disabled class="courbe remplir"><br><br>

                    <label for="qteStandard">Quantite Commande Auto :</label><br>
                    <input id="qteStandard" name="qteStandard" disabled class="courbe remplir"><br><br>

                    <label for="unite" class='bold'>Unite :</label><br>
                    <select class='courbe' name='unite'><br><br>

                        <?php
                        foreach ($unite as $donnees) {
                        ?>
                            <option><?php echo $donnees->getNomUnite(); ?></option>
                        <?php
                        }
                        ?>

                    </select>

                <?php
                } else {
                ?>

                    <label for="icone">Icone :</label><br>
                    <input type="file" id="icone" name="icone"><br><br>

                    <label for="eclate">Vue eclatee : </label><br>
                    <input type="file" id="eclate" name="eclate"><br><br>

                    <label for="nom"> Produit :</label><br>
                    <input type="text" id="nom" name="nom" class="courbe remplir" value=<?php echo $ingredient->getNomIngredient(); ?>><br><br>

                    <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                    <select class='courbe' name='fournisseur'><br><br>

                        <?php
                        foreach ($fournisseur as $donnees) {
                        ?>
                            <option <?php if ($donnees->getIdFournisseur() == $ingredient->getIdFournisseurFK()) { ?> selected <?php } ?>><?php echo $donnees->getNomFournisseur(); ?></option>
                        <?php
                        }
                        ?>

                    </select><br><br>

                    <label for="qteStock">Stock Initial :</label><br>
                    <input id="qteStock" name="qteStock" class="courbe remplir" value=<?php echo $ingredient->getQuantiteStockIngredient(); ?>><br><br>

                    <label for="stockAuto">Stock Wizard :</label><br>
                    <input type="checkbox" id="stockAuto" name="stockAuto" class='courbe' checked><br><br>

                    <label for="qteMin">Stock Mininum:</label><br>
                    <input id="qteMin" name="qteMin" disabled class="courbe remplir" value=<?php echo $ingredient->getQuantiteMinimum(); ?>><br><br>

                    <label for="qteStandard">Quantite Commande Auto :</label><br>
                    <input id="qteStandard" name="qteStandard" disabled class="courbe remplir" value=<?php echo $ingredient->getQuantiteStandard() ?>><br><br>

                    <label for="unite" class='bold'>Unite :</label><br>
                    <select class='courbe' name='unite'><br><br>

                        <?php
                        foreach ($unite as $donnees) {
                        ?>
                            <option <?php if ($donnees->getIdUnite() == $ingredient->getIdUniteFK()) { ?> selected <?php } ?>><?php echo $donnees->getNomUnite(); ?></option>
                        <?php
                        }
                        ?>

                    </select>

                    <label for="id" class='hidding'>Id</label><br>
                    <input type="number" id="id" name="id" class="courbe remplir hidding">
                <?php
                }
                ?>

                <div class="wrapper axe_colonne second_axe_center">
                    <input type='submit' class="bouton" value='Valider'>
                </div>

            </form>
        </div>
    </div>
</div><br><br>

<script src="<?php echo JS ?>NouveauProduit.js"></script>