$(document).ready(function () {

  //On récupère tous les boutons Modifier et on place un écouteur sur chaque bouton
  let boutonsModifier = document.querySelectorAll('.fa-pen');

  boutonsModifier.forEach(bouton => {
    bouton.addEventListener('click', (event) => {
      let ligne = event.target.closest('tr');
      let idIngredient = ligne.querySelector('td:nth-child(6)').textContent;
      window.location.href = `nouveauproduit?idIngredient=${idIngredient}`;
    });
  });

  //On récupère tous les boutons Archiver et on place un écouteur sur chaque bouton
  let boutonsArchiver = document.querySelectorAll('.fa-box-archive');

  boutonsArchiver.forEach(bouton => {
    bouton.addEventListener('click', (event) => {
      let ligne = event.target.closest('tr');
      let idIngredient = ligne.querySelector('td:nth-child(6)').textContent;
      archiver(idIngredient);

      alert("L'ingrédient a été archivé avec succès.");
    });
  });
});


//****************************************************************************************************************/
//****************************************************************************************************************/

//Méthode redirige vers le formulaire de création/modification d'ingrédient
function redirigerPageNouveauProduit() {
  window.location.href = `nouveauproduit`;
}


//****************************************************************************************************************/
//****************************************************************************************************************/


//Méthode qui archive un ingrédient dont on transmets l'id
function archiver($id) {
  let json = ({
    id: $id,
  });

  json = JSON.stringify(json);

  $.ajax({
    url: 'listeproduits/archiver',
    type: 'POST',
    dataType: 'json',
    data: {
      data: json
    },
    success: function (data) {
      //On retire la ligne de l'ingrédient dans le tableau
      $("#select" + data.id).remove();
    },

    error: function (data) {
      console.log('ListeBdc.js - error');
    }
  })
}


//****************************************************************************************************************/
//****************************************************************************************************************/


//Méthode qui permet de rechercher un ingrédient par son nom dans le tableau
function rechercher() {

  //On récupère la valeur du champ "Recherche"
  var input = document.getElementById("recherche");
  var filter = input.value.toUpperCase();

  //On récupère toutes les lignes du tableau
  var table = document.getElementsByTagName("table")[0];
  var rows = table.getElementsByTagName("tr");

  //On boucle à travers sur les lignes
  for (var i = 1; i < rows.length; i++) {
    var td = rows[i].getElementsByTagName("td");
    var found = false;

    //On boucle à travers toutes les colonnes de chaque ligne
    for (var j = 0; j < td.length; j++) {
      //Si la colonne contient la recherche
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