$(document).ready(function () {
    $("#tableActivite").DataTable({
        bInfo: false,
        paging: false,
        searching: false,
        scrollY: $(".page").height() - 120,
        columns: [
            {"width": "5%"},
            null
        ]
    });
    $("select[name=comboClasses]").change(chargerEnseignement);
    $("select[name=comboEnseignements]").change(chargerActivite);
});

var chargerEnseignement = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./activite/ajaxindex",
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
var chargerActivite = function () {
    if ($("select[name=comboEnseignements]").val() === "") {
        return;
    }
    $.ajax({
        url: "./activite/ajaxindex",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerActivite",
            idenseignement: $("select[name=comboEnseignements]").val()
        },
        success: function (result) {
            $("#activite-content").html(result[0]);
            $("#chapitre-content").html("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function imprimer() {
    removeRequiredFields([$("select[name=comboEnseignements]"), $("select[name=comboClasses]")]);

    if ($("select[name=comboEnseignements]").val() === "" || $("select[name=comboClasses]").val() === "") {
        addRequiredFields([$("select[name=comboEnseignements]"), $("select[name=comboClasses]")]);
        $("select[name=code_impression]")[0].selectedIndex = 0;
        alertWebix("Veuillez choisir un enseignement et une classe");
        return;
    }
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    var frm = $("<form>", {
        action: "./activite/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).appendTo("body");
    frm.submit();
}
