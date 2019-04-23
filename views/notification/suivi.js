var calDateAu, calDateDe;

$(document).ready(function () {
    calDateAu = getCalendar("dateau");
    calDateDe = getCalendar("datede");
    $("select[name=comboDestinataires]").change(chargerMessageEnvoyes);
});

var chargerMessageEnvoyes = function () {
    
    
    var d1 = calDateDe.getValue();
    var d2 = calDateAu.getValue();
    
    $.ajax({
       url: "./ajaxsuivi",
       type: "POST",
       dataType: "json",
       data: {
         action : "filterParDestinataire",
         datedebut : d1.split(' ')[0],
         datefin: d2.split(' ')[0],
         destinataire: $("select[name=comboDestinataires]").val()
       },
       success: function(result){
           $("#message-content").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
};

function supprimerMessageEnvoye(_idmessage) {
    $.ajax({
        url: "./ajaxsuivi",
        type: "POST",
        dataType: "json",
        data: {
            idmessage : _idmessage,
            action: "supprimerMessageEnvoye"
        },
        success: function(result){
            $("#message-content").html(result[0]);
        },
        error: function(xhr, status, error){
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}