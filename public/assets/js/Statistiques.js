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

// Les différents contenus du menu de gauche affichable
const menuGaucheContent = {
    SELECTION_GRAPHE: null,
    CONFIGURATION_GRAPHE: null,
    PERSONNALISATION_GRAPHE: null,
    EXPORT: null,
    LAMBDA: null
};

// Les différents types de statistiques
const typeStatistique = {
    BURGER_VENTE_TOTAL: 1,
    BURGER_VENTE_TEMPS: 2,
    INGREDIENT_ACHAT_TOTAL: 3,
    PRODUIT_ACHAT_TOTAL: 4,
    FOURNISSEUR_ACHAT_TOTAL: 5,
    BENEFICE_TEMPS: 6,
    NOMBRE_CLIENT_TEMPS: 7
};

// Les différents types de graphiques
const actual = {
    BUTTON: null,
    MENU_GAUCHE_CONTENT: null,
    CURRENT_STATE: null,
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
let temporaryChart = {};
let modifyChartSelectedType = null;
let modifyChartSelected = null;

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
    $('#graphesTemp').empty();
    $('#information').empty();
    temporaryChart = {};

    // On retire les classes actives des seleciton de graphe
    $('.graphe_choix').removeClass('selected');

    // On ajoute display none à la classe boutonRapideGraphe
    $('.boutonRapideGraphe').addClass('boutonRapideGrapheHide');
    $('.boutonRapideGraphe').removeClass('boutonRapideGrapheShow');

    switch (currentState) {
        case state.DEFAULT: // On est dans l'état par défaut ou l'on affiche les graphes s'ils existent
            console.log('state.DEFAULT');
            actual.CURRENT_STATE = state.DEFAULT;
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
                createCharts();
            }
            $('.boutonRapideGraphe').removeClass('boutonRapideGrapheHide');
            $('.boutonRapideGraphe').addClass('boutonRapideGrapheShow');
            break;
        case state.ADD_GRAPHE:
            console.log('state.ADD_GRAPHE');
            actual.CURRENT_STATE = state.ADD_GRAPHE;
            // On affiche les boutons de sélection de type de graphe, de paramétrage de graphe, d'annulation et de sauvegarde de graphe et on les active.
            button.SELECTION_GRAPHE.show();
            button.PERSONNALISATION_GRAPHE.show();
            button.CONFIGURATION_GRAPHE.show();
            button.CANCEL_GRAPHE.show();
            button.SAVE_GRAPHE.show();
            button.INFORMATION.show();
            button.SELECTION_GRAPHE.prop('disabled', false);
            button.CANCEL_GRAPHE.prop('disabled', false);
            button.INFORMATION.prop('disabled', false);
            // On ajoute un message pour dire qu'on est en mode création d'un graphe
            $('#information').html('Mode création d\'un graphe');
            button.SELECTION_GRAPHE.click();
            break;
        case state.MODIFY_GRAPHE:
            console.log('state.MODIFY_GRAPHE');
            actual.CURRENT_STATE = state.MODIFY_GRAPHE;
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

            // On remplie le menu et on met sur l'onglet de personnalisation
            resetMenuGraphes();
            temporaryChart = modifyChartSelected;
            remplirMenuPersonnalisation();
            remplirDates();
            afficherDate();
            switch (temporaryChart.typeStatistique) {
                case typeStatistique.BURGER_VENTE_TOTAL:
                    setSpecificiteBurgerVenteTotal();
                    break;
                case typeStatistique.BURGER_VENTE_TEMPS:
                    setSpecificiteBurgerVenteTemps();
                    break;
            }
            if (modifyChartSelectedType == 'delete') {
                button.DELETE_GRAPHE.click();
            } else if (modifyChartSelectedType == 'modify') {
                button.PERSONNALISATION_GRAPHE.click();
            }
            break;
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
        console.log('button_stat_save_graphe clicked');
        buttonSelectEffect(button.SAVE_GRAPHE, 'fbe272');
        let textP = "Voulez-vous sauvegarder le graphe ?";
        let buttonYes = "Confirmer";
        let functionYes = function () {
            console.log('button_stat_save_graphe yes clicked');

            // on vérifie si le graphe existe déjà dans le tableau
            if (!charts.includes(temporaryChart)) {
                // On sauvegarde le graphe
                charts[charts.length] = temporaryChart;
            }
            // On ferme le menu gauche
            refreshMenuGauche(false);
            // On désactive les boutons
            buttonSelectEffect(null, null);
            globalStates(state.DEFAULT)
        };
        personnaliserMenuGaucheLambda(textP, buttonYes, functionYes, null, null);
        selectMenuGaucheContent(menuGaucheContent.LAMBDA);
        $("#titre_onglet").html("Sauvegarde");
    });

    // bouton d'annulation
    button.CANCEL_GRAPHE.click(function () {
        console.log('button_stat_cancel_graphe clicked');
        buttonSelectEffect(button.SAVE_GRAPHE, 'fbe272');
        let textP = "Voulez-vous annuler tous vos changements ?";
        let buttonYes = "Confirmer";
        let functionYes = function () {
            console.log('button_stat_cancel_graphe yes clicked');
            // On ferme le menu gauche
            refreshMenuGauche(false);
            // On désactive les boutons
            buttonSelectEffect(null, null);
            globalStates(state.DEFAULT)
        };
        personnaliserMenuGaucheLambda(textP, buttonYes, functionYes, null, null);
        selectMenuGaucheContent(menuGaucheContent.LAMBDA);
        $("#titre_onglet").html("Annulation");
    });

    // Bouton de suppression de graphe
    button.DELETE_GRAPHE.click(function () {
        console.log('button_stat_delete_graphe clicked');
        buttonSelectEffect(button.DELETE_GRAPHE, 'fbe272');
        let textP = "Voulez-vous supprimer le graphe ?";
        let buttonYes = "Confirmer";
        let functionYes = function () {
            console.log('button_stat_delete_graphe yes clicked');
            // On supprime le graphe
            charts.splice(charts.indexOf(temporaryChart), 1);
            // On ferme le menu gauche
            refreshMenuGauche(false);
            // On désactive les boutons
            buttonSelectEffect(null, null);
            globalStates(state.DEFAULT)
        };
        personnaliserMenuGaucheLambda(textP, buttonYes, functionYes, null, null);
        selectMenuGaucheContent(menuGaucheContent.LAMBDA);
        $("#titre_onglet").html("Suppression");
    });

    // Bouton d'export du document
    button.EXPORT_PDF.click(function () {
        console.log('button_stat_export_pdf clicked');
        $('.boutonRapideGraphe').addClass('boutonRapideGrapheHide');
        $('.boutonRapideGraphe').removeClass('boutonRapideGrapheShow');
        buttonSelectEffect(button.EXPORT_PDF, 'fbe272');
        selectMenuGaucheContent(menuGaucheContent.EXPORT);
        $("#titre_onglet").html("Export");
        // On exporte en pdf la div graphe avec la biliothèque jsPDF avec le nom dans le champ le texte du champs #nom_fichier_export
        $('#button_stat_confirmation_export').click(function () {
            console.log('button_stat_confirmation_export clicked');
            let divExport = document.querySelector('#graphes');

            let dimensionsDiv = divExport.getBoundingClientRect();
            let divWidth = dimensionsDiv.width;
            let divHeight = dimensionsDiv.height;

            //On capture le contenu HTML dans une image
            html2canvas(divExport).then(function (canvas) {
                let imgData = canvas.toDataURL('image/png');

                let pdf = new jsPDF();

                //On juste la taille de l'image
                let imageWidth = divWidth * 0.3;
                let imageHeight = divHeight * 0.3;

                //On centre l'image
                let pageWidth = pdf.internal.pageSize.getWidth();
                let pageHeight = pdf.internal.pageSize.getHeight();
                let xPos = (pageWidth - imageWidth) / 2;
                let yPos = (pageHeight - imageHeight) / 2;

                //On ajoute l'image capturée au document PDF en utilisant les coordonnées centrées
                pdf.addImage(imgData, 'PNG', xPos, yPos, imageWidth, imageHeight);

                //On enregistre le fichier PDF
                // on récupère le nom du pdf dans le champ #nom_fichier_export
                let nomFichier = $('#nom_fichier_export').val();
                if (nomFichier === "") {
                    nomFichier = "statistiques";
                }
                pdf.save(nomFichier + '.pdf');
            });
        });

        // Bouton pour annuler
        $('#button_stat_annulation_export').click(function () {
            console.log('button_stat_annulation_export clicked');
            refreshMenuGauche(false);
            buttonSelectEffect(null, null);
            $('.boutonRapideGraphe').removeClass('boutonRapideGrapheHide');
            $('.boutonRapideGraphe').addClass('boutonRapideGrapheShow');
        });

    });

    // Bouton pour fermer le menu gauche
    button.CLOSE_MENU.click(function () {
        refreshMenuGauche(false);
        buttonSelectEffect(null, null);
    });
}

