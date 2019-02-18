$(document).ready(function () {

    $("input[name=datedevoir]").datepicker();
    $("input[name=datedevoir]").datepicker("setDate", new Date());
    $("select[name=comboClasses]").change(chargerMatieres);
    $("select[name=comboEnseignements]").change(chargerEleves);
    $("select[name=comboPeriodes]").change(chargerMatieres);

    if (!$.fn.DataTable.isDataTable("#eleveTable")) {
        $("#eleveTable").DataTable({
            bInfo: false,
            paging: false,
            searching: false,
            columns: [
                {"width": "10%"},
                null,
                {"width": "7%"},
                {"width": "10%"},
                {"width": "30%"}
            ]
        });
        $("#tableNotes").DataTable({
            bInfo: false,
            paging: false,
            searching: false,
            columns: [
                {"width": "10%"},
                null,
                {"width": "7%"},
                {"width": "7%"},
                {"width": "7%"},
                {"width": "10%"},
                {"width": "20%"}
            ]
        });
    }
    $.fn.setCursorPosition = function (pos) {
        this.each(function (index, elem) {
            if (elem.setSelectionRange) {
                elem.setSelectionRange(pos, pos);
            } else if (elem.createTextRange) {
                var range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        });
        return this;
    };
});

function emptyEleveTable() {
    $("#eleveTable tr").remove();
    $("#eleveTable tbody").html("<tr><td valign='top' colspan='6' class='dataTables_empty'>Aucune donnée disponible dans le tableau</td></tr>");
}
chargerMatieres = function () {
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        emptyEleveTable();
        return;
    }

    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            idclasse: $("select[name=comboClasses]").val(),
            idsequence: $("select[name=comboPeriodes]").val(),
            "action": "chargerMatieres"
        },
        success: function (result) {
            $("select[name=comboEnseignements]").html(result[0]);
            emptyEleveTable();
            $("input[name=coeff]").val("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

chargerCoeff = function () {
    removeRequiredFields([$("select[name=comboEnseignements]")]);
    $.ajax({
        url: "./ajaxsaisie",
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
    if ($("select[name=comboEnseignements]").val() === "") {
        emptyEleveTable();
        return;
    }

    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "idenseignement": $("select[name=comboEnseignements]").val(),
            "sequence": $("select[name=comboPeriodes]").val(),
            "action": "chargerEleves"
        },
        success: function (result) {
            $("#eleve-content").html(result[0]);
            $("input[name=coeff]").val(result[1]);
            $("#eleve-cc").html(result[2]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function noter(_ideleve) {
    var note = "note_" + _ideleve;
    var nnoter = "nonNote_" + _ideleve;
    var err = "erreur_" + _ideleve;
    $("#" + err).css({backgroundColor: "transparent"});
    if ($("input[name=" + note + "]").val() === "") {
        $("input[name=" + nnoter + "]").prop("checked", true);
    } else {
        $("input[name=" + nnoter + "]").prop("checked", false);
    }
    if ($("input[name=" + note + "]").val() > 20 || $("input[name=" + note + "]").val() < 0) {
        alertWebix("Veuillez entrer une note > 0 et < 20");
        $("#" + err).css({backgroundColor: "red"});
    }
}

function check_note(_ideleve) {
    var note = "note_" + _ideleve;
    if ($("input[name=" + note + "]").val() > 20 || $("input[name=" + note + "]").val() < 0) {
        alertWebix("Veuillez entrer une note > 0 et < 20");
    }
    $("input[name=" + note + "]").setCursorPosition(1);
    $("input[name=" + note + "]").focus();
}



function soumettreNotes() {
    removeRequiredFields([$("select[name=comboPeriodes]")]);
    if ($("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboPeriodes]")]);
        alertWebix("Veuillez choisir la periode en question");
        return;
    }


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