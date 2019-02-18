$(document).ready(function () {
    $("select[name=comboEnseignements]").change(chargerNotation);
    $("select[name=comboPeriodes]").change(chargerNotation);
});


chargerNotation = function () {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerNotation",
            idenseignement: $("select[name=comboEnseignements]").val(),
            idperiode: $("select[name=comboPeriodes]").val()
        },
        success: function (result) {
            $("#verrouillage-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function supprimerVerrouillage(_id) {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "deverrouiller",
            idenseignement: $("select[name=comboEnseignements]").val(),
            idperiode: $("select[name=comboPeriodes]").val(),
            idnotation: _id
        },
        success: function (result) {
            $("#verrouillage-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function btnVerrouiller(_id) {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "verrouiller",
            idenseignement: $("select[name=comboEnseignements]").val(),
            idperiode: $("select[name=comboPeriodes]").val(),
            idnotation: _id
        },
        success: function (result) {
            $("#verrouillage-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}