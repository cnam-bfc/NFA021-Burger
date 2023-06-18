
// quand le document est prêt 
$(document).ready(function () {
    // message dans la console 
    console.log('AccueilClient.js');

    const element = $('header');
    element.removeClass('header_client');
    element.removeClass('header_sticky');
    element.addClass('header_client_transparent');
    element.addClass('header_float');
    $('.header_icone').addClass('color_not_sticky');
    $('header li').addClass('color_not_sticky');
    $('header li a').addClass('color_not_sticky');

    function changeClass() {
        if (window.scrollY == 0) {
            element.addClass('header_client_transparent');
            element.addClass('header_float');
            element.removeClass('header_sticky_accueil');
            element.removeClass('header_client');
            $('.header_icone').addClass('color_not_sticky');
            $('header li').addClass('color_not_sticky');
            $('header li a').addClass('color_not_sticky');
        } else {
            element.addClass('header_sticky_accueil');
            element.addClass('header_client');
            element.removeClass('header_float');
            element.removeClass('header_client_transparent');
            $('.header_icone').removeClass('color_not_sticky');
            $('header li').removeClass('color_not_sticky');
            $('header li a').removeClass('color_not_sticky');
        }
    }

    window.addEventListener('scroll', changeClass);

    const header = document.querySelector('header');

    // pour la couleur des texts (si on a le temps il faudrait regrouper avec celui du dessus on pourrait gagner des lignes de codes)
    // Gestionnaire d'événement pour le survol (mouseenter)
    header.addEventListener('mouseover', () => {
        // Ajoutez ici les actions à effectuer lorsque le survol commence
        if (element.hasClass('header_client_transparent')) {
            $('.header_icone').removeClass('color_not_sticky');
            $('header li').removeClass('color_not_sticky');
            $('header li a').removeClass('color_not_sticky');
        }
    });

    // Gestionnaire d'événement pour la sortie du survol (mouseleave)
    header.addEventListener('mouseout', () => {
        // Ajoutez ici les actions à effectuer lorsque le survol se termine
        if (element.hasClass('header_client_transparent')) {
            $('.header_icone').addClass('color_not_sticky');
            $('header li').addClass('color_not_sticky');
            $('header li a').addClass('color_not_sticky');
        }
    });

    // requête AJAX pour récupérer les 3 recettes les plus populaires
    $.ajax({
        url: 'accueil/refreshTopRecettes',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            // message dans la console
            console.log('AccueilClient.js - refreshTopRecettes - success');

            if (data != null) {
                // on vérifie si la classe hidding est présente sur : top_recettes
                if ($('#top_recette').hasClass('hidding')) {
                    // on retire la classe hidding de : top_recettes
                    $('#top_recette').removeClass('hidding');
                }

                // affichage des recettes (modification du DOM)
                // recette 1
                $('#top_recette>div:nth-child(1)>img').attr('src', data[1].image);
                $('#top_recette>div:nth-child(1)>p').text(data[1].nom);
                function clickRecette1() {
                    window.location.href = 'visuModifsBurgers?id=' + data[1].id;
                }
                $('#top_recette>div:nth-child(1)').on('click', clickRecette1).css('cursor', 'pointer');
                $('#top_recette>div:nth-child(1)>img').on('click', clickRecette1).css('cursor', 'pointer');

                // recette 2
                $('#top_recette>div:nth-child(2)>img').attr('src', data[0].image);
                $('#top_recette>div:nth-child(2)>p').text(data[0].nom);
                function clickRecette2() {
                    window.location.href = 'visuModifsBurgers?id=' + data[0].id;
                }
                $('#top_recette>div:nth-child(2)').on('click', clickRecette2).css('cursor', 'pointer');
                $('#top_recette>div:nth-child(2)>img').on('click', clickRecette2).css('cursor', 'pointer');

                // recette 3
                $('#top_recette>div:nth-child(3)>img').attr('src', data[2].image);
                $('#top_recette>div:nth-child(3)>p').text(data[2].nom);
                function clickRecette3() {
                    window.location.href = 'visuModifsBurgers?id=' + data[2].id;
                }
                $('#top_recette>div:nth-child(3)').on('click', clickRecette3).css('cursor', 'pointer');
                $('#top_recette>div:nth-child(3)').css('cursor', 'pointer').css('cursor', 'pointer');
            }
        },
        error: function (data) {
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
            error: function (data) {
                // message dans la console
                console.log('AccueilClient.js - refreshTextAccueil - error');
            }
        });
    }
    actualiserTexte();
});