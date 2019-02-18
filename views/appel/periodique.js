$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerPeriodique);
    $("select[name=comboPeriodes]").change(chargerPeriodique);
    if (!$.fn.DataTable.isDataTable("#tablePeriodique")) {
        $("#tablePeriodique").DataTable({
            columns: [
                {width: "5%"},
                null,
                {width: "10%"},
                {width: "10%"},
                {width: "10%"},
                {width: "10%"}
            ]
        });
    }
});

chargerPeriodique = function () {
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        return;
    }

    $.ajax({
        url: "./ajaxperiodique",
        type: "POST",
        dataType: "json",
        data: {
            idclasse: $("select[name=comboClasses]").val(),
            idperiode: $("select[name=comboPeriodes]").val(),
            action: "chargerPeriodique"
        },
        success: function (result) {
            $("#periodique-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
};

function validerSuivi() {

    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
        alertWebix("Veuillez d'abord choisir les champs obligatoires");
        return;
    }

    $("form[name=periodiqueform]").submit();
}

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
        alertWebix("Veuillez d'abord remplir les champs obligatoires");
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
        name: "idclasse",
        type: "hidden",
        value: $("select[name=comboClasses]").val()
    })).append($("<input>", {
        name: "idperiode",
        type: "hidden",
        value: $("select[name=comboPeriodes]").val()
    })).appendTo("body");
    frm.submit();
}