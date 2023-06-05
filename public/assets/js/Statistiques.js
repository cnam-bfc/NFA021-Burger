// CONSTANTES
// Les boutons 
const button = {
    ADD_GRAPHE: null,
    SELECTION_GRAPHE: null,
    CONFIGURATION_GRAPHE: null,
    PARAMETRAGE_GRAPHE: null,
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
    PARAMETRAGE_GRAPHE: null,
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
    bar: 'bar',
    line: 'line',
    pie: 'pie',
    doughnut: 'doughnut',
};

const charts = [];
let temporyChart = {
};

// INITIALISATION
$(document).ready(function () {
    // On initialise les boutons
    button.ADD_GRAPHE = $('#button_stat_add_graphe');
    button.SELECTION_GRAPHE = $('#button_stat_selection_graphe');
    button.CONFIGURATION_GRAPHE = $('#button_stat_configuration_graphe');
    button.PARAMETRAGE_GRAPHE = $('#button_stat_parametrage_graphe');
    button.SAVE_GRAPHE = $('#button_stat_save_graphe');
    button.CANCEL_GRAPHE = $('#button_stat_cancel_graphe');
    button.DELETE_GRAPHE = $('#button_stat_delete_graphe');
    button.EXPORT_PDF = $('#button_stat_export_pdf');
    button.INFORMATION = $('#button_stat_information');
    button.CLOSE_MENU = $('#button_stat_close_menu_config');

    // On initialise les contenus du menu de gauche
    menuGaucheContent.SELECTION_GRAPHE = $('#ongletSelectionGraphe');
    menuGaucheContent.CONFIGURATION_GRAPHE = $('#ongletConfigurationGraphe');
    menuGaucheContent.PARAMETRAGE_GRAPHE = $('#ongletParametrageGraphe');
    menuGaucheContent.EXPORT = $('#ongletConfirmationExport');
    menuGaucheContent.LAMBDA = $('#ongletConfirmationLambda');

    // On initialise la page
    initButtons();
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
    temporyChart = {};

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
            button.PARAMETRAGE_GRAPHE.show();
            button.CONFIGURATION_GRAPHE.show();
            button.CANCEL_GRAPHE.show();
            button.SAVE_GRAPHE.show();
            button.INFORMATION.show();
            button.SELECTION_GRAPHE.prop('disabled', false);
            button.PARAMETRAGE_GRAPHE.prop('disabled', false);
            button.CONFIGURATION_GRAPHE.prop('disabled', false);
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
            button.PARAMETRAGE_GRAPHE.show();
            button.CONFIGURATION_GRAPHE.show();
            button.INFORMATION.show();
            button.CANCEL_GRAPHE.show();
            button.DELETE_GRAPHE.show();
            button.SAVE_GRAPHE.show();
            button.SELECTION_GRAPHE.prop('disabled', false);
            button.PARAMETRAGE_GRAPHE.prop('disabled', false);
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
    $('#button_stat_add_graphe').click(function () {
        console.log('button_stat_add_graphe clicked');
        globalStates(state.ADD_GRAPHE);
    });

    // bouton de selection de type de graphe
    $('#button_stat_selection_graphe').click(function () {
        console.log('button_stat_selection_graphe clicked');
        buttonSelectEffect(button.SELECTION_GRAPHE, 'fbe272');
        selectMenuGaucheContent(menuGaucheContent.SELECTION_GRAPHE);
        $("#titre_onglet").html("Sélection");
    });

    // Bouton de modification de graphe
    $('#button_stat_modify_graphe').click(function () {
    });

    // Bouton de paramétrage de graphe
    $('#button_stat_configuration_graphe').click(function () {
    });

    // Bouton d'information
    $('#button_stat_information').click(function () {
        // si on clique sur le bouton on envoie sur google
        window.open('https://media.licdn.com/dms/image/C5603AQGe_mt1Iw1mJQ/profile-displayphoto-shrink_800_800/0/1517398409444?e=2147483647&v=beta&t=UBekPWfLXStE58ZGnuqGEREfl-3UqcMH0ggi4_9zDOY');
    });

    // Bouton de sauvegarde de graphe
    $('#button_stat_save_graphe').click(function () {
    });

    // bouton d'annulation
    $('#button_stat_cancel_graphe').click(function () {
    });

    // Bouton de suppression de graphe
    $('#button_stat_delete_graphe').click(function () {
    });

    // Bouton d'export du document
    $('#button_stat_export_pdf').click(function () {
    });

    // Bouton pour fermer le menu gauche
    button.CLOSE_MENU.click(function () {
        refreshMenuGauche(false);
        buttonSelectEffect(null, null);
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
    button.css('background-color', '#'+color);
    }
}

function selectMenuGaucheContent (content) {
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