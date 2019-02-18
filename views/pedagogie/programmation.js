$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerEnseignement);
    $("select[name=comboEnseignements]").change(chargerProgrammation);
});
var chargerActivite = function () {

};
var chargerEnseignement = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./ajaxprogrammation",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerEnseignement",
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboEnseignements]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
};

var chargerProgrammation = function () {
    if ($("select[name=comboEnseignements]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxprogrammation",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerProgrammation",
            idenseignement: $("select[name=comboEnseignements]").val()
        },
        success: function (result) {
            $(".page").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};
function validerProgrammation(){
    var frm = $("form[name=frmProgrammation]");
    $("input[name=idenseignement]").val($("select[name=comboEnseignements]").val());
    frm.submit();
}