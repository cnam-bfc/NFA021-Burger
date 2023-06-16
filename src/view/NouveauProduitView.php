<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauProduit.css">

<div class="padding_default grow">

    <?php if (!isset($ingredient)) { ?>

        <!-- Création d'un nouvel ingrédient -->

        <div class="wrapper axe_colonne second_axe_center">
            <h2 class="titre_bulle">Nouvel ingrédient</h2>
        </div>

        <div style="display:flex; flex-direction: row; justify-content: center; ">
            <button type="button" class='bouton' onclick="redirigerPageListeProduits()">Liste des ingrédients</button>
        </div><br>

        <div class="conteneur">
            <div class="box_produit">
                <h2 class='titre_fenetre courbe'>Informations de l'ingrédient</h2><br>
                <form action="nouveauproduit" method="post" enctype="multipart/form-data">

                    <label for="icone">Icone :</label><br>
                    <input type="file" id="icone" name="icone" required><br><br>

                    <label for="eclate">Vue éclatée : </label><br>
                    <input type="file" id="eclate" name="eclate"><br><br>

                    <label for="nom">Ingrédient :</label><br>
                    <input type="text" id="nom" name="nom" class="courbe remplir" required><br><br>

                    <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                    <select class='courbe' name='fournisseur'><br><br>

                        <?php
                        foreach ($fournisseur as $donnees) {
                        ?>
                            <option value=<?php echo $donnees->getId(); ?>><?php echo $donnees->getNom(); ?></option>
                        <?php
                        }
                        ?>

                    </select><br><br>

                    <label for="prix">Prix :</label><br>
                    <input type='number' min='0.1' step="0.1" id="prix" name="prix" class="courbe remplir" required><br><br>

                    <label for="qteStock">Stock :</label><br>
                    <input type='number' min='0' id="qteStock" name="qteStock" class="courbe remplir" required><br><br>

                    <label for="stockAuto">Stock Automatique :</label><br>
                    <input type="checkbox" id="stockAuto" name="stockAuto" class='courbe'><br><br>

                    <label for="qteStandard">Quantite Standard :</label><br>
                    <input type='number' min='0' id="qteStandard" name="qteStandard" class="courbe remplir" disabled><br><br>

                    <label for="qteMin">Quantité Mininum:</label><br>
                    <input type='number' min='0' id="qteMin" name="qteMin" class="courbe remplir" disabled><br><br>

                    <label for="unite" class='bold'>Unite :</label><br>
                    <select class='courbe' name='unite'><br><br>

                        <?php
                        foreach ($unite as $donnees) {
                        ?>
                            <option value=<?php echo $donnees->getId(); ?>><?php echo $donnees->getNom(); ?></option>
                        <?php
                        }
                        ?>

                    </select>

                    <div class="wrapper axe_colonne second_axe_center">
                        <input type='submit' class="bouton" value='Valider' onclick='messageCreationIngredient()'>
                    </div>

                <?php
            } else {
                ?>
                    <!-- Modification d'un produit existant -->

                    <div class="wrapper axe_colonne second_axe_center">
                        <h2 class="titre_bulle">Modification ingrédient</h2>
                    </div>

                    <div style="display:flex; flex-direction: row; justify-content: center; ">
                        <button type="button" class='bouton' onclick="redirigerPageListeProduits()">Liste des ingrédients</button>
                    </div><br>

                    <div class="conteneur">
                        <div class="box_produit">
                            <h2 class='titre_fenetre courbe'>Informations de l'ingrédient</h2><br>
                            <form action="nouveauproduit" method="post" enctype="multipart/form-data">

                                <label for="icone">Icone :</label><br>
                                <input type="file" id="icone" name="icone"><br><br>

                                <label for="eclate">Vue éclatée : </label><br>
                                <input type="file" id="eclate" name="eclate"><br><br>

                                <label for="nom"> Ingrédient :</label><br>
                                <input type="text" id="nom" name="nom" class="courbe remplir" value=<?php echo $ingredient->getNom(); ?> required><br><br>

                                <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                                <select class='courbe' name='fournisseur'><br><br>

                                    <?php
                                    foreach ($fournisseur as $donnees) {
                                    ?>
                                        <option value=<?php echo $donnees->getId(); ?> <?php if ($donnees->getId() == $ingredient->getIdFournisseur()) { ?> selected <?php } ?>><?php echo $donnees->getNom(); ?></option>
                                    <?php
                                    }
                                    ?>

                                </select><br><br>

                                <label for="prix">Prix :</label><br>
                                <input type='number' id="prix" min='0.1' step="0.1" name="prix" class="courbe remplir" value=<?php echo $ingredient->getPrixFournisseur(); ?> required><br><br>

                                <label for="qteStock">Stock :</label><br>
                                <input type='number' id="qteStock" min='0' name="qteStock" class="courbe remplir" value=<?php echo $ingredient->getQuantiteStock(); ?> required><br><br>

                                <label for="stockAuto">Stock Automatique :</label><br>
                                <input type="checkbox" id="stockAuto" name="stockAuto" class='courbe' <?php if ($ingredient->isStockAuto() != 0) { ?> checked <?php } ?>><br><br>

                                <label for="qteStandard">Quantite Standard :</label><br>
                                <input type='number' id="qteStandard" min='0' name="qteStandard" class="courbe remplir" <?php if ($ingredient->getQuantiteStandardStockAuto() != 0) { ?> value=<?php echo $ingredient->getQuantiteStandardStockAuto(); ?> <?php } else { ?> disabled <?php } ?>><br><br>

                                <label for="qteMin">Quantite Mininum:</label><br>
                                <input type='number' id="qteMin" min='0' name="qteMin" class="courbe remplir" <?php if ($ingredient->getQuantiteMinimaleStockAuto() != 0) { ?> value=<?php echo $ingredient->getQuantiteMinimaleStockAuto(); ?> <?php } else { ?> disabled <?php } ?>><br><br>

                                <label for="unite" class='bold'>Unite :</label><br>
                                <select class='courbe' name='unite'><br><br>

                                    <?php
                                    foreach ($unite as $donnees) {
                                    ?>
                                        <option value=<?php echo $donnees->getId(); ?> <?php if ($donnees->getId() == $ingredient->getIdUnite()) { ?> selected <?php } ?>><?php echo $donnees->getNom(); ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>

                                <label for="id" class='hidding'>Id</label><br>
                                <input type="number" id="id" name="id" class="courbe remplir hidding" value=<?php echo $ingredient->getId(); ?>>

                                <div class="wrapper axe_colonne second_axe_center">
                                    <input type='submit' class="bouton" value='Valider' onclick='messageModificationIngredient()'>
                                </div>
                            <?php
                        }
                            ?>
                            </form>
                        </div>
                    </div>
            </div><br><br>

            <script src="<?php echo JS ?>NouveauProduit.js"></script>