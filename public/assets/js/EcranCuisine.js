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
    // Fait disparaître la commande validée en lui rajoutant la classe "hidding"
    commandeFocus.classList.add('hidding');
    // Décale les commandes suivantes
    const commandes = document.querySelectorAll('.commande');
    for (let i = 0; i < commandes.length; i++) {
        if (commandes[i].classList.contains('hidding')) {
            
        }
    }
});

// Ajoute un événement à la pression de la touche "Enter" pour le bouton valider
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        boutonValide.click();
    }
});

// Ajoute un événement à la pression de la touche "Q" pour le bouton next
document.addEventListener('keydown', function(event) {
    if (event.key === 'Q') {
        boutonNext.click();
    }
});

// Ajoute un événement à la pression de la touche "D" pour le bouton prev
document.addEventListener('keydown', function(event) {
    if (event.key === 'D') {
        boutonPrev.click();
    }
});

// Ajouter automatiquement la classe "focus" à une commande ne possédant pas la classe "hidden"
const commandes = document.querySelectorAll('.commande');
for (let i = 0; i < commandes.length; i++) {
    if (!commandes[i].classList.contains('hidden')) {
        commandes[i].classList.add('focus');
        break;
    }
}

// Ajout des écouteurs d'événement sur les boutons "Préc." et "Suiv."
boutonPrev.addEventListener('click', focusPrev);
boutonNext.addEventListener('click', focusNext);