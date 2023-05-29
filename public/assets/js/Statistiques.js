// ******************
// *** CONSTANTES ***
// ******************
const charts = {};
const temporyChart = {};
const chartType = {
    1: {
        'name': 'Barre',
        'nameType': 'bar',
        'value': 1
    },
    2: {
        'name': 'Ligne',
        'nameType': 'line',
        'value': 2
    },
    3: {
        'name': 'Secteur',
        'nameType': 'pie',
        'value': 3
    },
    4: {
        'name': 'Donut',
        'nameType': 'doughnut',
        'value': 4
    }
};

// *********************************
// *** QUAND LA PAGE EST CHARGÉE ***
// *********************************
$(document).ready(function () {
    // message dans la console 
    console.log('Statistiques.js');

    // Evènements
    $('.onglet').on('click', selectionOnglet);
    $('#choix_date_graphe').on('change', afficherDate);
    $('.graphe_choix').on('click', selectionnerGraphe);
    $('#nom_graphe').on('input', actualiserTitre);
    $('#description_graphe').on('input', actualiserDescription);

    // Initialisation de la page
    $('#ongletSelection').click();
    $('#choix_date_graphe').change();

    // Initialisation du select des types (type_graphe)
    for (let type in chartType) {
        $('#type_graphe').append('<option value="' + chartType[type].value + '">' + chartType[type].name + '</option>');
    }
});

// *****************
// *** FONCTIONS ***
// *****************
let selectionOnglet = function (event) {
    console.log("Statistiques.js - selectionOnglet");
    // on récupère l'onglet
    let onglet;
    if (event.target) {
        onglet = $(event.target);
    } else {
        onglet = $(this);
    }

    // on retire la classe selected à tous les autres onglets et on l'ajoute à l'onglet sélectionné
    $('.onglet').removeClass('selected');
    onglet.addClass('selected');

    // on cache toutes les div de selection_graphe
    $('#menu_graphe > div').addClass('hidding');

    // on affiche la div correspondant à l'onglet sélectionné
    let id = onglet.attr('id');
    console.log(id);
    $('#menu_graphe div[data_id=' + id + ']').removeClass('hidding');
}

let afficherDate = function (event) {
    console.log("Statistiques.js - afficherDate");
    // si la case est coché on affiche le champ date et on réactive le bouton
    if ($(this).is(':checked')) {
        $('#date_debut_span').removeClass('hidding');
        $('#date_fin_span').removeClass('hidding');
        $('#date_debut_graphe').prop('disabled', false);
        $('#date_fin_graphe').prop('disabled', false);
    }
    // sinon on le cache et on désactive le bouton
    else {
        $('#date_debut_span').addClass('hidding');
        $('#date_fin_span').addClass('hidding');
        $('#date_debut_graphe').prop('disabled', true);
        $('#date_fin_graphe').prop('disabled', true);
    }
}

let selectionnerGraphe = function (event) {
    console.log("Statistiques.js - selectionnerGraphe");
    // on récupère le graphe
    let graphe = $(this);

    // on retire la classe selected à tous les autres onglets et on l'ajoute à l'onglet sélectionné
    $('.graphe_choix').removeClass('selected');
    graphe.addClass('selected');

    // on regarde le type de graphe sélectionné
    let type = graphe.attr('type_stat');
    console.log("Type de statistiques : " + type);

    switch (type) {
        case 'burger':
            addDivChart();
            $('#nom_graphe').val('Graphique des burgers vendus');
            $('#description_graphe').val('Ce graphique représente le nombre de burgers vendus depuis l\'ouverture du restaurant.');
            temporyChart["type"] = 3;
            $("#type_graphe").val(temporyChart["type"]);
            actualiserTitre();
            actualiserDescription();
            recupererLesRecettes();
            recupererRecettesPourStatistiques();
            break;
        case 'ingredient':
            break;
        case 'produits':
            break;
        case 'fournisseurs':
            break;
        case 'benefices':
            break;
        case 'nombre_client':
            break;
        default:
            console.log("Statistiques.js - selectionnerGraphe - default");
            break;
    }
}

let addDivChart = function () {
    console.log("Statistiques.js - addChart");
    // on créer une div pour le graphe
    let div = $('<div>').addClass('div_graphe');
    // on créer un canvas pour le graphe ainsi qu'un h3 pour le titre et un p pour la description
    let canvas = $('<canvas>');
    let titre = $('<h3>');
    let description = $('<p>');
    div.append(titre), div.append(canvas), div.append(description);

    // on ajoute la div dans le tableau temporaryChart
    temporyChart["order"] = charts.length;
    temporyChart["element"] = div;
}

