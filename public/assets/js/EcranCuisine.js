// Récupération des éléments HTML pertinents
const wrapper = document.getElementById('wrapper');
const boutonPrev = document.getElementById('boutonPrev');
const boutonNext = document.getElementById('boutonNext');
const boutonValide = document.getElementById('boutonValide');

// Fonction pour ajouter la classe "focus" à la div suivante
function focusNext() {
    // Récupération de l'élément qui a actuellement la classe "focus"
    const current = wrapper.querySelector('.focus');
    // Si on est déjà à la fin de la liste, on ne fait rien
    if (!current.nextElementSibling) {
        return;
    }
    // Sinon, on enlève la classe "focus" de l'élément courant
    current.classList.remove('focus');
    // Et on ajoute la classe "focus" à l'élément suivant
    current.nextElementSibling.classList.add('focus');
}

// Fonction pour ajouter la classe "focus" à la div précédente
function focusPrev() {
    // Récupération de l'élément qui a actuellement la classe "focus"
    const current = wrapper.querySelector('.focus');
    // Si on est déjà au début de la liste, on ne fait rien
    if (!current.previousElementSibling) {
        return;
    }
    // Sinon, on enlève la classe "focus" de l'élément courant
    current.classList.remove('focus');
    // Et on ajoute la classe "focus" à l'élément précédent
    current.previousElementSibling.classList.add('focus');
}

boutonValide.addEventListener('click', function() {
    // Récupère la commande actuellement en focus
    const commandeFocus = document.querySelector('.commande.focus');
    // Si une commande est en focus, la désactive et passe le focus à la commande suivante
    if (commandeFocus) {
        commandeFocus.classList.remove('focus');
        const commandeSuivante = commandeFocus.nextElementSibling;
        if (commandeSuivante) {
            commandeSuivante.classList.add('focus');
        } else {
            // Si la commande focus est la seule, on lui remet la classe focus
            commandeFocus.classList.add('focus');
        }
    }
    // Fait disparaître la commande validée
    commandeFocus.style.display = 'none';
    // Décale les commandes suivantes
    const commandes = document.querySelectorAll('.commande');
    for (let i = 0; i < commandes.length; i++) {
        if (commandes[i].style.display === 'none') {
            commandes[i].style.transform = 'translateY(-100%)';
        }
    }
});

// Ajoute un événement à la pression de la touche "Enter" pour le bouton valider
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        boutonValide.click();
    }
});

// Vérifie s'il n'y a qu'une seule commande et ajoute la classe focus
const commandes = document.querySelectorAll('.commande');
if (commandes.length === 1) {
    commandes[0].classList.add('focus');
}

// Ajout des écouteurs d'événement sur les boutons "Préc." et "Suiv."
boutonPrev.addEventListener('click', focusPrev);
boutonNext.addEventListener('click', focusNext);