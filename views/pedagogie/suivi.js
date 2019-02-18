$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerEnseignement);
    $("select[name=comboEnseignements]").change(chargerProgrammation);

});

var chargerEnseignement = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./ajaxsuivi",
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
        url: "./ajaxsuivi",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerProgrammation",
            idenseignement: $("select[name=comboEnseignements]").val()
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};
function validerSuivi() {
    var frm = $("form[name=frmSuivi]");
    $("input[name=idenseignement]").val($("select[name=comboEnseignements]").val());
    frm.submit();
}

function choisir(elm) {
    $(elm).parent().removeClass("present absent");
    if ($(elm).val() === "0") {
        $(elm).parent().addClass('absent');
    } else {
        $(elm).parent().addClass('present');
    }
}


function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboEnseignements]")]);
    if ($("select[name=comboEnseignements]").val() === "") {
        addRequiredFields([$("#listeeleve")]);
        alertWebix("Veuillez d'abord choisir un enseignement");
        return;
    }
    var frm = $("<form>", {
        action: "./imprimer",
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
