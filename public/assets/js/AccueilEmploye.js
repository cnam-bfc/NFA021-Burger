$(function () {

    const divPrincipale = $("div#wrapper_accueil");
    const divGerant = $("div#wrapper_accueil div#espace_gerant");
    const divCuisinier = $("div#wrapper_accueil div#espace_cuisinier");
    const divLivreur = $("div#wrapper_accueil div#espace_livreur");
    const valeurTest = UserSession::getUserSession().get();
    function RecupCompte() {
        $.ajax({
            url: 'accueil/refreshCompte',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.id === 0) {
                    divLivreur.remove()
                    divGerant.remove()
                }
                else if (data.id === 1) {
                    divCuisinier.remove()
                    divGerant.remove()
                }
                else if (data.id === 2) {
                    divCuisinier.remove()
                    divLivreur.remove()
                }

            },
            error: function (data) {
                console.log('AccueilEmploye.js - refreshCompte - error');
            }
        });
    }
    RecupCompte();
});