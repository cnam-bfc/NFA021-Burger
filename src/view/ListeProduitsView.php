<link rel="stylesheet" href="<?php echo CSS ?>ListeProduits.css">
<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">


<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre_bulle">Liste des produits</h2>
    </div><br><br>

    <div style="display:flex; flex-direction: row">
        <label for="recherche"><i class="loupe fa-solid fa-magnifying-glass fa-lg" style="color: #000;"></i></i></label>
        <input type="text" id="recherche" class='courbe' onkeyup="rechercher()" placeholder="Recherchez..." />
    </div><br>

    <div class="wrapper axe_colonne second_axe_center">
        <!-- Tableau contenant les ingrédients enregistrés -->
        <table class="tableau">
            <thead>
                <tr>
                    <th><!-- Image --></th>
                    <th>Produit</th>
                    <th>Fournisseur</th>
                    <th>Stock</th>
                    <th>Stock Standard</th>
                    <th class = 'hidding'>Id</th>
                    <th><!-- Bouton de modification --></th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                foreach ($ingr as $donnees) {
                ?>
                    <tr id='select'>
                        <td><img src=<?php echo $icone[$i]["img"]; ?> class='img'></td>
                        <td><?php echo $donnees->getNomIngredient(); ?></td>
                        <td><?php foreach ($fournisseur as $data) {
                                    if ($data->getIdFournisseur() == $donnees->getIdFournisseurFK())
                                        echo $data->getNomFournisseur(); } ?></td>
                        <td><?php echo $donnees->getQuantiteStockIngredient(); ?></td>
                        <td><?php echo $donnees->getQuantiteStandard(); ?></td>
                        <td class = 'hidding'><?php echo $donnees->getIdIngredient(); ?></td>
                        <td><img src=<?php echo $modifier[0]["img"]; ?> class='img' id='bouton'></td>
                    </tr>
                <?php
                    $i++;
                }
                ?>

            </tbody>
            <tfoot>
                <tr></tr>
            </tfoot>
        </table>
    </div>
</div>

<script src="<?php echo JS ?>ListeProduits.js"></script>