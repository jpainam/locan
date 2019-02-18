$(document).ready(function () {
    $("#dateexclusion").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true
    });
    $("#dateexclusion").datepicker("setDate", new Date());
    $("#dialog-5").dialog({
        autoOpen: false,
        height: 200,
        width: 375,
        modal: true,
        resizable: false,
        buttons: {
            Ajouter: function () {
                soumettreExclus();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("select[name=classes]").change(function () {
        $.ajax({
            url: "./exclusajax",
            type: 'POST',
            dataType: "json",
            data: {
                classe: $("select[name=classes]").val(),
                action: "chargerExclus"
            },
            success: function (result) {
                $("#eleve-exclus").html(result[0]);
                $("#eleve-classe").html(result[1]);
            },
            error: function (xhr, status, error) {
                alertWebix("Erreur lors de l'appel AJAX");
            }
        });
    });
});
function ajouterExclus() {
    removeRequiredFields([$("select[name=classes]")]);
    if ($("select[name=classes]").val() === "") {
        addRequiredFields([$("select[name=classes]")]);
        alertWebix("Veuillez d'abord choisir une classe");
        return;
    }
    $("#dialog-5").dialog("open");
}
function soumettreExclus() {
    if ($("select[name=eleve-classe]").val() === "") {
        return;
    }
    $.ajax({
        url: "./exclusajax",
        type: 'POST',
        dataType: "json",
        data: {
            ideleve: $("select[name=eleve-classe]").val(),
            action: "ajouterExclus",
            dateexclusion: $("input[name=dateexclusion]").val()
        },
        success: function (result) {
            $("#eleve-exclus").html(result[0]);
        },
        error: function (xhr, status, error) {
            alertWebix("Erreur lors de l'appel AJAX lors de la soumission");
        }
    });
}
function supprimerExclus(ideleve) {
    $.ajax({
        url: "./exclusajax",
        type: 'POST',
        dataType: "json",
        data: {
            ideleve: ideleve,
            action: "supprimerExclus",
            classe: $("select[name=classes]").val()
        },
        success: function (result) {
            console.log(result[0]);
            $("#eleve-exclus").html(result[0]);
        },
        error: function (xhr, status, error) {
            alertWebix("Erreur lors de l'appel AJAX lors de la soumission");
        }
    });
}