// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('Statistiques.js');

    // Evènements
    $('.onglet').on('click', selectionOnglet); 
    
    // Initialisation de la page
    $('#ongletSelection').click();
});

let selectionOnglet = function (event) {
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