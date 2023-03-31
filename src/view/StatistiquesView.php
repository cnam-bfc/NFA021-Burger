<!-- on inclut la feuille de style -->
<link rel="stylesheet" href="<?php echo CSS; ?>Statistiques.css">
<!-- bibliothèque pour générer un graphique -->
<script src="<?php ASSETS ?>chartjs/chart.min.js"></script>

<!-- on inclut la feuille js -->
<script src="<?php echo JS; ?>statistiques.js"></script>

<!-- content -->
<div class="wrapper axe_ligne">
    <section id="menu_gauche" class="wrapper axe_colonne width_25 background_senaire"> <!-- peut se plier -->
        <div class="onglets"> <!-- permet de choisir la div à afficher -->
            <a class="onglet">Selection</a>
            <a class="onglet">Configuration</a>
            <a class="onglet">Parametrage</a>
        </div>
        <div id="selection_graphe">
            <div class="box_graphe">
                <p class="graphe_categorie bold">Ventes</p>
                <p class="graphe_choix"><a href="#">Burger</a><p>
                <p class="graphe_choix"><a href="#">Ingedient</a></p>
            </div>

            <div class="box_graphe">
            <p class="graphe_categorie bold">Achats</p>
                <p class="graphe_choix"><a href="#">Tous les produits</a><p>
                <p class="graphe_choix"><a href="#">Choix d'un produit</a></p>
            </div>

            <div class="box_graphe">
                <p class="graphe_categorie bold">Généralités</p>
                <p class="graphe_choix"><a href="#">Bénéfices</a><p>
                <p class="graphe_choix"><a href="#">Nombre de client</a></p>
            </div>

        </div>

        <div id="configuration_graphe">

        </div>
        <div id="parametrage_graphe">

        </div>
        <div id="boutons_graphe"> <!-- permet d'ajouter, enregistrer, annuler, supprimer un graphe || ajouter ne se met pas en même temps que les 3 autres -->
            <!-- <a>Ajouter le graphe</a>
            <a>Enregistrer</a>
            <a>Annuler</a>
            <a>Supprimer</a> -->
        </div>
    </section>
    <section class="wrapper axe_colonne second_axe_center width_100" id="contenu">
        <div class="titre margin_bottom_top_large">
            <h1>Statistiques</h1>
            <i class="fa-solid fa-arrow-turn-down-right"></i>
        </div>

        <div>Le graphe</div>

        <div class="center_items_horizontal">
            <button class="bouton bouton_primaire">Exporter</button>
        </div>
    </section>
</div>
</div>