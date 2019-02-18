var caljour, idabsence, calau, caldu;
$(document).ready(function () {
    caljour = getCalendar("datejour");
    calau = getCalendar("dateau");
    caldu = getCalendar("datedu");

    caljour.setValue(new Date());

    $("#justificationTable").DataTable({
        "bInfo": false,
        "paging": false,
        "searching": false,
        "scrollY": $(".page").height() - 110,
        "columns": [
            {"width": "5%"},
            null,
            {"width": "15%"},
            {"width": "7%"},
            {"width": "7%"},
            {"width": "10%"}

        ]
    });
    $("select[name=comboClasses]").change(listeAbsences);
});
/**
 * Charge la combobox contenant la liste des appel 
 * realiser pour cette classe a cette date, 
 * charge le combo Appels
 * @returns {undefined}
 */
listeAbsences = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    var d = caljour.getValue();
    if (d === "") {
        alertWebix("Veuillez choisir la date de l'appel");
        $("select[name=comboClasses]")[0].selectedIndex = 0;
        return;
    }
    $.ajax({
        url: "./ajaxjustification",
        type: "POST",
        dataType: 'json',
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "datejour": d.split(' ')[0],
            "action": "chargerAbsences"
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("select[name=comboEleves]").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function openFormJustification(elmt, _id) {
    //var tab = elmt.parentNode.previousSibling.previousSibling.innerHTML.split(':');
    //$("input[name=typejustification]").val(tab[0]);
    $("#justification-dialog-form").dialog("open");
    idabsence = _id;
}
/**
 * Procede a la justification de l'absence stocker dans idabsence
 * @returns {undefined}
 */
function justifier() {
    var d = caljour.getValue();
    if ($("select[name=comboClasses]").val() === "") {
        alertWebix("Veuillez d'abord choisir une classe");
        return;
    }
    $.ajax({
        url: "./ajaxjustification/justifier",
        type: "POST",
        dataType: "json",
        data: {
            "idabsence": idabsence,
            "motif": $("input[name=motif]").val(),
            "description": $("textarea[name=description]").val(),
            "action": "justifier",
            "idclasse": $("select[name=comboClasses]").val(),
            "datejour": d.split(' ')[0]
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
/**
 * 
 * @param {type} _id1 : id de la justification (Supprimer cette entree)
 * @param {type} _id2 : id de l'absence a justifier (Definir ce champs a NULL)
 * @returns {undefined}
 */
function supprimerJustification(_id1, _id2) {
    var d = caljour.getValue();
    if ($("select[name=comboClasses]").val() === "") {
        alertWebix("Veuillez d'abord choisir une classe");
        return;
    }

    $.ajax({
        url: "./ajaxjustification/supprimerjustification",
        "type": "POST",
        dataType: "json",
        data: {
            "idjustification": _id1,
            "idabsence": _id2,
            "action": "supprimerjustification",
            "idclasse": $("select[name=comboClasses]").val(),
            "datejour": d.split(' ')[0]
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function justifierParPeriode() {
    var d1 = calau.getValue(), d2 = caldu.getValue();
    var dateau = d1.split(' ')[0], datedu = d2.split(' ')[0];

    removeRequiredFields([$("#datedu"), $("#dateau"), $("select[name=comboEleves]"), $("#comboClasses")]);
    if (dateau === "" || datedu === "" || $("select[name=comboEleves]").val() === "") {
        addRequiredFields([$("#datedu"), $("#dateau"), $("select[name=comboEleves]"), $("#comboClasses")]);
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }

    var frm = $("form[name=frmJustificationParPeriode]");
   frm.append($("<input>", {
        name: "idclasse",
        type: "hidden",
        value: $("#comboClasses").val()
    })).append($("<input>", {
        name: "datedu",
        type: "hidden",
        value: datedu
    })).append($("<input>", {
        name: "dateau",
        type: "hidden",
        value: dateau
    }));
    
    frm.submit();
}

function printJustification(idjustification, idabsence){
    var d = caljour.getValue();
    var frm = $("<form>", {
        action: "./imprimer",
        method: "POST",
        target: "_blank"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: "0004"
    })).append($("<input>", {
        type: "hidden",
        name: "idabsence",
        value: idabsence
    })).append($("<input>", {
        type: "hidden",
        name: "idjustification",
        value: idjustification
    })).appendTo("body");
    
    frm.submit();
}