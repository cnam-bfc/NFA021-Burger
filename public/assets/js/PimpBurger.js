function showData(BurgerID) {
    $.ajax({
        url: "visuModifsBurgers/ingredients",
        method: "POST",
        dataType : JSON,
        data: { id: BurgerID },
        success: function (response) {
            console.log(response);
            /*var id = $(response).find("table #votre_id").attr("id");
            console.log(id);
            */
        }
    });

    


}



