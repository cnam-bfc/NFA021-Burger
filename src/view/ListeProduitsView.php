<link rel="stylesheet" href="<?php echo CSS ?>ListeProduits.css">
<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">


<div class="padding_default grow">

    <div class="wrapper axe_colonne second_axe_center">
        <h2 class="titre">Liste des produits</h2>
    </div><br><br>

    <div style="display:flex; flex-direction: row">
        <label for="recherche"><i class="loupe fa-solid fa-magnifying-glass fa-lg" style="color: #000;"></i></i></label>
        <input type="text" id="recherche" class='courbe' onkeyup="rechercher()" placeholder="Recherchez..." />
    </div><br>

    <div class="wrapper axe_colonne second_axe_center">
        <!-- Tableau contenant les ingrédients de la recette -->
        <table class="tableau">
            <thead>
                <tr>
                    <th><!-- Image --></th>
                    <th>Produit</th>
                    <th>Allergene</th>
                    <th>Fournisseur</th>
                    <th>Stock</th>
                    <th>Stock Mini</th>
                    <th>Stock Standard</th>
                    <th><!-- Bouton actions rapide --></th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>

                <!-- <tr id='select'>
                    <td><img src="<?= IMG . 'icone/pain.png' ?>"></td>
                    <td>Pain</td>
                    <td></td>
                    <td>La Boulangerie Bleue</td>
                    <td>250 u</td>
                    <td>100 u</td>
                    <td>400 u</td>
                    <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>

                <tr id='select'>
                    <td><img src="<?= IMG . 'icone/steak.png' ?>"></td>
                    <td>Steak</td>
                    <td></td>
                    <td>FreezeFood</td>
                    <td>250 u</td>
                    <td>100 u</td>
                    <td>500 u</td>
                    <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>

                <tr id='select'>
                    <td><img src="<?= IMG . 'icone/tomate.png' ?>"></td>
                    <td>Tomate</td>
                    <td></td>
                    <td>BioMaraicher</td>
                    <td>25 kg</td>
                    <td>10 kg</td>
                    <td>50 kg</td>
                    <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>

                <tr id='select'>
                    <td><img src="<?= IMG . 'icone/salade.png' ?>"></td>
                    <td>Salade</td>
                    <td></td>
                    <td>BioMaraicher</td>
                    <td>25 kg</td>
                    <td>10 kg</td>
                    <td>50 kg</td>
                    <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr> -->

                <?php
                $host = 'localhost';
                $bd = 'chabu';
                $login = 'root';
                $password = '';

                global $pdo;
                $result;
                try {
                    $pdo = new PDO('mysql:dbname=chabu;host=127.0.0.1;port=3307', $login, $password);
                } catch (Exception $e) { //Le catch est chargé d’intercepter une éventuelle erreur
                    die($e->getMessage());
                }

                $query = "SELECT * FROM burger_ingredient";
                try {
                    $statement = $pdo->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    die("Erreur dans la requete " . $e->getMessage());
                }
                $i = 0;
                
                foreach ($result as $donnees) {
                    $i++;
                ?>
                    <tr id='select'>
                        <td><img src=<?php echo $icone[$i]["img"]; ?> class='img'></td>
                        <td><?php echo $donnees['nom_ingredient']; ?></td>
                        <td><?php echo $donnees['id_fournisseur_fk']; ?></td>
                        <td><?php echo $donnees['quantite_stock_ingredient']; ?></td>
                        <td><?php echo $donnees['quantite_standard']; ?></td>
                        <td><?php echo $donnees['quantite_minimum']; ?></td>
                        <td><img src=<?php echo $icone[0]["img"]; ?> class='img'></td>
                    </tr>
                <?php
                
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