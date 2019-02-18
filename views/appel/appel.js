var caljour;
$(document).ready(function () {
    caljour = getCalendar("datejour");
    caljour.setValue(new Date());

    $("#comboClasses").change(chargerEnseignements);
    $("select[name=comboEnseignements]").change(chargerEleves);
   
    $("#appelTable").DataTable({
        "bInfo": false,
        "paging": false,
        "columns": [
            {"width": "10%"},
            null,
            {"width": "7%"},
            {"width": "7%"},
            {"width": "7%"},
            {"width": "7%"}
        ]
    });
    /*$("input[name=retard]").each(function () {
        $(this).change(function () {
            retard($(this).val());
        });

    });*/
});

/**
 * Charges la liste des matiere lors du choix de la classe 
 * dans le combo classe
 * @returns {undefined}
 */

chargerEnseignements = function () {
    var d = caljour.getValue();
    $.ajax({
        url: "./ajax/chargerEnseignements",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "datejour": d.split(' ')[0]
        },
        success: function (result) {
            $("select[name=comboEnseignements]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

/**
 * quand on choisi la matiere, charger l'horaires de la matieres
 * et la tranche d'heure dans le comboHoraire
 * @returns {undefined}
 */
chargerEleves = function () {
    var d = caljour.getValue();
    if ($("select[name=comboEnseignements]").val() === "") {
        $("#horaires").html("De 00h:00 &agrave; 00h:00");
        return;
    }
    $.ajax({
        url: "./ajax/chargerEleves",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "idemplois": $("select[name=comboEnseignements]").val(),
            "datejour": d.split(' ')[0]
        },
        success: function (result) {
            $("#listeeleve").html(result[0]);
            $(".navigation").html(result[1]);
            var horaire = "De " + result[2].substr(0, 2) + "h:" + result[2].substr(3, 2) + " &agrave; "
                    + result[3].substr(0, 2) + "h:" + result[3].substr(3, 2);
            result[0].subs
            $("#horaires").html(horaire);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function appel(eleve) {
    if ($("input[value=R_" + eleve + "]").is(":checked")) {
        $("#R_heure_" + eleve).css({display: 'block'});
    } else {
        $("#R_heure_" + eleve).css({display: 'none'});
    }
}

function exclu(eleve) {
    if ($("input[name=E_" + eleve + "]").is(":checked")) {
        $("#E_heure_" + eleve).css({display: 'block'});
    } else {
        $("#E_heure_" + eleve).css({display: 'none'});
    }
}

function soumettreAppel() {

    var frm = $("form[name=frmappel]");
    removeRequiredFields([$("#comboClasses"), $("input[name=certifier]")]);
    if ($("#comboClasses").val() === "") {
        addRequiredFields([$("#comboClasses")]);
        alertWebix("Veuillez choisir d'abord une classe");
        return;
    }

    if (!$("input[name=certifier]").is(":checked")) {
        alertWebix("Veuillez certifier l'exactitude des donn&eacute;es saisies\n en votre nom en cochant la case certification");
        addRequiredFields([$(".navigation")]);
        return;
    }
    var d = caljour.getValue();
    frm.append($("<input type='hidden' name= 'idclasse' value= '" + $("select[name=comboClasses]").val() + "' >"));
    frm.append($("<input type='hidden' name ='datejour' value='" + d.split(' ')[0] + "' >"));
    frm.append($("<input type='hidden' name='idemplois' value='" + $("select[name=comboEnseignements]").val() + "' >"));
    
    //on envoi l'id de l'emploi, au serveur, on recupere la matiere passant a cet heure
   
    frm.submit();
}