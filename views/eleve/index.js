var _idnote;
$(document).ready(function () {
    if ($("input[name=ideleve]").val() !== "") {
        chargerEleve();
        $("select[name=listeeleve]").val($("input[name=ideleve]").val());
        $("input[name=ideleve]").val("");
    }
    $("#editer-note-dialog").dialog({
        autoOpen: false,
        height: 210,
        width: 340,
        modal: true,
        resizable: false,
        buttons: {
            Modifier: function () {
                editerNote();
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
});
});
function chargerEleve() {
    
    var _ideleve = $("input[name=ideleve]").val();
    if( _ideleve === ""){
         _ideleve = $("#listeeleve").val();
    }
    if (_ideleve === "") {
        return;
    }
    $.ajax({
        url: "./eleve/ajax",
        type: 'POST',
        dataType: "json",
        data: {
            ideleve: _ideleve
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);
            $("#onglet3").html(result[2]);
            $("#onglet4").html(result[3]);
            $("#onglet5").html(result[4]);
            $("#onglet6").html(result[5]);
            $("#onglet7").html(result[6]);
        },
        error: function (xhr, status, error) {
            alertWebix("Veuillez rafraichir la page \n" + status + " " + error);
        }
    });
}
function percuRecu(_idcaisse) {
    $.ajax({
        url: "./eleve/ajaxoperation",
        type: "POST",
        dataType: "json",
        data: {
            action: "percuRecu",
            idcaisse: _idcaisse,
            "ideleve": $("#listeeleve").val()

        },
        success: function (result) {
            $("#onglet7").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function validerOperation(_idcaisse) {
    $.ajax({
        url: "./eleve/ajaxoperation",
        type: "POST",
        dataType: "json",
        data: {
            action: "validerOperation",
            idcaisse: _idcaisse,
            "ideleve": $("#listeeleve").val()
        },
        success: function (result) {
            $("#onglet7").html(result[0]);

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
    removeRequiredFields([$("#listeeleve")]);
    if ($("#listeeleve").val() === "") {
        addRequiredFields([$("#listeeleve")]);
        alertWebix("Veuillez d'abord choisir un &eacute;l&egrave;ve");
        return;
    }
    var frm = $("<form>", {
        action: "./eleve/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>",{
        name: "ideleve",
        type: "hidden",
        value: $("#listeeleve").val()
    })).appendTo("body");
    frm.submit();
}

function showEditerNote(idnote, el) {
    _idnote = idnote;
    var td = $(el).parent().prev();
    console.log(td);
    $("input[name=nouvelnote]").val(td.text());
    var tr = td.parent();
    td = tr.children("td")[1];
    $("input[name=matiere-editer]").val($(td).text());
    $("#editer-note-dialog").dialog("open");
}
function editerNote() {
    if ($("input[name=nouvelnote]").val() > 20 || $("input[name=nouvelnote]").val() < 0) {
        $("#erreur-nouvel-note").css({display: "block"});
        console.log($("input[name=nouvelnote]").val());
        return;
    }
    $.ajax({
        url: "./eleve/ajaxindex",
        type: "POST",
        dataType: "json",
        data: {
            ideleve: $("#listeeleve").val(),
            idnote: _idnote,
            action: "editerNote",
            nouvelnote: $("input[name=nouvelnote]").val()
        },
        success: function (result) {
            $("#onglet5").html(result[0]);
        },
        error: function (xhr, status, error) {
            alertWebix("Une erreur s'est produite" + error);
        }
    });
    $("#editer-note-dialog").dialog("close");
    $("#erreur-nouvel-note").css({display: "none"});
}
function deleteNote(_idnote, lblmatiere) {
    if (confirm("Etes vous sur de vouloir supprimer la note en \n " + lblmatiere)) {
        $.ajax({
            url: "./eleve/ajaxindex",
            type: "POST",
            dataType: "json",
            data: {
                ideleve: $("#listeeleve").val(),
                idnote: _idnote,
                action: "deleteNote"
            },
            success: function (result) {
                $("#onglet5").html(result[0]);
            },
            error: function (xhr, status, error) {
                alertWebix("Une erreur s'est produite" + error);
            }
        });
    }
}
