$(document).ready(function () {
    $("#datedebut").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
            $("#datefin").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#datedebut").datepicker("setDate", new Date());

    $("#datefin").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
            $("#datedebut").datepicker("option", "maxDate", selectedDate);
        }
    });

    $("#datedebut").change(chargerAbsence);
    $("#datefin").change(chargerAbsence);

    //Popup form
    $("#appel-dialog-form").dialog({
        autoOpen: false,
        height: 360,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                ajouterAbsence();
                //$(this).dialog("close");
            },
            Fermer: function () {
                $(this).dialog("close");
            }
        }
    });
    //Bouton pour le popup
    $("#img-ajout").on("click", function () {
        $("#appel-dialog-form").dialog("open");
    });

    $("select[name=comboClasses]").change(chargerEnseignants);
    $("select[name=comboEnseignants]").change(chargerMatieres);
});

var chargerMatieres = function () {
    if ($("select[name=comboEnseignants]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxappel",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerMatieres",
            idpersonnel: $("select[name=comboEnseignants]").val(),
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboMatieres]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function ajouterAbsence() {
    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboEnseignants]"),
        $("select[name=comboMatieres]")]);
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboEnseignants]").val() === "" ||
            $("select[name=comboMatieres]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboEnseignants]"),
            $("select[name=comboMatieres]")]);
        $("#zoneAlerte").html("Tous les champs sont obligatoires");
        return;
    }
    removeRequiredFields([$("select[name=retard]"), $("select[name=absence]")]);
    if ($("select[name=retard]").val() === "" && $("select[name=absence]").val() === "") {
        addRequiredFields([$("select[name=retard]"), $("select[name=absence]")]);
        $("#zoneAlerte").html("Si c'est un retard, d&eacute;finir le retard, \n\
            sinon, d&eacute;finir une absence");
        return;
    }
    $.ajax({
        url: "./ajaxappel",
        type: "POST",
        dataType: "json",
        data: {
            action: "ajouterAbsence",
            datedebut: $("input[name=datedebut]").val(),
            datefin: $("input[name=datefin]").val(),
            idpersonnel: $("select[name=comboEnseignants]").val(),
            idenseignement: $("select[name=comboMatieres]").val(),
            absence: $("select[name=absence]").val(),
            retard: $("select[name=retard]").val(),
            autres: $("input[name=autres]").val()

        },
        success: function (result) {
            console.log(result);
            if (result[1]) {
                $("#zoneAlerte").html("<blink>Impossible d'enregistrer plus d'une fois la meme absence ou retard</blink>");
            } else {
                $("#table-absences").html(result[0]);
                $("select[name=comboEnseignants]")[0].selectedIndex = 0;
                $("select[name=comboMatieres]")[0].selectedIndex = 0;
                $("select[name=absence]")[0].selectedIndex = 0;
                $("input[name=autres]").val("");
                $("select[name=retard]")[0].selectedIndex = 0;
                $("#zoneAlerte").html("");

                $("#appel-dialog-form").dialog("close");
            }
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
var chargerEnseignants = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxappel",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerEnseignants",
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboEnseignants]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};
var chargerAbsence = function () {
    if ($("input[name=datedebut]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxappel",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerAbsence",
            datedebut: $("input[name=datedebut]").val(),
            datefin: $("input[name=datefin]").val()
        },
        success: function (result) {
            $("#table-absences").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function supprimerAbsence(_idabsence) {
    $.ajax({
        url: "./ajaxappel",
        type: "POST",
        dataType: "json",
        data: {
            action: "supprimerAbsence",
            idabsence: _idabsence,
            datedebut: $("input[name=datedebut]").val(),
            datefin: $("input[name=datefin]").val()
        },
        success: function (result) {
            $("#table-absences").html(result[0]);
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
    removeRequiredFields([$("input[name=datedebut]")]);
    if ($("input[name=datedebut]").val() === "") {
        addRequiredFields([$("input[name=datedebut]")]);
        $("select[name=code_impression]")[0].selectedIndex = 0;
        alertWebix("Veuillez d'abord choisir une date de debut");
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
        name: "datedebut",
        type: "hidden",
        value: $("input[name=datedebut]").val()
    })).append($("<input>", {
        name: "datefin",
        type: "hidden",
        value: $("input[name=datefin]").val()
    })).appendTo("body");
    frm.submit();
}
