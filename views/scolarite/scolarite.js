$(document).ready(function(){
   $("#scolariteTable").DataTable({
      "bInfo": false,
      "columns": [
          {"width": "15%"},
          null,
          {"width": "15%"},
          {"width": "13%"},
          {"width": "8%"},
          {"width": "5%"}
      ]
   });
   
   $("#img-ajout-scolarite").on("click", function(){
        openAjoutDialog();
   });
   //Popup form
    $("#scolarite-dialog-form").dialog({
        autoOpen: false,
        height: 210,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                ajoutScolarite();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
   $("#comboEleves").change(chargerPayement);
});

function openAjoutDialog(){
    removeRequiredFields([$("#comboEleves")]);
    if($("#comboEleves").val() === ""){
        addRequiredFields([$("#comboEleves")]);
        alertWebix("Veuillez d'abord choisir un élève");
        return;
    }
    $("#scolarite-dialog-form").dialog("open"); 
}
function ajoutScolarite(){
   $.ajax({
       url: "./ajax/ajout",
       type: "POST",
       dataType: "json",
       data: {
           "idfrais": $("select[name=comboFrais]").val(),
           //"montant": $("input[name=montant]").val(),
           "eleve": $("#comboEleves").val(),
           "idcaisse" : $("select[name=comboCaisses]").val()
       },
       success: function(result){
           $("#scolarite-content").html(result[0]);
           $(".recapitulatif").html("");
           if(result[1] !== ""){
               $(".recapitulatif").html("<div class='errors'>Montant de l'op&eacute;ration insuffisant: " + result[1] + "FCFA</div>");
           }
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
   });
}

chargerPayement = function(){
    $.ajax({
        url: "./ajax/charger",
        type: "POST",
        dataType: "json",
        data:{
            "eleve": $("#comboEleves").val()
        },
        success: function(result){
            $("#scolarite-content").html(result[0]);
            $("select[name=comboFrais]").html(result[1]);
            $("select[name=comboCaisses]").html(result[2]);
        },
        error: function(xhr, status, error){
            alert("Une erreur s'est produite " + xhr + " "+ error);
        }
    });
};
function supprimerScolarite(_id){
    $.ajax({
        url: "./ajax/supprimer",
        type: "POST",
        dataType: "json",
        data:{
            "idscolarite": _id,
            "eleve": $("#comboEleves").val()
        },
        success: function(result){
            $("#scolarite-content").html(result[0]);
        },
        error: function(xhr, status, error){
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}