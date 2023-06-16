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

const typeStatistique = {
    BURGER_VENTE_TOTAL: 1,
    BURGER_VENTE_TEMPS: 2,
    INGREDIENT_ACHAT_TOTAL: 3,
    PRODUIT_ACHAT_TOTAL: 4,
    FOURNISSEUR_ACHAT_TOTAL: 5,
    BENEFICE_TEMPS: 6,
    NOMBRE_CLIENT_TEMPS: 7
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
    $('#graphe_date_personnalise').on('change', updateTemporaryChart);
    $('#graphe_date_debut').on('change', updateTemporaryChart);
    $('#graphe_date_fin').on('change', updateTemporaryChart);
    $('#graphe_type').on('change', updateTemporaryChart);

    // On initialise la page
    initButtons();
    initButtonsSelectionGraphe();
    globalStates(state.DEFAULT);
    $('.menu_graphe_content').hide();
    refreshMenuGauche(false);
});

function checkType() {
    console.log('changeTypeAndUpdate()');
    // on vérifie que c'est pas la valeur par défaut
    if ($('#graphe_type').val() == '') {
        console.log('Type de graphe non valide');
        return false;
    }
    temporaryChart.type = $('#graphe_type').val();
    return true;
}

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
    $('#information').empty();
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
                $('#information').html('Aucun graphe à afficher, veuillez en créer un.');
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
            $('#information').html('Mode création d\'un graphe');
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
            $('#information').html('Mode édition d\'un graphe');
        case state.EXPORT_PDF:
            console.log('state.EXPORT_PDF');
            // On affiche le boutons d'information
            button.INFORMATION.show();
            button.INFORMATION.prop('disabled', false);
            // On ajoute un message pour dire qu'on est en mode exportation d'un graphe
            $('#information').html('Mode export PDF');
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
        temporaryChart.typeStatistique = typeStatistique.BURGER_VENTE_TOTAL;

        // On réactive les boutons de personnalisation et paramétrage des graphes
        button.PERSONNALISATION_GRAPHE.prop('disabled', false);
        button.CONFIGURATION_GRAPHE.prop('disabled', false);

        // On remplie le menu et on met sur l'onglet de personnalisation
        remplirMenuPersonnalisation();
        afficherDate();
        setSpecificiteBurgerVenteTotal();
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
    let grapheNom = $('#graphe_nom')
    if (temporaryChart.nom != null) {
        grapheNom.attr('value', temporaryChart.nom);
    }
    grapheNom.on('input', function () {
        temporaryChart.nom = grapheNom.val();
        temporaryChart.divNom.html(grapheNom.val());
    });

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
function afficherDate() {
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

function checkDateForUpdateChart() {
    console.log("Statistiques.js - checkDateForUpdateChart");
    // Si la case est décoché on update
    if (!$("#graphe_date_personnalise").is(':checked')) {
        return true;
    }
    // Si la case est décoché on vérifie si les dates sont juste
    else {
        // Si les dates sont juste on update
        if (checkDate()) {
            return true;
        }
    }
    return false;
}

function checkDate() {
    console.log("Statistiques.js - checkDate");
    // On récupère les dates
    let dateDebut = $('#graphe_date_debut').val();
    let dateFin = $('#graphe_date_fin').val();
    // On vérifie si les dates sont juste
    if (dateDebut != null && dateFin != null && dateDebut != "" && dateFin != "") {
        // Si la date de début est supérieur à la date de fin
        if (dateDebut > dateFin) {
            // On affiche un message d'erreur
            $('#graphe_date_error').show();
            return false;
        }
        // Si la date de début est inférieur à la date de fin
        else {
            // on vérifie le format
            if (!checkDateFormate(dateDebut) || !checkDateFormate(dateFin)) {
                // On affiche un message d'erreur
                $('#graphe_date_error').show();
                return false;
            }
            // On cache le message d'erreur
            $('#graphe_date_error').hide();
            return true;
        }
    }
    // Si les dates sont null ou vide
    else {
        // On cache le message d'erreur
        $('#graphe_date_error').hide();
        return false;
    }
}

function checkDateFormate(date) {
    console.log("Statistiques.js - checkDateFormate");
    // On vérifie le format
    if (date.match(/^(\d{4})-(\d{2})-(\d{2})$/)) {
        return true;
    }
    return false;
}

function updateTemporaryChart() {
    console.log("Statistiques.js - updateGraphe");
    // on vérifie le type et la date
    if (!checkDateForUpdateChart() || !checkType()) {
        return;
    }

    switch (temporaryChart.typeStatistique) {
        case typeStatistique.BURGER_VENTE_TOTAL:
            getDataBurgerVenteTotal();
            break;
    }
}

function createCharts() {
    console.log("Statistiques.js - createCharts");
    for (var i = 0; i < charts.length; i++) {
        createChart(charts[i]);
    }
}

/**
 * Méthode permettant de mettre à jour le graphe.
 * Exemple de la structure : 
 * <div>
        <div>
            <btn></btn>
            <btn></btn>
        </div>
        <h3></h3>
        <canvas></canvas>
        <p></p>
    </div>
 */
function createChart(chart) {
    console.log("Statistiques.js - createChart");

    // on créer la div principale
    let mainDiv = $('<div>').addClass('graphe');

    // on créer le titre
    let title = $('<h3>').addClass('text-center bold');
    title.html(chart.nom);
    chart.divNom = title;
    mainDiv.append(title);

    // on créer la div contenant les boutons
    let buttonDiv = $('<div>');
    // on créer les boutons
    let buttonModify = $('<button>').addClass('button button_select');
    buttonModify.html('<i class="fa-solid fa-pen"></i>');
    // mettre image / mettre event
    let buttonDelete = $('<button>').addClass('button');
    buttonDelete.html('<i class="fa-solid fa-trash"></i>');

    // mettre image / mettre event
    buttonDiv.append(buttonModify);
    buttonDiv.append(buttonDelete);
    mainDiv.append(buttonDiv);
    
    // on créer un canvas qu'on ajoute à la div
    let canvas = $('<canvas>');
    mainDiv.append(canvas);
    // on créer le paragraphe
    let paragraph = $('<p>').addClass('text-center');
    paragraph.html(chart.description);
    chart.divDescription = paragraph;
    mainDiv.append(paragraph);
    let chartConfig;
    // On ajoute la div principale au DOM
    $('#graphes').append(mainDiv);

    // On configure le graphe en fonction du type de statistique
    switch (chart.typeStatistique) {
        case typeStatistique.BURGER_VENTE_TOTAL:
        case typeStatistique.INGREDIENT_ACHAT_TOTAL:
        case typeStatistique.PRODUIT_ACHAT_TOTAL:
        case typeStatistique.FOURNISSEUR_ACHAT_TOTAL:
            console.log(chart);
            chartConfig = {
                type: chart.type,
                data: {
                    labels: chart.data.labels,
                    datasets: [{
                        label: 'Quantités',
                        data: chart.data.quantities,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };
            break;
    }
    if (chart.data != null) {
        // voir si on peut conserver la config 
        //chartConfig.data = chart.data;
        // let myChart = new Chart(canvas, chartConfig);
        new Chart(canvas, chartConfig);
    } else {
        // on affiche un message d'erreur
        title.text('Erreur');
        paragraph.text('Un problème est survenu lors de la génération du graphe');
    }
}

/*********************************************************************************
 * Méthodes permettant de gérer les spécificités de chaque type de statistique
 * 1 méthode par type de statistique
 ********************************************************************************/

/**
 * Méthode permettant de gérer les spécificités du type de statistique BURGER_VENTE_TOTAL
 */
function setSpecificiteBurgerVenteTotal() {
    // ARCHIVES (Select)
    let divArchives = $('<div>').addClass('wrapper axe_colonne main_axe_space_between');
    let h3LabelArchives = $('<h3>').text('Archives');
    let selectArchives = $('<select>').attr('id', 'graphe_archives');
    selectArchives.addClass('select');
    selectArchives.append($('<option>').attr('value', -1).text('Sans les archives'));
    selectArchives.append($('<option>').attr('value', 0).text('Tous'));
    selectArchives.append($('<option>').attr('value', 1).text('Uniquement les archives'));
    divArchives.append(h3LabelArchives);
    divArchives.append(selectArchives);

    // CHOIX BURGER (Checkbox)
    let divChoixBurger = $('<div>').addClass('wrapper axe_colonne main_axe_space_between');
    let span = $('<span>').addClass('wrapper axe_ligne main_axe_space_between second_axe_center grow');
    let h3Label = $('<h3>').attr('for', 'choix_recette_checkbox').text('Tous les burgers');
    let input = $('<input>').addClass('input').attr({
        'id': 'choix_recette_checkbox',
        'name': 'choix_recette_checkbox',
        'type': 'checkbox',
    });
    span.append(h3Label);
    span.append(input);
    divChoixBurger.append(span);
    input.prop('checked', true);

    // on construit le select 
    let select = $('<select>');
    select.attr('id', 'select_choix_recette');
    select.attr('multiple', 'multiple');
    // on ajoute le select dans la div puis on l'initialise avec select2
    divChoixBurger.append(select);
    select.hide();

    // on ajoute les div au DOM
    let specificite = $('#specificite');
    specificite.append(divArchives);
    specificite.append(divChoixBurger);
    $('#select_choix_recette').select2();

    // on ajoute un écouteur d'évènement sur le checkbox
    input.on('change', function () {
        if ($(this).is(':checked')) {
            $('#select_choix_recette').prop('disabled', true);
            $('#select_choix_recette').select2('destroy');
            $('#select_choix_recette').hide();
        } else {
            $('#select_choix_recette').prop('disabled', false);
            $('#select_choix_recette').select2({
                width: '100%',
                placeholder: 'Sélectionnez une recette',
            }).on('select2:select', function (e) {
                updateTemporaryChart();
            });
        }
        updateTemporaryChart();
    });

    // on ajoute un écouteur d'évènement sur le select
    selectArchives.on('change', function () {
        // on récupère la valeur
        let value = $(this).val();
        // on transforme pour l'envoie en ajax
        let dataToSend = {
            'archives': value
        };
        dataToSend = JSON.stringify(dataToSend);
        $.ajax({
            url: "statistiques/getAllBurgers",
            method: "POST",
            dataType: "json",
            data: {
                dataReceived: dataToSend
            },
            success: function (data) {
                console.log("Statistiques.js - getAllBurgers - success");
                // SELECT2
                // on ajoute comme attr id et multiple
                let select = $('#select_choix_recette');
                select.empty();
                data.forEach(element => {
                    select.append('<option value="' + element.id + '">' + element.nom + '</option>');
                });
                updateTemporaryChart();
            },
            error: function (data) {
                console.log("Statistiques.js - getAllBurgers - error");
                alert("Une erreur est survenue lors de la récupération des recettes.");
            },
        });
    });

    // on met le select archive à la value 0 et on déclanche les évènements
    selectArchives.val(0);
    selectArchives.trigger('change');
    input.trigger('change');
}

/*********************************************************************************
 * Méthodes permettant de récupérer les données du graphe
 * 1 méthode par type de graphe
 ********************************************************************************/

/**
 * Méthode permettant de récupérer les données du graphe de type BURGER_VENTE_TOTAL
 * @returns {}
 */
function getDataBurgerVenteTotal() {
    console.log("Statistiques.js - getDataBurgerVenteTotal");
    let dataResult = null;
    let dataToSend = {};

    // dates
    if ($('#graphe_date_personnalise').is(':checked')) {
        dataToSend.date_all = false;
        dataToSend.date_debut = $('#graphe_date_debut').val();
        dataToSend.date_fin = $('#graphe_date_fin').val();
    } else {
        dataToSend.date_all = true;
    }
    // archives
    dataToSend.archives = $('#choix_archives').is(':checked');
    // listes des burgers
    if ($('#choix_recette_checkbox').is(':checked')) {
        dataToSend.recette_all = true;
    } else {
        dataToSend.recette_all = false;
        dataToSend.recettes = $('#select_choix_recette').val();
    }
    // on récupère la valeur d'archives
    dataToSend.archives = $('#graphe_archives').val();
    dataToSend = JSON.stringify(dataToSend);

    $.ajax({
        url: "statistiques/getDataBurgerVenteTotal",
        method: "POST",
        dataType: "json",
        data: {
            dataReceived: dataToSend
        },
        success: function (data) {
            console.log("Statistiques.js - getDataBurgerVenteTotal - success");

            // on récupère les données
            console.log(data);

            // on boucle sur data avec un foreach
            if (data.length == 0) {
                $('#graphes').empty().html('<h3 class="text-center">Aucune donnée à afficher</h3>');
                temporaryChart.error = true;
                return;
            }
            let labels = [];
            let quantities = [];
            data.forEach(element => {
                labels.push(element.nom);
                quantities.push(element.quantite);
            });
            dataResult = {}
            dataResult.labels = labels;
            dataResult.quantities = quantities;
            temporaryChart.data = dataResult;
            temporaryChart.error = false;
            $('#graphes').empty();
            createChart(temporaryChart);
        },
        error: function (data) {
            console.log("Statistiques.js - getDataBurgerVenteTotal - error");
            alert("Une erreur est survenue lors de la récupération des recettes.");
        },
    });
    return dataResult;
}