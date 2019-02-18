$(document).ready(function () {
    $("#datedebut").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
            $("#datefin").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#datedebut").datepicker("setDate", "-60d");
    $("#datefin").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
            $("#datedebut").datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#datefin").datepicker("setDate", new Date());
    $("input[name=datedebut], input[name=datefin]").change(filtrerOperation);

    if (!$.fn.DataTable.isDataTable("#tableTotaux")) {
        $("#tableTotaux").DataTable({
            bInfo: false,
            paging: false,
            searching: false
        });
    }

    $("select[name=typeoperation]").change(filtrerOperation);
});

var filtrerOperation = function () {

    $.ajax({
        url: "./ajaxoperation",
        type: "POST",
        dataType: "json",
        data: {
            datedebut: $("input[name=datedebut]").val(),
            datefin: $("input[name=datefin]").val(),
            filtre: $("select[name=typeoperation]").val(),
            action: "filtrerOperation"
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

function percuRecu(_idcaisse) {
    $.ajax({
        url: "./ajaxoperation",
        type: "POST",
        dataType: "json",
        data: {
            action: "percuRecu",
            idcaisse: _idcaisse,
            filtre: $("select[name=typeoperation]").val(),
            datedebut: $("input[name=datedebut]").val(),
            datefin: $("input[name=datefin]").val()
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function validerOperation(_idcaisse) {
    $.ajax({
        url: "./ajaxoperation",
        type: "POST",
        dataType: "json",
        data: {
            action: "validerOperation",
            idcaisse: _idcaisse,
            filtre: $("select[name=typeoperation]").val(),
            datedebut: $("input[name=datedebut]").val(),
            datefin: $("input[name=datefin]").val()
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);

        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
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
    })).appendTo("body");
    frm.submit();
}
function supprimerCaisse($idcaisse) {
    var _ok = confirm('Etes-vous sûr de vouloir supprimer cette entrée de caisse?');
    if (_ok) {
        document.location = "./delete/" + $idcaisse;
    }
}
function supprimerMoratoire($idmoratoire) {
    var _ok = confirm('Etes-vous sûr de vouloir supprimer ce moratoire ?');
    if (_ok) {
        document.location = "./deletemoratoire/" + $idmoratoire;
    }
}
