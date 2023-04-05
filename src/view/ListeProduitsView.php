<link rel="stylesheet" href="<?php echo CSS ?>ListeProduits.css">
<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">


<div id="wrapper">

    <body>
        <div class='titre_page'>Liste des produits</div>
        <br><br>

        <input type="text" id="recherche" class='courbe' onkeyup="rechercher()" placeholder="Recherchez...">
        <table>
            <thead>
                <tr>
                    <th scope="col">Icone</th>
                    <th scope="col">Produit</th>
                    <th scope="col">Allergenes</th>
                    <th scope="col">Fournisseur</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Stock mini</th>
                    <th scope="col">Qantite Standard</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Account"><img src=<?php echo $icone[1]["img"] ?> class='img'></td>
                    <td data-label="Due Date">Pain</td>
                    <td data-label="Due Date">Sesame</td>
                    <td data-label="Due Date">La Boulangerie Bleue</td>
                    <td data-label="Amount">350</td>
                    <td data-label="Amount">150</td>
                    <td data-label="Amount">300</td>
                    <td data-label="Period"><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>
                <tr>
                    <td data-label="Account"><img src=<?php echo $icone[2]["img"] ?> class='img'></td>
                    <td data-label="Due Date">Steak</td>
                    <td data-label="Due Date"></td>
                    <td data-label="Due Date">Carrefour</td>
                    <td data-label="Amount">350</td>
                    <td data-label="Amount">150</td>
                    <td data-label="Amount">300</td>
                    <td data-label="Period"><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>
                <tr>
                    <td data-label="Account"><img src=<?php echo $icone[3]["img"] ?> class='img'></td>
                    <td data-label="Due Date">Tomate</td>
                    <td data-label="Due Date"></td>
                    <td data-label="Due Date">Bio Maraicher</td>
                    <td data-label="Amount">350</td>
                    <td data-label="Amount">150</td>
                    <td data-label="Amount">300</td>
                    <td data-label="Period"><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>
                <tr>
                    <td data-label="Account"><img src=<?php echo $icone[4]["img"] ?> class='img'></td>
                    <td data-label="Due Date">Salade</td>
                    <td data-label="Due Date">Sesame</td>
                    <td data-label="Due Date">Bio Maraicher</td>
                    <td data-label="Amount">350</td>
                    <td data-label="Amount">150</td>
                    <td data-label="Amount">300</td>
                    <td data-label="Period"><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                </tr>
            </tbody>
        </table>
        <br><br>
    </body>
</div>