<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>ListeProduits.css">
<link rel="stylesheet" href="<?php echo CSS ?>style.css">

<body>

    <div id="wrapper">
        <div class="conteneur">
            <h1 class="titre_page">Liste des produits</h1>
            <div class="box">
                <input type="text" id="myInput" class='courbe' onkeyup="myFunction()" placeholder="Recherchez un produit...">
                <table id="myTable">
                    <thead>
                        <tr>
                            <th class='courbe bold'>Icone</th>
                            <th onclick="sortTable(1)" class='courbe bold'>Produit</th>
                            <th onclick="sortTable(2)" class='courbe bold'>Description</th>
                            <th onclick="sortTable(3)" class='courbe bold'>Fournisseur</th>
                            <th onclick="sortTable(4)" class='courbe bold'>Qte Stock</th>
                            <th onclick="sortTable(5)" class='courbe bold'>Stock mini</th>
                            <th onclick="sortTable(6)" class='courbe bold'>Qte Standard</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="conteneur">
                            <tr>
                                <td><img src=<?php echo $icone[1]["img"] ?> class='img'></td>
                                <td>Pain</td>
                                <td>
                                    <p> Farine de blé, levure, <br /> graine de sésame, sel.</p>
                                </td>
                                <td>Fournisseur</td>
                                <td>150</td>
                                <td>50</td>
                                <td>150</td>
                                <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                            </tr>

                            <td colspan="7">
                                <hr />
                            </td>

                            <tr>
                                <td><img src=<?php echo $icone[2]["img"] ?> class='img'></td>
                                <td>Steak</td>
                                <td>
                                    <p> Viande bovine, <br /> sel, poivre.</p>
                                </td>
                                <td>Fournisseur</td>
                                <td>150</td>
                                <td>50</td>
                                <td>150</td>
                                <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                            </tr>

                            <td colspan="7">
                                <hr />
                            </td>

                            <tr>
                                <td><img src=<?php echo $icone[4]["img"] ?> class='img'></td>
                                <td>Salade</td>
                                <td>
                                    <p> Batavia</p>
                                </td>
                                <td>Fournisseur</td>
                                <td>150</td>
                                <td>50</td>
                                <td>150</td>
                                <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                            </tr>

                            <td colspan="7">
                                <hr />
                            </td>

                            <tr>
                                <td><img src=<?php echo $icone[3]["img"] ?> class='img'></td>
                                <td>Tomate</td>
                                <td>
                                    <p> Coeur de boeuf</p>
                                </td>
                                <td>Fournisseur</td>
                                <td>150</td>
                                <td>50</td>
                                <td>150</td>
                                <td><img src=<?php echo $icone[0]["img"] ?> class='img'></td>
                            </tr>

                        </div>
                    </tbody>

                </table>
                <br><br>
            </div>
        </div>
    </div>


    <div class="container">
        <h2>Liste des produits</h2>

        <input type="text" id="myInput" class='courbe' onkeyup="myFunction()" placeholder="Recherchez ici...">

        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">Icone</div>
                <div class="col col-2" onclick="sortTableP()">Produit</div>
                <div class="col col-3">Fournisseur</div>
                <div class="col col-4">Stock</div>
                <div class="col col-4">Stock mini</div>
                <div class="col col-4">Qte Standard</div>
                <div></div>
            </li>

            <li class="table-row">
                <div class="col col-1" data-label="Icone"><img src=<?php echo $icone[1]["img"] ?> class='img'></div>
                <div class="col col-2" data-label="Produit">Pain</div>
                <div class="col col-3" data-label="Fournisseur">Fournisseur 1</div>
                <div class="col col-4" data-label="Qte Stock">150</div>
                <div class="col col-4" data-label="Stock mini">50</div>
                <div class="col col-4" data-label="Qte Standard">150</div>
                <div><img src=<?php echo $icone[0]["img"] ?> class='img'></div>
            </li>

            <li class="table-row">
                <div class="col col-1" data-label="Icone"><img src=<?php echo $icone[2]["img"] ?> class='img'></div>
                <div class="col col-2" data-label="Produit">Steak</div>
                <div class="col col-3" data-label="Fournisseur">Fournisseur 1</div>
                <div class="col col-4" data-label="Qte Stock">150</div>
                <div class="col col-4" data-label="Stock mini">50</div>
                <div class="col col-4" data-label="Qte Standard">150</div>
                <div><img src=<?php echo $icone[0]["img"] ?> class='img'></div>
            </li>

            <li class="table-row">
                <div class="col col-1" data-label="Icone"><img src=<?php echo $icone[3]["img"] ?> class='img'></div>
                <div class="col col-2" data-label="Produit">Tomate</div>
                <div class="col col-3" data-label="Fournisseur">Fournisseur 1</div>
                <div class="col col-4" data-label="Qte Stock">10</div>
                <div class="col col-4" data-label="Stock mini">5</div>
                <div class="col col-4" data-label="Qte Standard">10</div>
                <div><img src=<?php echo $icone[0]["img"] ?> class='img'></div>
            </li>

            <li class="table-row">
                <div class="col col-1" data-label="Icone"><img src=<?php echo $icone[4]["img"] ?> class='img'></div>
                <div class="col col-2" data-label="Produit">Salade</div>
                <div class="col col-3" data-label="Fournisseur">Fournisseur 1</div>
                <div class="col col-4" data-label="Qte Stock">10</div>
                <div class="col col-4" data-label="Stock mini">5</div>
                <div class="col col-4" data-label="Qte Standard">10</div>
                <div><img src=<?php echo $icone[0]["img"] ?> class='img'></div>
            </li>

        </ul>
    </div>

</body>

<script src="<?php echo JS ?>ListeProduits.js"></script>