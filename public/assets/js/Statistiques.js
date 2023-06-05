// CONSTANTES
// Les boutons 
const button = {
    ADD_GRAPHE: null,
    SELECTION_GRAPHE: null,
    CONFIGURATION_GRAPHE: null,
    PERSONNALISATION_GRAPHE: null,
    SAVE_GRAPHE: null,
    CANCEL_GRAPHE: null,
    DELETE_GRAPHE: null,
    EXPORT_PDF: null,
    INFORMATION: null,
    CLOSE_MENU: null
};

const menuGaucheContent = {
    SELECTION_GRAPHE: null,
    CONFIGURATION_GRAPHE: null,
    PERSONNALISATION_GRAPHE: null,
    EXPORT: null,
    LAMBDA: null
};


const actual = {
    BUTTON: null,
    MENU_GAUCHE_CONTENT: null,
}

// Les états
const state = {
    DEFAULT: 1,
    ADD_GRAPHE: 2,
    MODIFY_GRAPHE: 3,
};

// Constantes pour les graphiques
const chartType = {
    BAR: 'bar',
    LINE: 'line',
    PIE: 'pie',
    DOUGHNUT: 'doughnut',
};

const charts = [];
let temporaryChart = {
};

// INITIALISATION
$(document).ready(function () {
    // On initialise les boutons
    button.ADD_GRAPHE = $('#button_stat_add_graphe');
    button.SELECTION_GRAPHE = $('#button_stat_selection_graphe');
    button.PERSONNALISATION_GRAPHE = $('#button_stat_personnalisation_graphe');
    button.CONFIGURATION_GRAPHE = $('#button_stat_configuration_graphe');
    button.SAVE_GRAPHE = $('#button_stat_save_graphe');
    button.CANCEL_GRAPHE = $('#button_stat_cancel_graphe');
    button.DELETE_GRAPHE = $('#button_stat_delete_graphe');
    button.EXPORT_PDF = $('#button_stat_export_pdf');
    button.INFORMATION = $('#button_stat_information');
    button.CLOSE_MENU = $('#button_stat_close_menu_config');

    // On initialise les contenus du menu de gauche
    menuGaucheContent.SELECTION_GRAPHE = $('#onglet_selection_graphe');
    menuGaucheContent.PERSONNALISATION_GRAPHE = $('#onglet_personnalisation_graphe');
    menuGaucheContent.CONFIGURATION_GRAPHE = $('#onglet_configuration_graphe');
    menuGaucheContent.EXPORT = $('#onglet_export');
    menuGaucheContent.LAMBDA = $('#onglet_lambda');

    // on initialise les évènements non initialisés dans des fonctions
    $('#graphe_date_personnalise').on('change', afficherDate);
    $('#graphe_date_personnalise').on('change', createChart);
    $('#graphe_date_debut').on('change', createChart);
    $('#graphe_date_fin').on('change', createChart);

    // On initialise la page
    initButtons();
    initButtonsSelectionGraphe();
    globalStates(state.DEFAULT);
    $('.menu_graphe_content').hide();
    refreshMenuGauche(false);
});

// FONCTIONS PRIMAIRES
/**
 * Méthode qui permet de changer l'état de la page.
 * Facilite la gestion des boutons et du développement.
 * 
 * @param {} currentState 
 */
