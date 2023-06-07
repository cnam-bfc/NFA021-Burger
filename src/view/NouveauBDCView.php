<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>styles.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauBDC.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<div class="padding_default grow">

    <!-- Dans le cas d'un nouveau bdc manuel -->
    <?php if (empty($_GET)) { ?>

        <div id = 'box' class="wrapper axe_colonne second_axe_center">
            <h2 class="titre_bulle">Création Bon de commande</h2>

            <div style="display:flex; flex-direction: row; justify-content: center; ">
                <button type="button" class='bouton' onclick="redirigerPageListeBdc()">Liste des Bons de commande</button>
            </div><br>

        </div>

        <div class="conteneur">
            <div class="boxBDC" id="boxBdc">

                <h2 class='courbe titre_fenetre'>Nouveau Bon de commande</h2><br>
                <form id="formulaire" action="nouveaubdc" method="post">

                    <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                    <select class='input' name='fournisseur' id='fournisseur'><br><br>

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
                                    <th>Unite</th>
                                    <th>Prix unitaire</th>
                                    <th hidden>Id</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <button type="button" onclick="recupererProduits(false)" class='courbe bouton'>Nouvelle ligne</button><br><br>

                    <div id='montant' class='bold'>
                        <p>Montant TTC :
                        <p>
                    </div>

                    <!-- Dans le cas où l'on vient de la page affichant la liste des bdc en attente -->
                <?php } else { ?>

                    <div class="wrapper axe_colonne second_axe_center">
                        <h2 class="titre_bulle">Edition Bon de commande</h2>
                    </div>

                    <div style="display:flex; flex-direction: row; justify-content: center; ">
                        <button type="button" class='bouton' onclick="redirigerPageListeBdc()">Liste des Bons de commande</button>
                    </div><br>

                    <div class="conteneur">
                        <div class="boxBDC" id="boxBdc">

                            <h2 class='courbe titre_fenetre'>Bon de commande N°<?php echo $bdc->getId(); ?></h2><br>
                            <form id="formulaire" action="nouveaubdc" method="post">

                                <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                                <select class='input' name='fournisseur' id='fournisseur'><br><br>

                                    <?php
                                    foreach ($fournisseurs as $donnees) {
                                    ?>
                                        <option value=<?php echo $donnees->getId(); ?> <?php if ($donnees->getId() == $bdc->getIdFournisseur()) { ?> selected <?php } ?>><?php echo $donnees->getNom(); ?></option>
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
                                                <th>Unite</th>
                                                <th>Prix unitaire</th>
                                                <th hidden>Id</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input type="hidden" name="idBdc" value=<?php echo $bdc->getId(); ?>></td>
                                            <?php
                                            foreach ($listeIngredientsBdc as $donneesBdc) {
                                            ?>

                                                <tr>
                                                    <td><select name="produit" class="courbe espace">
                                                            <?php
                                                            foreach ($listeIngredients as $donnees) {
                                                                if ($donnees->getIdFournisseur() == $bdc->getIdFournisseur()) {
                                                            ?>
                                                                    <option value=<?php echo $donnees->getPrixFournisseur(); ?> id=<?php echo $donnees->getId(); ?> <?php if ($donnees->getId() == $donneesBdc->getIdIngredient()) { ?> selected <?php } ?>><?php echo $donnees->getNom(); ?></option>

                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select></td>
                                                    <td><input type="number" name="quantite" class="courbe espace" value=<?php echo $donneesBdc->getQuantiteCommandee(); ?>></td>

                                                    <td><input type="text" name="unite" disabled="" class="courbe espace" value=<?php
                                                                                                                                foreach ($listeIngredients as $donnees) {
                                                                                                                                    if ($donnees->getId() == $donneesBdc->getIdIngredient()) {
                                                                                                                                        foreach ($listeUnites as $unite) {
                                                                                                                                            if ($unite->getId() == $donnees->getIdUnite()) {
                                                                                                                                                echo $unite->getNom();
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                } ?>></td>

                                                    <td><input type="number" name="prix" disabled="" class="courbe espace" value=<?php
                                                                                                                                    foreach ($listeIngredients as $donnees) {
                                                                                                                                        if ($donnees->getId() == $donneesBdc->getIdIngredient()) {
                                                                                                                                            echo $donnees->getPrixFournisseur();
                                                                                                                                        }
                                                                                                                                    } ?>></td>

                                                    <td><input type="hidden" name="id" value=<?php echo $donneesBdc->getIdIngredient(); ?>></td>
                                                    <td><button onclick="retirerLigne(this)" class="courbe bouton">X</button></td>
                                                </tr>

                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <button type="button" onclick="recupererProduits(false)" class='courbe bouton'>Nouvelle ligne</button><br><br>

                                <div id='montant' class='bold'>
                                    <p>Montant TTC :
                                    <p>
                                </div>

                            <?php } ?>

                            <br><br>
                            <div class="wrapper axe_colonne second_axe_center">
                                <input type="submit" class="bouton form-action" value="Commander" id='submit'>
                                <button type="button" class="bouton form-action" id='pdf' onclick="genererPdf()">Export PDF</button>
                            </div>

                            </form>
                        </div>
                    </div>
            </div><br><br>
            <br><br>
            <script src="<?php echo JS ?>NouveauBDC.js"></script>
            <script>
                placerEcouteursProduitsExistants(true);
            </script>