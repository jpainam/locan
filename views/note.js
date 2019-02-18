var calDateDevoir;

$(document).ready(function () {
    calDateDevoir = getCalendar("datedevoir");
    
    $("#preciser-libelle-dialog-form").dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Valider": function () {
                $("input[name=description]").val($("input[name=libelle]").val());
                $("select[name=comboTypes] option:selected").text($("input[name=description]").val());
                $(this).dialog("close");
            },
            Annuler: function () {
                $("select[name=comboTypes]")[0].selectedIndex = 0;
                $(this).dialog("close");
            }
        }
    });

    $("select[name=comboClasses]").change(chargerMatieres);
    $("select[name=comboEnseignements]").change(chargerCoeff);
    $("select[name=comboPeriodes]").change(chargerEleves);

    $("select[name=comboTypes]").change(setDescription);

    $("#eleveTable").DataTable({
        bInfo: false,
        paging: false,
        searching: false,
        columns: [
            {"width": "10%"},
            null,
            {"width": "7%"},
            {"width": "7%"},
            {"width": "10%"},
            {"width": "30%"}
        ]
    });
});


setDescription = function () {
    removeRequiredFields([$("select[name=comboTypes]")]);

    if ($("select[name=comboTypes]").val() === "") {
        return;
    }
    // Ouvrir un formulaire pour demander la saisie du libelle
    if ($("select[name=comboTypes]").val() === "3") {
        $("#preciser-libelle-dialog-form").dialog("open");
    } else {
        $("input[name=description]").val($("select[name=comboTypes] option:selected").text());
    }
};

chargerMatieres = function () {
    removeRequiredFields([$("select[name=comboClasses]")]);
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajax",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "action": "chargerMatieres"
        },
        success: function (result) {
            $("select[name=comboEnseignements]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

chargerCoeff = function () {
    removeRequiredFields([$("select[name=comboEnseignements]")]);
    $.ajax({
        url: "./ajax",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "action": "chargerCoeff",
            "idenseignement": $("select[name=comboEnseignements]").val()
        },
        success: function (result) {
            $("input[name=coeff]").val(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

chargerEleves = function () {
    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboEnseignements]"),
        $("select[name=comboTypes]"), $("select[name=comboPeriodes]")]);
    if ($("select[name=comboClasses]").val() === "" ||
            $("select[name=comboEnseignements]").val() === "" ||
            $("select[name=comboTypes]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboEnseignements]"), $("select[name=comboTypes]")]);

        //$("#comboPeriodes option:first").attr("selected", true);
        $("#comboPeriodes")[0].selectedIndex = 0;
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }
    
    if($("select[name=comboPeriodes]").val() === ""){
        return;
    }
    
    $.ajax({
        url: "./ajax",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "idenseignement": $("select[name=comboEnseignements]").val(),
            "typenote": $("select[name=comboTypes]").val(),
            "sequence": $("select[name=comboPeriodes]").val(),
            "action": "chargerEleves"
        },
        success: function (result) {
            $("#eleve-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function noter(_ideleve) {
    var note = "note_" + _ideleve;
    var nnoter = "nonNote_" + _ideleve;

    if ($("input[name=" + note + "]").val() === "") {
        $("input[name=" + nnoter + "]").prop("checked", true);
    } else {
        $("input[name=" + nnoter + "]").prop("checked", false);
    }
}

function soumettreNotes() {
    removeRequiredFields([$("select[name=comboPeriodes]")]);
    if ($("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboPeriodes]")]);
        alertWebix("Veuillez choisir la periode en question");
        return;
    }
    
    var d = calDateDevoir.getValue();
    $("input[name=datedevoir]").val(d.split(' ')[0]);

    var frm = $("form[name=saisienotes]");
    frm.append("<input name='idenseignement' value ='" + $("select[name=comboEnseignements]").val() + "' type='hidden'>");
    frm.append("<input name='sequence' value='" + $("select[name=comboPeriodes]").val() + "' type='hidden'>");
    frm.append("<input name='typenote' value='" + $("select[name=comboTypes]").val() + "' type='hidden' >");

    frm.append("<input name='idclasse'  value='" + $("select[name=comboClasses]").val() + "' type='hidden' >");
    frm.append("<input name='notesur' value='" + $("input[name=notesur]").val() + "' type='hidden' >");
    frm.submit();
}

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("#comboClasses"), $("select[name=comboEnseignements]")]);
    if ($("#comboClasses").val() === "" || $("select[name=comboEnseignements]").val() === "") {
        addRequiredFields([$("#comboClasses"), $("select[name=comboEnseignements]")]);

        $("select[name=code_impression]")[0].selectedIndex = 0;
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
        value: $("#comboClasses").val()
    })).append($("<input>", {
        name: "idenseignement",
        type: "hidden",
        value: $("select[name=comboEnseignements]").val()
    })).appendTo("body");

    frm.submit();
}