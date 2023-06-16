$(document).ready(function () {

    //On place un écouteur sur le checkbox stockAuto
    document.getElementById('stockAuto').onchange = function () {
        document.getElementById('qteMin').disabled = !this.checked;
        document.getElementById('qteStandard').disabled = !this.checked;
    };

});


//****************************************************************************************************************/
//****************************************************************************************************************/


//Méthode qui redirige vers la page qui affiche la liste des produits
function redirigerPageListeProduits() {
    window.location.href = `listeproduits`;
}


//****************************************************************************************************************/
//****************************************************************************************************************/


//Méthode affiche un message de succès pour la création d'un ingrédient
function messageCreationIngredient() {
    alert("L'ingrédient a été ajouté avec succès.");
}


//****************************************************************************************************************/

//****************************************************************************************************************/
//Méthode affiche un message de succès pour la modification d'un ingrédient
function messageModificationIngredient() {
    alert("L'ingrédient a été modifié avec succès.");
}
