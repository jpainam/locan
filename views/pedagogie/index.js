$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerEnseignement);
    $("select[name=comboEnseignements]").change(chargerChapitre);
});
var chargerEnseignement = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./pedagogie/ajaxindex",
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

var chargerChapitre = function () {
    if ($("select[name=comboEnseignements]").val() === "") {
        return;
    }
    $.ajax({
        url: "./pedagogie/ajaxindex",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerChapitre",
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

function imprimer(){
    if($("select[name=code_impression]").val() === ""){
        return;
    }
    removeRequiredFields([$("select[name=comboEnseignements]")]);
    if($("select[name=comboEnseignements]").val() === ""){
        addRequiredFields([$("select[name=comboEnseignements]")]);
        alertWebix("Veuillez choisir un enseignement");
        $("select[name=code_impression]")[0].selectedIndex = 0;
        return;
    }
    var frm = $("<form>", {
        action: "./pedagogie/imprimer", 
        target: "_blank", 
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "idenseignement",
        type: "hidden",
        value: $("select[name=comboEnseignements]").val()
    })).appendTo("body");
   frm.submit();
}