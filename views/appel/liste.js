var calDateDebut, calDateFin;

$(document).ready(function () {
    calDateDebut = getCalendar("datedebut");
    calDateFin = getCalendar("datefin");

    $("select[name=comboClasses]").change(chargerListe);
});


chargerListe = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    var d1 = calDateDebut.getValue(), d2 = calDateFin.getValue();
    var datedebut = d1.split(' ')[0];
    var datefin = d2.split(' ')[0];


    removeRequiredFields([$("#datedebut"), $("#datefin")]);
    if (datedebut === "" || datefin === "") {
        $("select[name=comboClasses]")[0].selectedIndex = 0;
        addRequiredFields([$("#datedebut"), $("#datefin")]);
        alertWebix("Veuillez choisir les dates de fin et debut");
        return;
    }
    var date1 = new Date(datedebut);
    console.log(date1);
    if (date1.getDay() !== 1) {
        $("select[name=comboClasses]")[0].selectedIndex = 0;
        alertWebix("La semaine doit commencer un jour Lundi");
        return;
    }

    var date2 = new Date(datefin);
    if (date2.getDay() !== 5) {
        $("select[name=comboClasses]")[0].selectedIndex = 0;
        alertWebix("La semaine doit se terminer un vendredi");
        return;
    }
    //Verifier qu'il ya une difference de 5 jours entre les deux date

    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

    if (diffDays !== 4) {
        $("select[name=comboClasses]")[0].selectedIndex = 0;
        alertWebix("La semaine doit s'etendre sur 5 jours consecutives");
        return;
    }

    //Proceder a la validation si tout va bien

    $.ajax({
        url: "./ajaxliste",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "datedebut": datedebut,
            "datefin": datefin
        },
        success: function (result) {
            $("#listeappel").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + status + " " + error);
        }
    });
}

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("#comboClasse"), $("#datedebut"), $("#datefin")]);
    if ($("#comboClasse").val() === "" || calDateDebut.getValue() === "" || calDateFin.getValue() === "") {
        addRequiredFields([$("#comboClasse"), $("#datedebut"), $("#datefin")]);
        alertWebix("Veuillez d'abord remplir les champs obligatoires");
        return;
    }
    var d1 = calDateDebut.getValue();
    var d2 = calDateFin.getValue();

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
        name: "datedebut",
        type: "hidden",
        value: d1.split(' ')[0]
    })).append($("<input>", {
        name: "datefin",
        type: "hidden",
        value: d2.split(' ')[0]
    })).appendTo("body");
    frm.submit();
}