function resetMenuGraphes() {
    // On réinitialise les spécificités
    $('#specificite').empty();
    // on créer : <h3 class="graphe_categorie bold" id="spécificité graphe">Spécificité</h3>
    let h3 = $('<h3></h3>');
    h3.addClass('graphe_categorie bold');
    h3.attr('id', 'spécificité graphe');
    h3.html('Spécificité');
    $('#specificite').append(h3);
}


function initButtonsSelectionGraphe() {
    $('#burger_vente_total').click(function () {
        console.log('burger_vente_total clicked');
        // On initialise le graphe avec les données de base
        $('#graphesTemp').empty();
        $('.graphe_choix').removeClass('selected');
        $('#burger_vente_total').addClass('selected');
        temporaryChart.nom = 'Burger vente total';
        temporaryChart.description = 'Statistiques de la vente total des burgers';
        temporaryChart.type = chartType.BAR;
        temporaryChart.typePossible = [chartType.BAR, chartType.DOUGHNUT, chartType.PIE];
        temporaryChart.typeStatistique = typeStatistique.BURGER_VENTE_TOTAL;

        // On réactive les boutons de personnalisation et paramétrage des graphes
        button.PERSONNALISATION_GRAPHE.prop('disabled', false);
        button.CONFIGURATION_GRAPHE.prop('disabled', false);
        button.SAVE_GRAPHE.prop('disabled', false);

        // On remplie le menu et on met sur l'onglet de personnalisation
        resetMenuGraphes();
        remplirMenuPersonnalisation();
        remplirDates();
        afficherDate();
        setSpecificiteBurgerVenteTotal();
        button.PERSONNALISATION_GRAPHE.click();
    });

    $('#burger_vente_temps').click(function () {
        console.log('burger_vente_temps clicked');
        // On initialise le graphe avec les données de base
        $('#graphesTemp').empty();
        $('.graphe_choix').removeClass('selected');
        $('#burger_vente_temps').addClass('selected');
        temporaryChart.nom = 'Burger vente temps';
        temporaryChart.description = 'Statistiques de la vente sur le temps des burgers';
        temporaryChart.type = chartType.LINE;
        temporaryChart.typePossible = [chartType.LINE];
        temporaryChart.typeStatistique = typeStatistique.BURGER_VENTE_TEMPS;

        // On réactive les boutons de personnalisation et paramétrage des graphes
        button.PERSONNALISATION_GRAPHE.prop('disabled', false);
        button.CONFIGURATION_GRAPHE.prop('disabled', false);
        button.SAVE_GRAPHE.prop('disabled', false);

        // On remplie le menu et on met sur l'onglet de personnalisation
        resetMenuGraphes();
        remplirMenuPersonnalisation();
        remplirDates();
        afficherDate();
        setSpecificiteBurgerVenteTemps();
        button.PERSONNALISATION_GRAPHE.click();
    });

    $('#ingredient_achat_total').click(function () {
    });

    $('#produit_achat_total').click(function () {
    });

    $('#fournisseur_achat_total').click(function () {
        console.log('fournisseur_achat_total clicked');
        // On initialise le graphe avec les données de base
        $('#graphesTemp').empty();
        $('.graphe_choix').removeClass('selected');
        $('#fournisseur_achat_total').addClass('selected');
        temporaryChart.nom = 'Fournisseur achat total';
        temporaryChart.description = 'Statistiques représentant le nombre de commande passées par fournisseur';
        temporaryChart.type = chartType.BAR;
        temporaryChart.typePossible = [chartType.BAR, chartType.DOUGHNUT, chartType.PIE];
        temporaryChart.typeStatistique = typeStatistique.FOURNISSEUR_ACHAT_TOTAL;

        // On réactive les boutons de personnalisation et paramétrage des graphes
        button.PERSONNALISATION_GRAPHE.prop('disabled', false);
        button.CONFIGURATION_GRAPHE.prop('disabled', false);
        button.SAVE_GRAPHE.prop('disabled', false);

        // On remplie le menu et on met sur l'onglet de personnalisation
        resetMenuGraphes();
        remplirMenuPersonnalisation();
        remplirDates();
        afficherDate();
        setSpecificiteFournisseurAchatTotal();
        button.PERSONNALISATION_GRAPHE.click();
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

function personnaliserMenuGaucheLambda(textP, textButtonActionUn, fonctionButtonActionUn, textButtonActionDeux, fonctionButtonActionDeux) {
    let paragraphe = $('#texte_paragraphe_lambda');
    let boutonActionUn = $('#button_stat_action_un_lambda');
    let boutonActionDeux = $('#button_stat_action_deux_lambda');
    // On reset tout
    paragraphe.html('');
    boutonActionUn.html('');
    boutonActionUn.off('click');
    boutonActionDeux.html('');
    boutonActionDeux.off('click');
    // On met le texte
    paragraphe.html(textP);
    // On met le bouton 1
    boutonActionUn.html(textButtonActionUn);
    boutonActionUn.click(fonctionButtonActionUn);
    // On met le bouton 2
    if (textButtonActionDeux == null || fonctionButtonActionDeux == null) {
        // Faire le menu gauche
        boutonActionDeux.html("Annuler");
        boutonActionDeux.click(function () {
            refreshMenuGauche(false);
            buttonSelectEffect(null, null);
        });
    } else {
        boutonActionDeux.html(textButtonActionDeux);
        boutonActionDeux.click(fonctionButtonActionDeux);
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


    let grapheDescription = $('#graphe_description');
    if (temporaryChart.description != null) {
        grapheDescription.val(temporaryChart.description);
    }
    grapheDescription.on('input', function () {
        temporaryChart.description = grapheDescription.val();
        temporaryChart.divDescription.html(grapheDescription.val());
    });

    // on génère le select
    let select = $("#graphe_type");
    select.empty();
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

function remplirDates() {
    console.log("Statistiques.js - remplirDates");
    // on récupère les dates
    if (temporaryChart.datePersonnalise) {
        $("#graphe_date_personnalise").prop('checked', true);
    } else {
        $("#graphe_date_personnalise").prop('checked', false);
    }
    if (temporaryChart.dateDebut != null) {
        $("#graphe_date_debut").val(temporaryChart.dateDebut);
    } else {
        $("#graphe_date_debut").val("");
    }
    if (temporaryChart.dateFin != null) {
        $("#graphe_date_fin").val(temporaryChart.dateFin);
    } else {
        $("#graphe_date_fin").val("");
    }
}

/**
 * Méthode permettant d'activer/désactiver le module de date personnalisé. Si date personnalisé pas coché, on prend depuis toujours.
 */
function afficherDate() {
    console.log("Statistiques.js - afficherDate");
    // si la case est coché on affiche le champ date et on réactive le bouton
    if ($("#graphe_date_personnalise").is(':checked')) {
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

/**
 * Méthode permettant de vérifier si la date est au bon format et comprise dans le bon format 
 * 
 * 1 -> jour
 * 2 -> mois
 * 3 -> année
 * @returns {boolean} true si la date est au bon format, false sinon
 */
function checkDateWithIntervalle(minIntervalle, maxIntervalle) {
    if (!$("#graphe_date_personnalise").is(':checked')) {
        return true;
    }
    if (!checkDate()) {
        return false;
    }
    let intervalChoisi = $('#graphe_intervalle_temps').val();
    let dateDebut = moment($('#graphe_date_debut').val());
    let dateFin = moment($('#graphe_date_fin').val());

    switch (intervalChoisi) {
        case '0':
            // On regarde si le nombre de jour est compris dans l'intervalle
            if (dateFin.diff(dateDebut, 'days') >= minIntervalle && dateFin.diff(dateDebut, 'days') <= maxIntervalle) {
                return true;
            }
            break;
        case '1':
            // On regarde si le nombre de mois est compris dans l'intervalle
            if (dateFin.diff(dateDebut, 'months') >= minIntervalle && dateFin.diff(dateDebut, 'months') <= maxIntervalle) {
                console.log('debug : ' + dateFin.diff(dateDebut, 'months'));
                console.log('debug : ' + dateFin.diff(dateDebut, 'months'));
                return true;
            }
            break;
        case '2':
            // On regarde si le nombre d'années est compris dans l'intervalle
            if (dateFin.diff(dateDebut, 'years') >= minIntervalle && dateFin.diff(dateDebut, 'years') <= maxIntervalle) {
                return true;
            }
            break;
        default:
            return false;
    }
    return false;
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
    if (temporaryChart.typeStatistique == typeStatistique.BURGER_VENTE_TEMPS) {
        // on vérifie le type
        if (!checkDateWithIntervalle(temporaryChart.specificite.minIntervalleTemps, temporaryChart.specificite.maxIntervalleTemps)) {
            console.log('min : ' + temporaryChart.specificite.minIntervalleTemps + ' max : ' + temporaryChart.specificite.maxIntervalleTemps)
            button.SAVE_GRAPHE.prop('disabled', true);
            $('#date_perso_message').text('Veuillez remplir les champs correctement.');
            $('#date_perso_message').show();
            $('#graphesTemp').empty().append($('<p>').text('Veuillez vérifier les dates.'));
            return;
        }
    } else {
        // on vérifie le type et la date
        if (!checkDateForUpdateChart()) {
            button.SAVE_GRAPHE.prop('disabled', true);
            $('#date_perso_message').text('Veuillez remplir les champs correctement.');
            $('#date_perso_message').show();
            $('#graphesTemp').empty().append($('<p>').text('Veuillez vérifier les dates.'));
            return;
        }
    }

    if (!checkType()) {
        button.SAVE_GRAPHE.prop('disabled', true);
        $('#date_perso_message').text('Veuillez remplir les champs correctement.');
        $('#date_perso_message').show();
        return;
    }

    $('#date_perso_message').hide();
    $('#date_perso_message').empty();
    temporaryChart.datePersonnalise = $("#graphe_date_personnalise").is(':checked');
    temporaryChart.dateDebut = $('#graphe_date_debut').val();
    temporaryChart.dateFin = $('#graphe_date_fin').val();

    switch (temporaryChart.typeStatistique) {
        case typeStatistique.BURGER_VENTE_TOTAL:
            getDataBurgerVenteTotal();
            break;
        case typeStatistique.BURGER_VENTE_TEMPS:
            // On vérifie que le select comporte bien au moins un burger
            if ($('#select_choix_recette').val() == null || $('#select_choix_recette').val().length == 0) {
                button.SAVE_GRAPHE.prop('disabled', true);
                return;
            }
            getDataBurgerVenteTemps();
            break;
    }
    button.SAVE_GRAPHE.prop('disabled', false);
}

function createCharts() {
    console.log("Statistiques.js - createCharts");
    // on regarde la longueur de charts
    let plusieursGraphs;
    charts.length > 1 ? plusieursGraphs = true : plusieursGraphs = false;
    for (var i = 0; i < charts.length; i++) {
        createChart(charts[i]);
        if (plusieursGraphs && i != charts.length - 1) {
            $('#graphes').append($('<hr>').addClass('delimitation_trait'));
        }
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
    let buttonDiv = $('<div>').addClass('boutonRapideGraphe boutonRapideGrapheHide');
    // on créer les boutons
    let buttonModify = $('<button>').addClass('button');
    buttonModify.html('<i class="fa-solid fa-pen"></i>');
    buttonModify.click(function () {
        modifyChartSelected = chart;
        modifyChartSelectedType = 'modify';
        globalStates(state.MODIFY_GRAPHE);
    });
    // mettre image / mettre event
    let buttonDelete = $('<button>').addClass('button');
    buttonDelete.html('<i class="fa-solid fa-trash"></i>');
    buttonDelete.click(function () {
        modifyChartSelected = chart;
        modifyChartSelectedType = 'delete';
        globalStates(state.MODIFY_GRAPHE);
    });

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
    if (chart != temporaryChart) {
        $('#graphes').append(mainDiv);
    } else {
        $('#graphesTemp').append(mainDiv);
    }

    // On configure le graphe en fonction du type de statistique
    switch (chart.typeStatistique) {
        case typeStatistique.BURGER_VENTE_TOTAL:
        case typeStatistique.INGREDIENT_ACHAT_TOTAL:
        case typeStatistique.PRODUIT_ACHAT_TOTAL:
        case typeStatistique.FOURNISSEUR_ACHAT_TOTAL:
            console.log(chart);
            if (chart.type == chartType.DOUGHNUT || chart.type == chartType.PIE) {
                chartConfig = {
                    type: chart.type,
                    plugins: [ChartDataLabels],
                    data: {
                        labels: chart.data.labels,
                        datasets: [{
                            label: 'Quantités',
                            data: chart.data.quantities,
                            backgroundColor: ['#FFB1C1', '#FFD1B1', '#FFF1B1', '#D1FFB1', '#B1FFC1', '#B1FFD1', '#B1FFF1', '#B1D1FF', '#B1B1FF', '#D1B1FF', '#FFB1FF', '#FFB1D1'],
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            datalabels: {
                                labels: {
                                    value: {
                                        color: 'black'
                                    }
                                }
                            },
                        },
                        scales: {
                            y: {
                                display: false // Cacher l'axe des ordonnées
                            }
                        }
                    }
                };
            } else {
                chartConfig = {
                    type: chart.type,
                    plugins: [ChartDataLabels],
                    data: {
                        labels: chart.data.labels,
                        datasets: [{
                            label: 'Quantités',
                            data: chart.data.quantities,
                            backgroundColor: ['#FFB1C1', '#FFD1B1', '#FFF1B1', '#D1FFB1', '#B1FFC1', '#B1FFD1', '#B1FFF1', '#B1D1FF', '#B1B1FF', '#D1B1FF', '#FFB1FF', '#FFB1D1'],
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'end',
                                labels: {
                                    value: {
                                        color: 'black'
                                    }
                                }
                            },
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Quantités',
                                position: 'top',
                                align: 'start'
                            },
                        },
                        scales: {
                            y: {
                                display: false // Cacher l'axe des ordonnées
                            }
                        }
                    }
                };
            }
            break;
        case typeStatistique.BURGER_VENTE_TEMPS:
            console.log(chart);
            chartConfig = {
                type: chart.type,
                data: chart.data,
                options: {
                    responsive: false,
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            labels: {
                                value: {
                                    color: 'black'
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Quantités',
                            position: 'top',
                            align: 'start'
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                lineWidth: 1
                            }
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
    // solution temporaire
    if (temporaryChart.specificite == null) {
        temporaryChart.specificite = {};
    }

    if (temporaryChart.specificite.choixRecette != null) {
        input.prop('checked', temporaryChart.specificite.choixRecette);
    } else {
        input.prop('checked', true);
    }

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
                maximumSelectionLength: 10
            }).on('select2:select', function (e) {
                updateTemporaryChart();
            });
        }
        updateTemporaryChart();
    });
    // initialisation
    if (input.is(':checked')) {
        $('#select_choix_recette').prop('disabled', true);
        $('#select_choix_recette').select2('destroy');
        $('#select_choix_recette').hide();
    } else {
        $('#select_choix_recette').prop('disabled', false);
        $('#select_choix_recette').select2({
            width: '100%',
            placeholder: 'Sélectionnez une recette',
            maximumSelectionLength: 10
        }).on('select2:select', function (e) {
            updateTemporaryChart();
        });
    }

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
                // On re selectionne dans le choix multiples les recettes sélectionnées dans temporaryChart.specificite.recettes
                if (temporaryChart.specificite.recettes != null) {
                    console.log(temporaryChart.specificite.recettes);
                    $('#select_choix_recette').val(temporaryChart.specificite.recettes);
                    $('#select_choix_recette').trigger('change');
                }
                updateTemporaryChart();
            },
            error: function (data) {
                console.log("Statistiques.js - getAllBurgers - error");
                alert("Une erreur est survenue lors de la récupération des recettes.");
            },
        });
    });

    if (temporaryChart.specificite.archives != null) {
        selectArchives.val(temporaryChart.specificite.archives);
    } else {
        selectArchives.val(0);
    }
    selectArchives.trigger('change');
}

/**
 * Méthode permettant de gérer les spécificités du type de statistique BURGER_VENTE_TOTAL
 */
function setSpecificiteBurgerVenteTemps() {
    // solution temporaire
    if (temporaryChart.specificite == null) {
        temporaryChart.specificite = {};
    }

    // INTERVALLE DE TEMPS (Select)
    let divIntervalleTemps = $('<div>').addClass('wrapper axe_colonne main_axe_space_between');
    let h3LabelIntervalleTemps = $('<h3>').text('Intervalle de temps');
    let selectIntervalleTemps = $('<select>').attr('id', 'graphe_intervalle_temps');
    let messageIntervalleTemps = $('<p>').attr('id', 'message_intervalle_temps');
    messageIntervalleTemps.addClass('message');
    selectIntervalleTemps.addClass('select');
    selectIntervalleTemps.append($('<option>').attr('value', 0).text('Jour'));
    selectIntervalleTemps.append($('<option>').attr('value', 1).text('Mois'));
    selectIntervalleTemps.append($('<option>').attr('value', 2).text('Année'));
    divIntervalleTemps.append(h3LabelIntervalleTemps);
    divIntervalleTemps.append(selectIntervalleTemps);
    divIntervalleTemps.append(messageIntervalleTemps);
    selectIntervalleTemps.on('change', function () {
        switch ($(this).val()) {
            case '0':
                messageIntervalleTemps.text('Maximum 12 jours. Si aucune date n\'est sélectionnée, les 12 derniers jours seront utilisés.');
                temporaryChart.specificite.intervalleTemps = 0;
                temporaryChart.specificite.minIntervalleTemps = 2;
                temporaryChart.specificite.maxIntervalleTemps = 12;
                break;
            case '1':
                messageIntervalleTemps.text('Maximum 12 mois. Si aucune date n\'est sélectionnée, les 12 derniers mois seront utilisés. Les mois sont pris en compte à partir du premier au dernier jour du mois.');
                temporaryChart.specificite.intervalleTemps = 1;
                temporaryChart.specificite.minIntervalleTemps = 2;
                temporaryChart.specificite.maxIntervalleTemps = 12;
                break;
            case '2':
                messageIntervalleTemps.text('Maximum 12 années. Si aucune date n\'est sélectionnée, les 12 dernières années seront utilisées. Les années sont prises en compte du premier au dernier jour.');
                temporaryChart.specificite.intervalleTemps = 2;
                temporaryChart.specificite.minIntervalleTemps = 2;
                temporaryChart.specificite.maxIntervalleTemps = 12;
                break;
        }
        updateTemporaryChart();
    });
    if (temporaryChart.specificite.intervalleTemps != null) {
        selectIntervalleTemps.val(temporaryChart.specificite.intervalleTemps);
    } else {
        selectIntervalleTemps.val(1);
    }
    selectIntervalleTemps.trigger('change');

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
    let h3Label = $('<h3>').text('Choix des burger');

    // on construit le select 
    let select = $('<select>');
    select.attr('id', 'select_choix_recette');
    select.attr('multiple', 'multiple');
    // on ajoute le select dans la div puis on l'initialise avec select2
    divChoixBurger.append(h3Label);
    divChoixBurger.append(select);
    select.hide();

    // on ajoute les div au DOM
    let specificite = $('#specificite');
    specificite.append(divIntervalleTemps);
    specificite.append(divArchives);
    specificite.append(divChoixBurger);
    $('#select_choix_recette').select2();

    // on ajoute un écouteur d'évènement sur le select
    $('#select_choix_recette').prop('disabled', false);
    $('#select_choix_recette').select2({
        width: '100%',
        placeholder: 'Sélectionnez une recette',
        maximumSelectionLength: 3
    }).on('select2:select', function (e) {
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
                // On re selectionne dans le choix multiples les recettes sélectionnées dans temporaryChart.specificite.recettes
                if (temporaryChart.specificite.recettes != null) {
                    console.log(temporaryChart.specificite.recettes);
                    $('#select_choix_recette').val(temporaryChart.specificite.recettes);
                    $('#select_choix_recette').trigger('change');
                }
                updateTemporaryChart();
            },
            error: function (data) {
                console.log("Statistiques.js - getAllBurgers - error");
                alert("Une erreur est survenue lors de la récupération des recettes.");
            },
        });
    });

    if (temporaryChart.specificite.archives != null) {
        selectArchives.val(temporaryChart.specificite.archives);
    } else {
        selectArchives.val(0);
    }
    selectArchives.trigger('change');
}

