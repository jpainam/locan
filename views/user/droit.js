$(document).ready(function () {
    $("select[name=listeusers]").change(function () {
        $.ajax({
            url: "./ajax",
            dataType: "json",
            type: "POST",
            data: {
                "iduser": $("select[name=listeusers]").val()
            },
            success: function (result) {
                $("#onglet1").html(result[0]);
                $("#onglet2").html(result[1]);
                $("#onglet3").html(result[2]);
                $(".recapitulatif").html(result[3] + " sessions");
            },
            error: function (xhr, status, error) {
                alertWebix("Veuillez rafraichir la page \n" + status + " " + error);
            }

        });
    });
    $("#connexionTable").DataTable({
    });
    $("#droitTable").DataTable({
        "bInfo": false
    });
});
function validerFormDroit() {
    frm = $("form[name=frmdroit]");
    hidden = $("<input type = 'hidden' name = 'iduser' />");
    hidden.val($("select[name=listeusers]").val());
    frm.append(hidden);
    //console.log(frm);
    frm.submit();
}