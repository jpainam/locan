$(document).ready(function () {
    _getDatepicker("datenaiss");
    _getDatepicker("dateavancement");
    $("#preciser-libelle-dialog-form").dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Valider": function () {
                chargerDepartement();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#preciser-arr-dialog-form").dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Valider": function () {
                chargerArrondissement();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#preciser-ets-dialog-form").dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Valider": function () {
                preciserStructure();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });

    $("select[name=region]").change(chargerDepartement);
    $("select[name=structure]").change(function () {
        if ($(this).val() === "-1") {
            $("#preciser-ets-dialog-form").dialog("open");
        }
    });

    $("select[name=departement]").change(function () {
        if ($("select[name=region]").val() === "") {
            alertWebix("Pr&eacute;ciser la region d'origine");
            addRequiredFields([$("select[name=region]")]);
            $("select[name=departement]")[0].selectedIndex = 0;
            return;
        } else {
            removeRequiredFields([$("select[name=region]")]);
        }
        if ($("select[name=departement]").val() === "-1") {
            $("#preciser-libelle-dialog-form").dialog("open");
        } else {
            chargerArrondissement();
        }
    });

    $("select[name=arrondissement]").change(function () {

        if ($("select[name=departement]").val() === "") {
            alertWebix("Pr&eacute;ciser le d&eacute;partement d'origine");
            addRequiredFields([$("select[name=departement]")]);
            $("select[name=arrondissement]")[0].selectedIndex = 0;
            return;
        } else {
            removeRequiredFields([$("select[name=departement]")]);
        }
        if ($("select[name=arrondissement]").val() === "-1") {
            $("#preciser-arr-dialog-form").dialog("open");
        }
    });

});
chargerDepartement = function () {
    if ($("select[name=region]").val() === "") {
        return;
    }
    if ($("select[name=departement]").val() === "-1" && $("input[name=preciserdept]").val() === "") {
        return;
    }
    $.ajax({
        url: "../ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerDepartement",
            preciserdept: ($("select[name=departement]").val() === "-1") ? $("input[name=preciserdept]").val() : "",
            region: $("select[name=region]").val()
        },
        success: function (result) {
            $("select[name=departement]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function chargerArrondissement() {
    if ($("select[name=departement]").val() === "") {
        return;
    }
    if ($("select[name=arrondissement]").val() === "-1" && $("input[name=preciserarr]").val() === "") {
        return;
    }
    $.ajax({
        url: "../ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerArrondissement",
            preciserarr: ($("select[name=arrondissement]").val() === "-1") ? $("input[name=preciserarr]").val() : "",
            departement: $("select[name=departement]").val()
        },
        success: function (result) {
            $("select[name=arrondissement]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function preciserStructure() {
    if ($("input[name=preciserets]").val() === "") {
        return;
    }
    $.ajax({
        url: "../ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "preciserets",
            preciserets: $("input[name=preciserets]").val()
        },
        success: function (result) {
            $("select[name=structure]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function submitForm() {
    if ($("input[name=nom]").val() === "" || $("input[name=portable]").val() === "") {
        alertWebix("Veuillez remplir les champs obligatoires");
        addRequiredFields([$("input[name=nom]"), $("input[name=portable]")]);
        return;
    }
    document.forms[0].submit();
}
function effacerPhotoPersonnel() {
    $.ajax({
        url: "../photo/" + $("input[name=photopersonnel]").val(),
        type: 'POST',
        dataType: "json",
        data: $("#photoeleve").val(),
        success: function (result) {
            $("#btn_photo_action").html(result[0]);
            $("#photopersonnel").html(result[1]);
            $(".errors").html(result[2]);
            $("input[name=photopersonnel]").val(result[3]);
            $("input[name=photo]").val("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + error + " " + xhr + " " + status);
        }
    });
}
function savePhotoPersonnel() {
    if ($("input[name=photo]").val() === "") {
        alertWebix("Veuillez sélectionner le fichier image");
        return;
    }
    var formData = new FormData(document.getElementById("frmpersonnel"));

    $.ajax({
        url: "../photo/upload",
        type: 'POST',
        enctype: 'multipart/form-data',
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            $("#btn_photo_action").html(result[0]);
            //cadre pour l'affichage de l'image uploader
            $("#photopersonnel").html("<img style = 'width:200px;height:200px;' src ='" + result[1] + "' />");
            $(".errors").html(result[2]);
            //hidden photo contient le nom de la photo a sauvegarder et envoyer plutart au server
            $("input[name=photopersonnel]").val(result[3]);
            //le input type file
            $("input[name=photo]").val("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}