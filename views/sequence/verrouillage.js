$(document).ready(function () {
    $("#sequenceTable").DataTable({
        bInfo: false,
        paging: false,
        searching: false,
        scrollY: $(".page").height() - 75,
        columns: [
            {"width": "7%"},
            null,
            {"width": "15%"},
            {"width": "15%"},
            {"width": "5%"},
            {"width": "7%"}
        ]
    });
});

function deverrouiller(_id) {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "deverrouiller",
            idsequence: _id
        },
        success: function (result) {
            $("#sequence-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function verrouiller(_id) {
    $.ajax({
        url: "./ajaxverrouillage",
        type: "POST",
        dataType: "json",
        data: {
            action: "verrouiller",
            idsequence: _id
        },
        success: function (result) {
            $("#sequence-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}