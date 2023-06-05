
// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('AccueilClient.js');

    const element = $('header');
    element.removeClass('header_client');
    element.removeClass('header_sticky');
    element.addClass('header_client_transparent');
    element.addClass('header_float');

    function changeClass() {
        if (window.scrollY == 0) {
            element.addClass('header_client_transparent');
            element.addClass('header_float');
            element.removeClass('header_sticky_accueil');
            element.removeClass('header_client');
        } else {
            element.addClass('header_sticky_accueil');
            element.addClass('header_client');
            element.removeClass('header_float');
            element.removeClass('header_client_transparent');
        }
    }

    window.addEventListener('scroll', changeClass);

    // requête AJAX pour récupérer les 3 recettes les plus populaires
    $.ajax({
        url: 'accueil/refreshTopRecettes',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log('AccueilClient.js - refreshTopRecettes - success');

            // on vérifie si la classe hidding est présente sur : top_recettes
            if ($('#top_recette').hasClass('hidding')) {
                // on retire la classe hidding de : top_recettes
                $('#top_recette').removeClass('hidding');
            }

            // affichage des recettes (modification du DOM)
            // recette 1
            $('#top_recette>div:nth-child(1)>img').attr('src', data[0].image); 
            $('#top_recette>div:nth-child(1)>p').text(data[0].nom);

            // recette 2
            $('#top_recette>div:nth-child(2)>img').attr('src', data[1].image);
            $('#top_recette>div:nth-child(2)>p').text(data[1].nom);

            // recette 3
            $('#top_recette>div:nth-child(3)>img').attr('src', data[2].image);
            $('#top_recette>div:nth-child(3)>p').text(data[2].nom);
        },
        error : function (data) {
            // message dans la console
            console.log('AccueilClient.js - refreshTopRecettes - error');
        }
    });

    let actualiserTexte = function () {
        $.ajax({
            url: 'accueil/refreshTextAccueil',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                // message dans la console
                console.log('AccueilClient.js - refreshTextAccueil - success');
    
                // On modifie le DOM pour mettre le titre et le texte
                $('#texte_accueil>h2').text(data.title);
                $('#texte_accueil>p').text(data.text);
            },
            error : function (data) {
                // message dans la console
                console.log('AccueilClient.js - refreshTextAccueil - error');
            }
        });
    }
    actualiserTexte();
});