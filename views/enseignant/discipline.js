$(document).ready(function () {
    $("#datedu").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
            $("#dateau").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#dateau").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
            $("#datedu").datepicker("option", "maxDate", selectedDate);
        }
    });
    $("input[name=datedu], input[name=dateau]").change(chargerAbsences);
});

var chargerAbsences = function () {
    if ($("input[name=datedu]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxdiscipline",
        type: "POST",
        dataType: "json",
        data: {
            datedebut: $("input[name=datedu]").val(),
            datefin: $("input[name=dateau]").val(),
            action: "chargerAbsences"
        },
        success: function (result) {
            $("#absence-content").html(result[0]);
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

    removeRequiredFields([$("input[name=datedu]")]);
    if ($("input[name=datedu]").val() === "") {
        addRequiredFields([$("input[name=datedu]")]);
        $("select[name=code_impression]")[0].selectedIndex = 0;
        alertWebix("Veuillez choisir la date de d&eacute;but");
        return;
    }
    /*var d1 = calDateDu.getValue().split(' ')[0];
     var d2 = calDateAu.getValue().split(' ')[0];*/
    var frm = $("<form>", {
        action: "./imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "datedebut",
        type: "hidden",
        value: $("input[name=datedu]").val()
    })).append($("<input>", {
        name: "datefin",
        type: "hidden",
        value: $("input[name=dateau]").val()
    })).appendTo("body");
    frm.submit();
}

function imprimerAbsence(_idpersonnel) {
    var frm = $("<form>", {
        action: "./imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: "0008"
    })).append($("<input>", {
        name: "datedebut",
        type: "hidden",
        value: $("input[name=datedu]").val()
    })).append($("<input>", {
        name: "datefin",
        type: "hidden",
        value: $("input[name=dateau]").val()
    })).append($("<input>", {
        name: "idpersonnel",
        type: "hidden",
        value: _idpersonnel
    })).appendTo("body");
    frm.submit();
}