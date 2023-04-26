
function rechercher() {
  // Récupérer la valeur de l'input
  var input = document.getElementById("recherche");
  var filter = input.value.toUpperCase();

  // Récupérer les lignes du tableau
  var table = document.getElementsByTagName("table")[0];
  var rows = table.getElementsByTagName("tr");

  // Boucler à travers toutes les lignes du tableau
  for (var i = 1; i < rows.length; i++) {
    var td = rows[i].getElementsByTagName("td");
    var found = false;

    // Boucler à travers toutes les colonnes de chaque ligne
    for (var j = 0; j < td.length; j++) {
      // Si la colonne contient la recherche
      if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        found = true;
        break;
      }
    }

    if (found) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }
}

// // Obtenez l'élément de bouton par son identifiant
// const bouton = document.getElementById('bouton');

// // Ajoutez un écouteur d'événements de clic au bouton
// bouton.addEventListener('click', () => {
//     // Rediriger vers la page souhaitée
//     window.location.href = 'nouveauproduit';
// });

// Obtenez tous les éléments <td> avec l'id 'bouton'
const boutons = document.querySelectorAll('#bouton');

// Parcourez tous les éléments <td> avec l'id 'bouton'
boutons.forEach(bouton => {
    // Ajoutez un écouteur d'événements de clic à chaque bouton
    bouton.addEventListener('click', (event) => {
        // Trouvez la ligne parente (<tr>) de l'élément cliqué
        const ligne = event.target.closest('tr');
        
        // Récupérez la valeur du deuxième <td> de la ligne
        const deuxiemeTd = ligne.querySelector('td:nth-child(2)').textContent;
        
        // Redirigez vers la page souhaitée avec la valeur du deuxième <td>
        window.location.href = `nouveauproduit?nomProduit=${deuxiemeTd}`;
    });
});


