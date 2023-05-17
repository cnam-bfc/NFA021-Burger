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
                    <button class="graphe_choix" type_stat="burger">
                        <p>Burger <span class="font_size_petit">(total)</span></p>
                    </button>
                    <button class="graphe_choix" type_stat="burger">
                        <p>Burger <span class="font_size_petit">(évolution dans le temps)</span></p>
                    </button>
                    <button class="graphe_choix" type_stat="ingredient">
                        <p>Ingedient</p>
                    </button>
                </div>

                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Achats</h3>
                    <button class="graphe_choix" type_stat="produits">
                        <p>Produits</p>
                    </button>
                    <button class="graphe_choix" type_stat="fournisseurs">
                        <p>Fournisseurs</p>
                    </button>
                </div>

                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Généralités</h3>
                    <button class="graphe_choix" type_stat="benefices">
                        <p>Bénéfices</p>
                    </button>
                    <button class="graphe_choix" type_stat="nombre_client">
                        <p>Nombre de client</p>
                    </button>
                </div>
            </div>

            <div data_id="ongletConfiguration">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Nom</h3>
                    <input type="text" id="nom_graphe" name="nom_graphe" class="input" placeholder="Nom du graphique">
                </div>
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Description</h3>
                    <textarea id="description_graphe" name="description_graphe" class="textarea" placeholder="Description du graphique" minlength=0 maxlength=250></textarea>
                </div>
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Type de graphe</h3>
                    <select id="type_graphe" class="select">
                        <option value="" selected>Choisissez un type de graphique</option>
                    </select>
                </div>
<!--
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Ordre</h3>
                    <select id="ordre_graphe" class="select">
                        <option value="" selected>Choisissez l'ordre de votre graphique</option>
                    </select>
                </div>
-->
            </div>
            <div data_id="ongletParametrage">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Date</h3>
                    <span class="wrapper axe_ligne main_axe_space_between second_axe_center grow">
                        <label for="choix_date_graphe">Date personnalisé</label>
                        <input class="input" id="choix_date_graphe" name="choix_date_graphe" type="checkbox">
                    </span>
                    <span class="wrapper axe_ligne main_axe_space_between second_axe_center grow" id="date_debut_span">
                        <label for="date_debut_graphe">Date début</label>
                        <input type="date" id="date_debut_graphe" name="date_debut_graphe" class="input" placeholder="Nom du graphique" required>
                    </span>
                    <span class="wrapper axe_ligne main_axe_space_between second_axe_center grow" id="date_fin_span">
                        <label for="date_fin_graphe">Date fin</label>
                        <input type="date" id="date_fin_graphe" name="date_fin_graphe" class="input" placeholder="Nom du graphique" required>
                    </span>
                </div>
                <div class="box_graphe" id="specificite">
                    <h3 class="graphe_categorie bold" id="spécificité graphe">Spécificité</h3>
                </div>
            </div>
        </div>
        <div id="boutons_graphe" class="wrapper axe_ligne gap_left_right_moyen">
            <button title="Ajouter le graphe" id="add_graphe" class="bouton"><i class="fa-solid fa-plus fa-lg"></i></button>
            <button title="Sauvegarder les changements" id="save_graphe" class="bouton"><i class="fa-solid fa-floppy-disk fa-lg"></i></button>
            <button title="Annuler les changements" id="cancel_graphe" class="bouton"><i class="fa-solid fa-xmark fa-lg"></i></button>
            <button title="Supprimer le graphe" id="delete_graphe" class="bouton"><i class="fa-solid fa-trash fa-lg"></i></button>
        </div>
    </section>
    <section class="wrapper axe_colonne second_axe_center width_100 main_axe_space_between" id="contenu">
        <div class="titre_souligne">
            <h1>Statistiques</h1>
        </div>

        <div id="graphes">
            
        </div>

        <div class="center_items_horizontal">
            <button class="bouton bouton_primaire margin_bottom_top_large">Exporter</button>
        </div>
    </section>
</div>
</div>