let actualiserTitre = function () {
    console.log("Statistiques.js - actualiserTitre");
    if (temporyChart["element"] == undefined) {
        console.log("Statistiques.js - actualiserDescription - aucun graphe sélectionné");
        return;
    }
    // on récupère le titre
    let titre = $('#nom_graphe').val();
    // on l'ajoute à l'élément Titre de la div dans le tableau temporaryChart
    temporyChart["element"].find('h3').text(titre);
}

let actualiserDescription = function () {
    console.log("Statistiques.js - actualiserDescription");
    if (temporyChart["element"] == undefined) {
        console.log("Statistiques.js - actualiserDescription - aucun graphe sélectionné");
        return;
    }
    // on récupère la description
    let description = $('#description_graphe').val();
    // on l'ajoute à l'élément Titre de la div dans le tableau temporaryChart
    temporyChart["element"].find('p').text(description);
}

// *******************
// *** APPELS AJAX ***
// *******************

// *** APPELS AJAX - BURGER ***
let recupererLesRecettes = function () {
    console.log("Statistiques.js - recupererLesRecettes");
    // compléter pour préparer la checkbox
    let div = $('<div>');
    $.ajax({

        url: "statistiques/recupererLesRecettes",
        method: "POST",
        dataType: "json",
        success: function (data) {
            console.log("Statistiques.js - recupererLesRecettes - success");
            // CHECKBOX
            let span = $('<span>').addClass('wrapper axe_ligne main_axe_space_between second_axe_center grow');
            let label = $('<label>').attr('for', 'choix_recette_checkbox').text('Tous les burgers');
            let input = $('<input>').addClass('input').attr({
                'id': 'choix_recette_checkbox',
                'name': 'choix_recette_checkbox',
                'type': 'checkbox',
            });
            span.append(label);
            span.append(input);
            div.append(span);
            input.on('change', function () {
                if ($(this).is(':checked')) {
                    $('#select_choix_recette').prop('disabled', true);
                    $('#select_choix_recette').select2('destroy');
                    $('#select_choix_recette').addClass("hidding");
                } else {
                    $('#select_choix_recette').prop('disabled', false);
                    $('#select_choix_recette').select2({
                        width: 'element',
                        placeholder: 'Sélectionnez une recette',
                    });
                }
            });

            // SELECT2
            // on ajoute comme attr id et multiple
            let select = $('<select>');
            select.attr('id', 'select_choix_recette');
            select.attr('multiple', 'multiple');
            // on ajoute toutes les autres options
            data.forEach(element => {
                select.append('<option value="' + element.id + '">' + element.nom + '</option>');
            });

            // on ajoute le select dans la div puis on l'initialise avec select2
            div.append(select);
            select.select2({
                width: 'element',
                placeholder: 'Sélectionnez une recette',
            });
        },
        error: function (data) {
            console.log("Statistiques.js - recupererLesRecettes - error");
            alert("Une erreur est survenue lors de la récupération des recettes.");
            div.append('<p>Une erreur est survenue lors de la récupération des recettes.</p>');
        },
    });
    $('#specificite').append(div);
}

let recupererRecettesPourStatistiques = function () {
    console.log("Statistiques.js - makeStatBurger");
    // on prépare les données à envoyer
    let data;
    // listes des burgers
    if ($('#choix_recette_checkbox').is(':checked')) {
        data = {
            'recette_all': true,
        };
    } else {
        data = {
            'recette_all': false,
            'recettes': $('#select_choix_recette').val(),
        };
    }
    // dates
    if ($('#choix_date_graphe').is(':checked')) {
        data['date_all'] = false;
        data['date_debut'] = $('#date_debut_graphe').val();
        data['date_fin'] = $('#date_fin_graphe').val();
    } else {
        data['date_all'] = true;
    }
    data = JSON.stringify(data);

    $.ajax({
        url: "statistiques/recupererRecettesPourStatistiques",
        method: "POST",
        dataType: "json",
        data: {
            data: data
        },
        success: function (data) {
            console.log("Statistiques.js - recupererRecettesPourStatistiques - success");
            
        },
        error: function (data) {
            console.log("Statistiques.js - recupererRecettesPourStatistiques - error");
            alert("Une erreur est survenue lors de la récupération des recettes.");
        },
    });
}

// *** APPELS AJAX - INGREDIENT ***


// ********************
// *** EXPLICATIONS ***
// ********************

/*
--- DOCUMENTATION DES STATISTIQUES ---











*/