/**
 * Méthode permettant de gérer les spécificités du type de statistique BURGER_VENTE_TOTAL
 */
function setSpecificiteFournisseurAchatTotal() {
    if (temporaryChart.specificite == null) {
        temporaryChart.specificite = {};
    }

    // ARCHIVES Fournisseur (Select)
    let divArchives = $('<div>').addClass('wrapper axe_colonne main_axe_space_between');
    let h3LabelArchives = $('<h3>').text('Archives Fournisseur');
    let selectArchives = $('<select>').attr('id', 'graphe_archives');
    selectArchives.addClass('select');
    selectArchives.append($('<option>').attr('value', -1).text('Fournisseurs non archivés'));
    selectArchives.append($('<option>').attr('value', 0).text('Tous'));
    selectArchives.append($('<option>').attr('value', 1).text('Fournisseurs archivés'));
    divArchives.append(h3LabelArchives);
    divArchives.append(selectArchives);

    // ARCHIVES Commande (Select)
    let divArchivesCommande = $('<div>').addClass('wrapper axe_colonne main_axe_space_between');
    let h3LabelArchivesCommande = $('<h3>').text('Archives Commande');
    let selectArchivesCommande = $('<select>').attr('id', 'graphe_archives_commande');
    selectArchivesCommande.addClass('select');
    selectArchivesCommande.append($('<option>').attr('value', -1).text('Commandes non réceptionnées'));
    selectArchivesCommande.append($('<option>').attr('value', 0).text('Tous'));
    selectArchivesCommande.append($('<option>').attr('value', 1).text('Commandes réceptionnées'));
    divArchivesCommande.append(h3LabelArchivesCommande);
    divArchivesCommande.append(selectArchivesCommande);
    selectArchivesCommande.on('change', function () {
        temporaryChart.specificite.archivesCommande = $(this).val();
        updateTemporaryChart();
    });
    if (temporaryChart.specificite.archivesCommande != null) {
        selectArchivesCommande.val(temporaryChart.specificite.archivesCommande);
    } else {
        selectArchivesCommande.val(0);
    }

    // CHOIX Fournisseur (Checkbox)
    let divChoixFournisseur = $('<div>').addClass('wrapper axe_colonne main_axe_space_between');
    let span = $('<span>').addClass('wrapper axe_ligne main_axe_space_between second_axe_center grow');
    let h3Label = $('<h3>').attr('for', 'choix_fournisseur_checkbox').text('Tous les fournisseurs');
    let input = $('<input>').addClass('input').attr({
        'id': 'choix_fournisseur_checkbox',
        'name': 'choix_fournisseur_checkbox',
        'type': 'checkbox',
    });
    span.append(h3Label);
    span.append(input);
    divChoixFournisseur.append(span);

    if (temporaryChart.specificite.choixFournisseur != null) {
        input.prop('checked', temporaryChart.specificite.choixFournisseur);
    } else {
        input.prop('checked', true);
    }

    // on construit le select 
    let select = $('<select>');
    select.attr('id', 'select_choix_fournisseur');
    select.attr('multiple', 'multiple');
    // on ajoute le select dans la div puis on l'initialise avec select2
    divChoixFournisseur.append(select);
    select.hide();

    // on ajoute les div au DOM
    let specificite = $('#specificite');
    specificite.append(divArchives);
    specificite.append(divArchivesCommande);
    specificite.append(divChoixFournisseur);
    $('#select_choix_fournisseur').select2();

    // on ajoute un écouteur d'évènement sur le checkbox
    input.on('change', function () {
        if ($(this).is(':checked')) {
            $('#select_choix_fournisseur').prop('disabled', true);
            $('#select_choix_fournisseur').select2('destroy');
            $('#select_choix_fournisseur').hide();
        } else {
            $('#select_choix_fournisseur').prop('disabled', false);
            $('#select_choix_fournisseur').select2({
                width: '100%',
                placeholder: 'Sélectionnez un fournisseur',
                maximumSelectionLength: 5
            }).on('select2:select', function (e) {
                updateTemporaryChart();
            });
        }
        updateTemporaryChart();
    });
    // initialisation
    if (input.is(':checked')) {
        $('#select_choix_fournisseur').prop('disabled', true);
        $('#select_choix_fournisseur').select2('destroy');
        $('#select_choix_fournisseur').hide();
    } else {
        $('#select_choix_fournisseur').prop('disabled', false);
        $('#select_choix_fournisseur').select2({
            width: '100%',
            placeholder: 'Sélectionnez un fournisseur',
            maximumSelectionLength: 5
        }).on('select2:select', function (e) {
            updateTemporaryChart();
        });
    }

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
            url: "statistiques/getAllFournisseurs",
            method: "POST",
            dataType: "json",
            data: {
                dataReceived: dataToSend
            },
            success: function (data) {
                console.log("Statistiques.js - getAllFournisseurs - success");
                // SELECT2
                // on ajoute comme attr id et multiple
                let select = $('#select_choix_fournisseur');
                select.empty();
                data.forEach(element => {
                    select.append('<option value="' + element.id + '">' + element.nom + '</option>');
                });
                // On re selectionne dans le choix multiples les recettes sélectionnées dans temporaryChart.specificite.recettes
                if (temporaryChart.specificite.fournisseurs != null) {
                    console.log(temporaryChart.specificite.fournisseurs);
                    $('#select_choix_fournisseur').val(temporaryChart.specificite.fournisseurs);
                    $('#select_choix_fournisseur').trigger('change');
                }
                updateTemporaryChart();
            },
            error: function (data) {
                console.log("Statistiques.js - getAllFournisseurs - error");
                alert("Une erreur est survenue lors de la récupération des fournisseurs.");
            },
        });
    });

    if (temporaryChart.specificite.archives != null) {
        selectArchives.val(temporaryChart.specificite.archives);
    } else {
        selectArchives.val(0);
    }
    selectArchives.trigger('change');
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

    // remplir specifite temporaryChart
    temporaryChart.specificite.choixRecette = $('#choix_recette_checkbox').is(':checked');
    temporaryChart.specificite.recettes = $('#select_choix_recette').val();
    temporaryChart.specificite.archives = $('#graphe_archives').val();

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
                $('#graphesTemp').empty().html('<h3 class="text-center">Aucune donnée à afficher</h3>');
                temporaryChart.error = true;
                return;
            }
            let labels = [];
            let quantities = [];
            let lePlusGrand = 0;
            data.forEach(element => {
                labels.push(element.nom);
                // on convertit en nombre element.quantite
                element.quantite = parseInt(element.quantite);
                quantities.push(element.quantite);
                if (element.quantite > lePlusGrand) {
                    lePlusGrand = element.quantite;
                }
            });
            dataResult = {}
            dataResult.labels = labels;
            dataResult.quantities = quantities;
            dataResult.lePlusGrand = lePlusGrand;
            temporaryChart.data = dataResult;
            temporaryChart.error = false;
            // solution provisoire
            $('#graphesTemp').empty();
            createChart(temporaryChart);
        },
        error: function (data) {
            console.log("Statistiques.js - getDataBurgerVenteTotal - error");
            alert("Une erreur est survenue lors de la récupération des recettes.");
        },
    });
    return dataResult;
}

