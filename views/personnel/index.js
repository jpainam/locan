
$(document).ready(function () {
    $("select[name=comboFonctions]").change(showPersonnelByFunction);
});

function impression(_idpersonnel) {
    
    var frm = $("<form>", {
        action: "./personnel/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: "0001"
    })).append($("<input>", {
        name: "idpersonnel",
        type: "hidden",
        value: _idpersonnel
    })).appendTo("body");

    frm.submit();

}
showPersonnelByFunction = function () {
    $.ajax({
        url: "./personnel/ajax",
        type: 'POST',
        enctype: 'multipart/form-data',
        dataType: "json",
        data: {
            "fonction": $("select[name=comboFonctions]").val()
        },
        success: function (result) {
            $(".page").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};