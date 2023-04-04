
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
