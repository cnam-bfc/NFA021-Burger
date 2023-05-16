<!-- on inclut la feuille de style -->
<link rel="stylesheet" href="<?php echo CSS; ?>Statistiques.css">
<!-- bibliothèque pour générer un graphique -->
<script src="<?php ASSETS ?>chartjs/chart.min.js"></script>
<!-- on inclut la feuille js -->
<script src="<?php echo JS; ?>statistiques.js"></script>

<!-- content -->
<div class="wrapper axe_ligne grow ">
    <section id="menu_gauche" class="wrapper axe_colonne width_25"> <!-- peut se plier -->
        <div class="onglets"> <!-- permet de choisir la div à afficher -->
            <a class="onglet" id="ongletSelection">Selection</a>
            <a class="onglet" id="ongletConfiguration">Configuration</a>
            <a class="onglet" id="ongletParametrage">Parametrage</a>
        </div>
        <div id="menu_graphe">
            <div data_id="ongletSelection">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Ventes</h3>
                    <p class="graphe_choix"><a href="#">Burger</a>
                    <p>
                    <p class="graphe_choix"><a href="#">Ingedient</a></p>
                </div>

                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Achats</h3>
                    <p class="graphe_choix"><a href="#">Tous les produits</a>
                    <p>
                    <p class="graphe_choix"><a href="#">Choix d'un produit</a></p>
                </div>

                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Généralités</h3>
                    <p class="graphe_choix"><a href="#">Bénéfices</a>
                    <p>
                    <p class="graphe_choix"><a href="#">Nombre de client</a></p>
                </div>
            </div>

            <div data_id="ongletConfiguration">

            </div>

            <div data_id="ongletParametrage">

            </div>
        </div>
        <div id="boutons_graphe" class="wrapper axe_ligne gap_left_right_moyen">
            <button title="Ajouter le graphe" id="add_graphe" class="bouton"><i class="fa-solid fa-plus fa-xl"></i></button>
            <button title="Sauvegarder les changements" id="save_graphe" class="bouton"><i class="fa-solid fa-floppy-disk fa-xl"></i></button>
            <button title="Annuler les changements" id="cancel_graphe" class="bouton"><i class="fa-solid fa-xmark fa-xl"></i></button>
            <button title="Supprimer le graphe" id="delete_graphe" class="bouton"><i class="fa-solid fa-trash fa-xl"></i></button>
        </div>
    </section>
    <section class="wrapper axe_colonne second_axe_center width_100 main_axe_space_between" id="contenu">
        <div class="titre_souligne">
            <h1>Statistiques</h1>
        </div>

        <div>Le graphe</div>

        <div class="center_items_horizontal">
            <button class="bouton bouton_primaire margin_bottom_top_large">Exporter</button>
        </div>
    </section>
</div>
</div>