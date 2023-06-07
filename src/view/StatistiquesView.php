<!-- on inclut la feuille de style -->
<link rel="stylesheet" href="<?php echo CSS; ?>Statistiques.css">
<!-- bibliothèque pour générer un graphique -->
<script src="<?php echo ASSETS; ?>chartjs/chart.umd.min.js"></script>
<!-- on inclut la feuille js -->
<script src="<?php echo JS; ?>statistiques.js"></script>

<!-- content -->
<div class="wrapper axe_ligne grow">
    <section id="menu_gauche" class="wrapper axe_ligne">
        <!-- Menu des actions rapide (ne se ferme pas) -->
        <div id="menu_action_rapide" class="wrapper axe_colonne main_axe_space_between second_axe_center gap_top_bottom_moyen">
            <div id="boutons_personnalisation" class="wrapper axe_colonne gap_top_bottom_petit"> <!-- permet de choisir la div à afficher -->
                <button title="Ajouter un graphe" id="button_stat_add_graphe" class="bouton boutonStats"><i class="fa-solid fa-plus fa-lg"></i></button>
                <button title="Selection" id="button_stat_selection_graphe" class="bouton boutonStats"><i class="fa-solid fa-chart-simple fa-lg"></i></button>
                <button title="Personnalisation" id="button_stat_personnalisation_graphe" class="bouton boutonStats"><i class="fa-solid fa-hammer fa-lg"></i></button>
                <button title="Configuration" id="button_stat_configuration_graphe" class="bouton boutonStats"><i class="fa-solid fa-gear fa-lg"></i></button>
            </div>
            <div id="boutons_graphe" class="wrapper axe_colonne gap_top_bottom_petit">
                <button title="Sauvegarder les changements" id="button_stat_save_graphe" class="bouton boutonStats"><i class="fa-solid fa-floppy-disk fa-lg"></i></button>
                <button title="Annuler les changements" id="button_stat_cancel_graphe" class="bouton boutonStats"><i class="fa-solid fa-backward fa-lg"></i></button>
                <button title="Supprimer le graphe" id="button_stat_delete_graphe" class="bouton boutonStats"><i class="fa-solid fa-trash fa-lg"></i></button>
                <button title="Exporter en PDF" id="button_stat_export_pdf" class="bouton boutonStats"><i class="fa-solid fa-file-pdf fa-lg"></i></button>
                <button title="Informations" id="button_stat_information" class="bouton boutonStats"><i class="fa-solid fa-circle-info fa-lg"></i></button>
            </div>
        </div>

        <!-- Menu de configuration (se ferme) -->
        <div id="menu_graphe" class="wrapper axe_colonne">
            <button title="Fermer menu" id="button_stat_close_menu_config" class="bouton"><i class="fa-solid fa-xmark fa-xs"></i></button>
            <h3 id='titre_onglet' class="text-center bold"></h3>
            <!-- Menu de choix du type de graphe -->
            <div id="onglet_selection_graphe" class="menu_graphe_content wrapper axe_colonne gap_top_bottom_moyen">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Ventes</h3>
                    <button id="burger_vente_total" class="graphe_choix" type_stat="burger">
                        <p>Burger <span class="font_size_petit">(total)</span></p>
                    </button>
                    <button id="burger_vente_temps" class="graphe_choix" type_stat="burger">
                        <p>Burger <span class="font_size_petit">(évolution dans le temps)</span></p>
                    </button>
                    <button id="ingredient_achat_total" class="graphe_choix" type_stat="ingredient">
                        <p>Ingedient</p>
                    </button>
                </div>

                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Achats</h3>
                    <button id="produit_achat_total" class="graphe_choix" type_stat="produits">
                        <p>Produits</p>
                    </button>
                    <button id="fournisseur_achat_total" class="graphe_choix" type_stat="fournisseurs">
                        <p>Fournisseurs</p>
                    </button>
                </div>

                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Généralités</h3>
                    <button id="benefice_temps" class="graphe_choix" type_stat="benefices">
                        <p>Bénéfices</p>
                    </button>
                    <button id="nombre_client_temps" class="graphe_choix" type_stat="nombre_client">
                        <p>Nombre de client</p>
                    </button>
                </div>
            </div>

            <!-- Menu de personnalisation d'un graphe -->
            <div id="onglet_personnalisation_graphe" class="menu_graphe_content">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Nom</h3>
                    <input type="text" id="graphe_nom" name="nom_graphe" class="input" placeholder="Nom du graphique">
                </div>
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Description</h3>
                    <textarea id="graphe_description" name="description_graphe" class="textarea" placeholder="Description du graphique" minlength=0 maxlength=250></textarea>
                </div>
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Type de graphe</h3>
                    <select id="graphe_type" class="select">
                        <option value="" selected>Choisissez un type de graphique</option>
                    </select>
                </div>
            </div>

            <!-- Menu de configuration d'un graphe -->
            <div id="onglet_configuration_graphe" class="menu_graphe_content">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Date</h3>
                    <span class="wrapper axe_ligne main_axe_space_between second_axe_center grow">
                        <label for="graphe_date_personnalise">Date personnalisé</label>
                        <input class="input" id="graphe_date_personnalise" name="graphe_date_personnalise" type="checkbox">
                    </span>
                    <span class="wrapper axe_colonne main_axe_space_between grow" id="date_debut_span">
                        <label for="graphe_date_debut">Date de début</label>
                        <input type="date" id="graphe_date_debut" name="graphe_date_debut" class="input" placeholder="Nom du graphique" required>
                    </span>
                    <span class="wrapper axe_colonne main_axe_space_between grow" id="date_fin_span">
                        <label for="graphe_date_fin">Date de fin</label>
                        <input type="date" id="graphe_date_fin" name="graphe_date_fin" class="input" placeholder="Nom du graphique" required>
                    </span>
                </div>
                <div class="box_graphe" id="specificite">
                    <h3 class="graphe_categorie bold" id="spécificité graphe">Spécificité</h3>
                </div>
            </div>

            <!-- Menu de confirmation de l'exportation -->
            <div id="onglet_export" class="menu_graphe_content">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold">Nom du fichier</h3>
                    <input type="text" id="nom_fichier_export" name="nom_fichier_export" class="input" placeholder="Nom du fichier">
                </div>
                <button id="button_stat_confirmation_export" class="bouton">Exporter</button>
            </div>

            <!-- Menu de confirmation lambda -->
            <div id="onglet_lambda" class="menu_graphe_content">
                <div class="box_graphe">
                    <h3 class="graphe_categorie bold"></h3>
                    <p id="texte_confirmation"></p>
                </div>
                <button id="button_stat_confirmation_lambda" class="bouton">Confirmer</button>
            </div>
        </div>
    </section>


    <section class="wrapper axe_colonne second_axe_center width_100 gap_top_bottom_moyen" id="contenu">
        <div class="titre_souligne">
            <h1>Statistiques</h1>
        </div>

        <div id="graphes"></div> <!-- div pour contenir les graphes -->
    </section>
</div>
</div>