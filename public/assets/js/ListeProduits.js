
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