/**
 * Méthode permettant de récupérer les données du graphe de type BURGER_VENTE_TOTAL
 * @returns {}
 */
function getDataBurgerVenteTemps() {
    console.log("Statistiques.js - getDataBurgerVenteTemps");
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
    // listes des burgers
    dataToSend.recettes = $('#select_choix_recette').val();
    // on récupère la valeur d'archives
    dataToSend.archives = $('#graphe_archives').val();

    // intervalle de temps
    dataToSend.intervalle = $('#graphe_intervalle_temps').val();

    dataToSend = JSON.stringify(dataToSend);

    // remplir specifite temporaryChart
    temporaryChart.specificite.recettes = $('#select_choix_recette').val();
    temporaryChart.specificite.archives = $('#graphe_archives').val();

    $.ajax({
        url: "statistiques/getDataBurgerVenteTemps",
        method: "POST",
        dataType: "json",
        data: {
            dataReceived: dataToSend
        },
        success: function (data) {
            console.log("Statistiques.js - getDataBurgerVenteTemps - success");

            // on récupère les données
            console.log(data);

            // on boucle sur data avec un foreach
            if (data.length == 0) {
                $('#graphesTemp').empty().html('<h3 class="text-center">Aucune donnée à afficher</h3>');
                temporaryChart.error = true;
                return;
            }
            // On récupère les labels (représentant les dates contenus dans les clé)
            let labels = [];
            for (dateKey in data.data) {
                labels.push(dateKey);
            }
            console.log(labels);
            let datasets = [];
            let lePlusGrand = 0;
            // On récupère les quantités (représentant les quantités de burgers vendus par id)
            for (key in data.info) {
                let dataset = {};
                dataset.label = data.info[key].nom;
                let temp = [];
                for (dateKey in data.data) {
                    if (data.data[dateKey] == undefined || data.data[dateKey] == null || data.data[dateKey][key] == undefined || data.data[dateKey][key] == null) {
                        temp.push(0);
                    } else {
                        temp.push(parseInt(data.data[dateKey][key]));
                        if (parseInt(data.data[dateKey][key]) > lePlusGrand) {
                            lePlusGrand = parseInt(data.data[dateKey][key]);
                        }
                    }
                }
                dataset.data = temp;
                datasets.push(dataset);
            }
            console.log(datasets);
            dataResult = {}
            dataResult.labels = labels;
            dataResult.datasets = datasets;
            dataResult.lePlusGrand = lePlusGrand;
            temporaryChart.data = dataResult;
            temporaryChart.error = false;
            // solution provisoire
            $('#graphesTemp').empty();
            createChart(temporaryChart);
        },
        error: function (data) {
            console.log("Statistiques.js - getDataBurgerVenteTemps - error");
            alert("Une erreur est survenue lors de la récupération des recettes.");
        },
    });
    return dataResult;
}