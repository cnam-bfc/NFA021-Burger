<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>NouveauBDC.css">

<div id="wrapper">

    <h1 class="titre_page">Bon de Commande</h1>

    <div class="conteneur">
        <div class="boxBDC">
            <h2 class='courbe titre_fenetre'>Bon de commande No 47</h2><br>
            <form>

                <label for="fournisseur" class='bold'>Fournisseur :</label><br>
                <select class='courbe'><br><br>
                    <option value="Bio Maraichage">Bio Maraichage</option>
                    <option value="Le Royaume des Sauces">Le Royaume des Sauces</option>
                    <option value="La Boulangerie Bleue">La Boulangerie Bleue</option>
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
                                <td><select id="produit" name="produit" class='courbe'><br><br>
                                        <option value="Pain Burger">Pain Burger</option>
                                        <option value="Tomate">Tomate au KG</option>
                                        <option value="Steak Boeuf">Steak Boeuf</option>
                                    </select></td>
                                <td><input type="number" name="quantite" id="quantite" class='courbe'></td>
                                <td><input type="number" name="prix" id="prix" disabled value='1.00' class='courbe'></td>
                                <td><button onclick="retirerLigne(this)" class='courbe'>X</button></td>
                            </tr>

                            <tr>
                                <td><select id="produit" name="produit" class='courbe'><br><br>
                                        <option value="Pain Burger">Pain Burger</option>
                                        <option value="Tomate">Tomate au KG</option>
                                        <option value="Steak Boeuf">Steak Boeuf</option>
                                    </select></td>
                                <td><input type="number" name="quantite" id="quantite" class='courbe'></td>
                                <td><input type="number" name="prix" id="prix" disabled value='1.00' class='courbe'></td>
                                <td><button onclick="retirerLigne(this)" class='courbe'>X</button></td>
                            </tr>

                            <tr>
                                <td><select id="produit" name="produit" class='courbe'><br><br>
                                        <option value="Pain Burger">Pain Burger</option>
                                        <option value="Tomate">Tomate au KG</option>
                                        <option value="Steak Boeuf">Steak Boeuf</option>
                                    </select></td>
                                <td><input type="number" name="quantite" id="quantite" class='courbe'></td>
                                <td><input type="number" name="prix" id="prix" disabled value='1.00' class='courbe'></td>
                                <td><button onclick="retirerLigne(this)" class='courbe'>X</button></td>
                            </tr>

                            <tr>
                                <td><select id="produit" name="produit" class='courbe'><br><br>
                                        <option value="Pain Burger">Pain Burger</option>
                                        <option value="Tomate">Tomate au KG</option>
                                        <option value="Steak Boeuf">Steak Boeuf</option>
                                    </select></td>
                                <td><input type="number" name="quantite" id="quantite" class='courbe'></td>
                                <td><input type="number" name="prix" id="prix" disabled value='1.00' class='courbe'></td>
                                <td><button onclick="retirerLigne(this)" class='courbe'>X</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button onclick="ajouterLigne()" class='courbe'>+</button><br><br>

                <div id = 'montant' class = 'bold'>
                    <p>Montant TTC : <p>
                </div>

                <input type="submit" value="Valider" class='centrer valider courbe'>

                <script src="<?php echo JS ?>NouveauBDC.js"></script>

            </form>
        </div>
    </div>
</div><br><br>
<br><br>
<script src="<?php echo JS ?>NouveauBDC.js"></script>