function globalStates(currentState) {
    console.log('globalStates(' + currentState + ')');
    // On désactive tous les boutons qui ont la classe boutonStats et on les cache
    $('.boutonStats').prop('disabled', true);
    $('.boutonStats').hide();
    // on supprime le contenu de la div des graphes et de temporaryChart
    $('#graphes').empty();
    temporaryChart = {};

    switch (currentState) {
        case state.DEFAULT: // On est dans l'état par défaut ou l'on affiche les graphes s'ils existent
            console.log('state.BASIC_WITHOUT_GRAPHE');
            // On affiche le bouton pour ajouter un graphe et celui d'information et on les active.
            button.ADD_GRAPHE.show();
            button.INFORMATION.show();
            button.ADD_GRAPHE.prop('disabled', false);
            button.INFORMATION.prop('disabled', false);
            if (charts.length < 1) {
                // On ajoute à la div des graphes un message d'information
                $('#graphes').append('<p class="text-center">Aucun graphe à afficher, veuillez en créer un.</p>');
            } else {
                button.EXPORT_PDF.show();
                button.EXPORT_PDF.prop('disabled', false);
                drawCharts();
            }
            break;
        case state.ADD_GRAPHE:
            console.log('state.ADD_GRAPHE');
            // On affiche les boutons de sélection de type de graphe, de paramétrage de graphe, d'annulation et de sauvegarde de graphe et on les active.
            button.SELECTION_GRAPHE.show();
            button.PERSONNALISATION_GRAPHE.show();
            button.CONFIGURATION_GRAPHE.show();
            button.CANCEL_GRAPHE.show();
            button.SAVE_GRAPHE.show();
            button.INFORMATION.show();
            button.SELECTION_GRAPHE.prop('disabled', false);
            button.CANCEL_GRAPHE.prop('disabled', false);
            button.SAVE_GRAPHE.prop('disabled', false);
            button.INFORMATION.prop('disabled', false);
            // On ajoute un message pour dire qu'on est en mode création d'un graphe
            $('#graphes').append('<p class="text-center">Mode création d\'un graphe</p>');
            button.SELECTION_GRAPHE.click();
            break;
        case state.MODIFY_GRAPHE:
            console.log('state.MODIFY_GRAPHE');
            button.SELECTION_GRAPHE.show();
            button.PERSONNALISATION_GRAPHE.show();
            button.CONFIGURATION_GRAPHE.show();
            button.INFORMATION.show();
            button.CANCEL_GRAPHE.show();
            button.DELETE_GRAPHE.show();
            button.SAVE_GRAPHE.show();
            button.SELECTION_GRAPHE.prop('disabled', false);
            button.PERSONNALISATION_GRAPHE.prop('disabled', false);
            button.CONFIGURATION_GRAPHE.prop('disabled', false);
            button.INFORMATION.prop('disabled', false);
            button.CANCEL_GRAPHE.prop('disabled', false);
            button.DELETE_GRAPHE.prop('disabled', false);
            button.SAVE_GRAPHE.prop('disabled', false);
            // On ajoute un message pour dire qu'on est en mode édition d'un graphe
            $('#graphes').append('<p class="text-center">Mode édition d\'un graphe</p>');
        case state.EXPORT_PDF:
            console.log('state.EXPORT_PDF');
            // On affiche le boutons d'information
            button.INFORMATION.show();
            button.INFORMATION.prop('disabled', false);
            // On ajoute un message pour dire qu'on est en mode exportation d'un graphe
            $('#graphes').append('<p class="text-center">Mode export PDF</p>');
    }
}

/**
 * Méthode qui permet d'intialiser les boutons de la page.
 */
function initButtons() {
    // Bouton d'ajout de graphe
    button.ADD_GRAPHE.click(function () {
        console.log('button_stat_add_graphe clicked');
        globalStates(state.ADD_GRAPHE);
    });

    // bouton de selection de type de graphe
    button.SELECTION_GRAPHE.click(function () {
        console.log('button_stat_selection_graphe clicked');
        buttonSelectEffect(button.SELECTION_GRAPHE, 'fbe272');
        selectMenuGaucheContent(menuGaucheContent.SELECTION_GRAPHE);
        $("#titre_onglet").html("Sélection");
    });

    // Bouton de modification de graphe
    button.PERSONNALISATION_GRAPHE.click(function () {
        console.log('button_stat_personnalisation_graphe clicked');
        buttonSelectEffect(button.PERSONNALISATION_GRAPHE, 'fbe272');
        selectMenuGaucheContent(menuGaucheContent.PERSONNALISATION_GRAPHE);
        $("#titre_onglet").html("Personnalisation");
    });

    // Bouton de paramétrage de graphe
    button.CONFIGURATION_GRAPHE.click(function () {
        console.log('button_stat_configuration_graphe clicked');
        buttonSelectEffect(button.CONFIGURATION_GRAPHE, 'fbe272');
        selectMenuGaucheContent(menuGaucheContent.CONFIGURATION_GRAPHE);
        $("#titre_onglet").html("Paramétrage");
    });

    // Bouton d'information
    button.INFORMATION.click(function () {
        // si on clique sur le bouton on envoie sur google
        window.open('https://media.licdn.com/dms/image/C5603AQGe_mt1Iw1mJQ/profile-displayphoto-shrink_800_800/0/1517398409444?e=2147483647&v=beta&t=UBekPWfLXStE58ZGnuqGEREfl-3UqcMH0ggi4_9zDOY');
    });

    // Bouton de sauvegarde de graphe
    button.SAVE_GRAPHE.click(function () {
    });

    // bouton d'annulation
    button.CANCEL_GRAPHE.click(function () {
    });

    // Bouton de suppression de graphe
    button.DELETE_GRAPHE.click(function () {
    });

    // Bouton d'export du document
    button.EXPORT_PDF.click(function () {
    });

    // Bouton pour fermer le menu gauche
    button.CLOSE_MENU.click(function () {
        refreshMenuGauche(false);
        buttonSelectEffect(null, null);
    });
}

