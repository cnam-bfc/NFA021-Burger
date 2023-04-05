function ajouterLigne() {
    var table = document.getElementById("tableau");
    var ligne = table.insertRow(-1);
    var produit = ligne.insertCell(0);
    var quantite = ligne.insertCell(1);
    var prix = ligne.insertCell(2);
    var suppression = ligne.insertCell(3);
    produit.innerHTML = '<select id="produit" name="produit" class="courbe"><option value="Pain Burger">Pain Burger</option><option value="Tomate">Tomate au KG</option><option value="Steak Boeuf">Steak Boeuf</option></select>';
    quantite.innerHTML = '<input type="number" name="quantite" id="quantite" class="courbe">';
    prix.innerHTML = '<input type="number" name="prix" id="prix" disabled value ="1.00" class="courbe">';
    suppression.innerHTML = '<button onclick="retirerLigne(this)" class="courbe">X</button>';

    //Màj du prix après le retrait
    const inputsPrix = document.querySelectorAll('#prix');

    // Calcul de la somme des prix
    let total = 0;
    inputsPrix.forEach(input => {
        total += parseFloat(input.value);
    });

    // Affichage du résultat dans la div d'id 'montant'
    const montantDiv = document.getElementById('montant');
    montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
}

function retirerLigne(btn) {
    var ligne = btn.parentNode.parentNode;
    ligne.parentNode.removeChild(ligne);

    //Màj du prix après le retrait
    const inputsPrix = document.querySelectorAll('#prix');

    // Calcul de la somme des prix
    let total = 0;
    inputsPrix.forEach(input => {
        total += parseFloat(input.value);
    });

    // Affichage du résultat dans la div d'id 'montant'
    const montantDiv = document.getElementById('montant');
    montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';
}


var form = document.querySelector('form');
form.addEventListener('submit', function (event) {
    event.preventDefault();
});


// Calcul du prix au lancement de la page
const inputsPrix = document.querySelectorAll('#prix');

// Calcul de la somme des prix
let total = 0;
inputsPrix.forEach(input => {
    total += parseFloat(input.value);
});

// Affichage du résultat dans la div d'id 'montant'
const montantDiv = document.getElementById('montant');
montantDiv.textContent = 'Montant TTC : ' + total.toFixed(2) + '€';