<link rel="stylesheet" href="<?php echo CSS ?>ListeProduits.css">
<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<script src="<?php echo JS ?>ListeProduits.js"></script>

<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre_bulle">Liste des ingrédients</h2>

        <div style="display:flex; flex-direction: row">
            <button type="button" class='bouton' onclick="redirigerPageNouveauProduit()">Nouvel ingrédient</button>
        </div><br>

    </div><br><br>

    <div style="display:flex; flex-direction: row">
        <label for="recherche"><i class="loupe fa-solid fa-magnifying-glass fa-lg" style="color: #000;"></i></i></label>
        <input type="text" id="recherche" class='courbe' onkeyup="rechercher()" placeholder="Recherchez..." />
    </div><br>

    <div class="wrapper axe_colonne second_axe_center">
        <!-- Tableau des ingrédients -->
        <table class="tableau">
            <thead>
                <tr>
                    <th><!-- Colonne pour l'icone --></th>
                    <th>Ingrédient</th>
                    <th>Fournisseur</th>
                    <th>Stock</th>
                    <th>Stock Standard</th>
                    <th class='hidding'><!-- Colonne pour dissimuler l'id -->Id</th>
                    <th><!-- Colonne pour le bouton de modification -->Modifier</th>
                    <th><!-- Colonne pour le bouton d'archivage -->Archiver</th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>

                <?php
                //Pour chaque objet ingrédient récupéré en bdd, on crée une ligne dans le tableau
                $i = 0;
                foreach ($ingr as $donnees) {
                ?>
                    <tr id="select<?php echo $donnees->getId(); ?>">
                        <td><img src=<?php echo $icone[$i]["img"]; ?> class='img'></td>
                        <td><?php echo $donnees->getNom(); ?></td>

                        <td><?php foreach ($fournisseur as $data) {
                                if ($data->getId() == $donnees->getIdFournisseur())
                                    echo $data->getNom();
                            } ?></td>
                            
                        <td><?php echo $donnees->getQuantiteStock(); ?></td>
                        <td><?php echo $donnees->getQuantiteStandardStockAuto(); ?></td>
                        <td class='hidding'><?php echo $donnees->getId(); ?></td>
                        <td><i class="fa-solid fa-pen fa-xl bouton" data-name='boutonModifier'></i></td>
                        <td><i class="fa-solid fa-box-archive fa-xl bouton" data-name='boutonArchiver'></i></td>
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