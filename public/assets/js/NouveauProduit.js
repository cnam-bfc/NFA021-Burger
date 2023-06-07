$(function () {

    document.getElementById('stockAuto').onchange = function () {
        document.getElementById('qteMin').disabled = !this.checked;
        document.getElementById('qteStandard').disabled = !this.checked;
    };

});

function redirigerPageListeProduits() {
    window.location.href = `listeproduits`;
}

function messageCreationIngredient() {
    alert("L'ingrédient a été ajouté avec succès.");
}

function messageModificationIngredient() {
    alert("L'ingrédient a été modifié avec succès.");
}
