$(document).ready(function () {
    $("select[name=comboEnseignants]").change(chargerDonnees);
});

chargerDonnees = function () {
    if ($("select[name=comboEnseignants]").val() === "") {
        return;
    }
    $.ajax({
        url: "./enseignant/ajax",
        type: "POST",
        dataType: "json",
        data: {
            "idpersonnel": $("select[name=comboEnseignants]").val()
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);
            $("#onglet3").html(result[2]);
            $("#onglet4").html(result[3]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};
function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("#comboEnseignants")]);
    if ($("#comboEnseignants").val() === "") {
        $("select[name=code_impression]")[0].selectedIndex = 0;
        addRequiredFields([$("#comboEnseignants")]);
        alertWebix("Veuillez d'abord choisir un enseignant");

        return;
    }
    var frm = $("<form>", {
        action: "./enseignant/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "idpersonnel",
        type: "hidden",
        value: $("#comboEnseignants").val()
    })).appendTo("body");
    frm.submit();
}