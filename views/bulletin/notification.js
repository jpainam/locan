$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerNotification);
    $("select[name=comboPeriodes]").change(chargerNotification);

    if (!$.fn.DataTable.isDataTable("#tableBulletin")) {
        $("#tableBulletin").DataTable({
            bInfo: false,
            searching: false,
            paging: false,
            scrollY: $(".page").height() - 100,
            columns: [
                {"width": "10%"},
                {"width": "15%"},
                {"width": "15%"},
                {"width": "20%"},
                {"width": "20%"},
                null
            ]
        });
    }
});
chargerNotification = function () {
    $.ajax({
        url: "./ajaxnotification",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerNotification",
            idclasse: $("select[name=comboClasses]").val(),
            periode: $("select[name=comboPeriodes]").val()
        },
        success: function (result) {
            $("#bulletin-content").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + status + " " + error);
        }
    });
};

function envoyerBulletin() {
    $.ajax({
        url: "./ajaxnotification",
        type: "POST",
        dataType: "json",
        data: {
            action: "envoyerBulletin",
            idclasse: $("select[name=comboClasses]").val(),
            periode: $("select[name=comboPeriodes]").val()
        },
        success: function (result) {
            $("#bulletin-content").html(result[1]);
            if(result[0]){
                alertWebix("Messages envoy&eacute;s avec succ&egrave;s");
            }else{
                alertWebix("Erreur d'envoi des messages");
            }
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + status + " " + error);
        }
    });
}