function initButtonsSelectionGraphe() {
    $('#burger_vente_total').click(function () {
        console.log('burger_vente_total clicked');
        // On initialise le graphe avec les données de base
        $('#burger_vente_total').addClass('selected');
        temporaryChart.nom = 'Burger vente total';
        temporaryChart.description = 'Statistiques de la vente total des burgers';
        temporaryChart.type = chartType.BAR;
        temporaryChart.typePossible = [chartType.BAR, chartType.DOUGHNUT, chartType.PIE];
        // Voir pour mettre la spécificité des données

        // On réactive les boutons de personnalisation et paramétrage des graphes
        button.PERSONNALISATION_GRAPHE.prop('disabled', false);
        button.CONFIGURATION_GRAPHE.prop('disabled', false);

        // On remplie le menu et on met sur l'onglet de personnalisation
        remplirMenuPersonnalisation();
        afficherDate();
        button.PERSONNALISATION_GRAPHE.click();
    });

    $('#burger_vente_temps').click(function () {
        console.log('burger_vente_temps clicked');
    });

    $('#ingredient_achat_total').click(function () {
    });

    $('#produit_achat_total').click(function () {
    });

    $('#fournisseur_achat_total').click(function () {
    });

    $('#benefice_temps').click(function () {
    });

    $('#nombre_client_temps').click(function () {
    });
}

/**
 * Méthode permettant de mettre en surbrillance le bouton passé en paramètre et de désélectionner le précédent.
 * Actualise la variable actual.BUTTON avec le bouton passé en paramètre.
 * 
 * @param {} button bouton à mettre en surbrillance
 * @param {} color couleur en hexa
 */
function buttonSelectEffect(button, color) {
    // on s'occupe de l'ancien bouton
    if (actual.BUTTON != null) {
        actual.BUTTON.removeClass('button_select');
        actual.BUTTON.css('background-color', '');
    }
    // on s'occupe du nouveau bouton
    if (button != null) {
        actual.BUTTON = button;
        button.addClass('button_select');
        button.css('background-color', '#' + color);
    }
}

function selectMenuGaucheContent(content) {
    // On active le menu gauche
    refreshMenuGauche(true);
    // On s'occupe de l'ancien contenu
    if (actual.MENU_GAUCHE_CONTENT != null) {
        actual.MENU_GAUCHE_CONTENT.hide();
    }
    // On s'occupe du nouveau contenu
    actual.MENU_GAUCHE_CONTENT = content;
    content.show();
}

function refreshMenuGauche(boolean) {
    if (boolean) {
        $('#menu_gauche').addClass('show_menu_graphe');
        $('#menu_gauche').removeClass('dont_show_menu_graphe');
        $('#menu_graphe').show();
    } else {
        $('#menu_graphe').hide();
        $('#menu_gauche').addClass('dont_show_menu_graphe');
        $('#menu_gauche').removeClass('show_menu_graphe');
    }
}

function remplirMenuPersonnalisation() {
    console.log(temporaryChart);
    // MENU - PERSONNALISATION
    if (temporaryChart.nom != null) {
        $('#graphe_nom').attr('value', temporaryChart.nom);
    }
    if (temporaryChart.description != null) {
        $('#graphe_description').val(temporaryChart.description);
    }
    // on génère le select
    let select = $("#graphe_type");
    if (temporaryChart.typePossible != null) {
        for (var i = 0; i < temporaryChart.typePossible.length; i++) {
            select.append('<option value="' + temporaryChart.typePossible[i] + '">' + temporaryChart.typePossible[i] + '</option>');
        }
    }

    if (temporaryChart.type != null) {
        console.log('temporaryChart.type : ' + temporaryChart.type);
        // on sélectionne le type du graphe
        select.val(temporaryChart.type);
    }
}

/**
 * Méthode permettant d'activer/désactiver le module de date personnalisé. Si date personnalisé pas coché, on prend depuis toujours.
 */
function afficherDate () {
    console.log("Statistiques.js - afficherDate");
    // si la case est coché on affiche le champ date et on réactive le bouton
    if ($(this).is(':checked')) {
        $('#date_debut_span').show();
        $('#date_fin_span').show();
        $('#graphe_date_debut').prop('disabled', false);
        $('#graphe_date_fin').prop('disabled', false);
    }
    // sinon on le cache et on désactive le bouton
    else {
        $('#date_debut_span').hide();
        $('#date_fin_span').hide();
        $('#graphe_date_debut').prop('disabled', true);
        $('#graphe_date_fin').prop('disabled', true);
    }
}

function updateChart() {
    console.log("Statistiques.js - updateGraphe");
    let data;
    switch (temporaryChart.typeStatistique) {
    }

    if (data === null) {
        console.log("Statistiques.js - updateGraphe - data null");
        $('#graphes').append('<p class="text-center">Un problème est survenu lors de la récupération des données du graphe</p>');
        return;
    }
    temporaryChart.data = data;
    createChart(temporaryChart);
}

function createCharts() {
    console.log("Statistiques.js - createCharts");
    for (var i = 0; i < charts.length; i++) {
        createChart(charts[i]);
    }
}

/**
 * Méthode permettant de mettre à jour le graphe
 */
function createChart($chart) {
    console.log("Statistiques.js - createChart");
    // On récupère les données
    let data = getData();
    // On met à jour le graphe
    chart.update(data);
}