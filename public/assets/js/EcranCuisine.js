// Récupération des éléments HTML pertinents
const wrapper = document.getElementById('wrapper');
const boutonPrev = document.getElementById('boutonPrev');
const boutonNext = document.getElementById('boutonNext');

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

// Ajout des écouteurs d'événement sur les boutons "Préc." et "Suiv."
boutonPrev.addEventListener('click', focusPrev);
boutonNext.addEventListener('click', focusNext);