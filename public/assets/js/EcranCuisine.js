// Récupération des éléments HTML pertinents
const wrapper = document.getElementById('wrapper_cuisine');
const boutonPrev = document.getElementById('boutonPrev');
const boutonNext = document.getElementById('boutonNext');
const boutonValide = document.getElementById('boutonValide');

// Ajout des écouteurs d'événement sur les boutons "Préc." et "Suiv."
boutonPrev.addEventListener('click', () => {
    const commandes = document.querySelectorAll('.commande');
    let focusIndex = -1;
    for (let i = 0; i < commandes.length; i++) {
        if (commandes[i].classList.contains('focus')) {
            focusIndex = i;
            break;
        }
    }

    if (focusIndex > 0) {
        commandes[focusIndex].classList.remove('focus');
        commandes[focusIndex - 1].classList.add('focus');
    }
});
$('.commande:visible:first')
// Fonction pour ajouter la classe "focus" à la div suivante
boutonNext.addEventListener('click', () => {
    const commandes = document.querySelectorAll('.commande');
    let focusIndex = -1;
    for (let i = 0; i < commandes.length; i++) {
        if (commandes[i].classList.contains('focus')) {
            focusIndex = i;
            break;
        }
    }
    if (focusIndex < commandes.length - 1) {
        commandes[focusIndex].classList.remove('focus');
        commandes[focusIndex + 1].classList.add('focus');
    }
});

boutonValide.addEventListener('click', function () {
    // Récupère la commande actuellement en focus
    const commandeFocus = document.querySelector('.commande.focus');
    // Si une commande est en focus, la désactive et passe le focus à la commande suivante
    if (commandeFocus) {
        commandeFocus.classList.remove('focus');
        /* const commandeSuivante = commandeFocus.nextElementSibling;
         if (commandeSuivante) {
             commandeSuivante.classList.add('focus');
         } else {
             // Si la commande focus est la seule, on lui remet la classe focus
             commandeFocus.classList.add('focus');
         }*/
    }
    // Fait disparaître la commande validée en lui rajoutant la classe "hidding"
    commandeFocus.style.display = 'none';
    // Décale les commandes suivantes
    const commandes = document.querySelectorAll('.commande');
    for (let i = 0; i < commandes.length; i++) {
        const computedStyle = window.getComputedStyle(commandes[i]);
        if (computedStyle.display !== 'none') {
            commandes[i].classList.add('focus');
            break;
        }
    }
});

// Ajoute un événement à la pression de la touche "Enter" pour le bouton valider
document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        boutonValide.click();
    }
});

