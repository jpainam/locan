$(document).ready(function () {
    $("#classeTable").DataTable({
        bInfo: false,
        paging: false,
        columns: [
            {width: "7%"},
            null,
            {width: "10%"},
            {width: "10%"}
        ]
    });
    $("select[name=comboSequences]").change(chargerSequence);
});

chargerSequence = function () {
    if ($("select[name=comboSequences]").val() === "") {
        $("#classe-content").html("");
        return;
    }
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerClasse",
            idsequence: $("select[name=comboSequences]").val()
        },
        success: function (result) {
            $("#classe-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function deverrouiller(_idclasse, _idsequence) {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "deverrouiller",
            idsequence: _idsequence,
            idclasse : _idclasse
        },
        success: function (result) {
            $("#classe-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function verrouiller(_idclasse) {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "verrouiller",
            idsequence: $("select[name=comboSequences]").val(),
            idclasse : _idclasse
        },
        success: function (result) {
            $("#classe-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}