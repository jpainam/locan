$(document).ready(function () {
    $("#ajout-manuel").on("click", function () {
        openAjoutForm();
    });
    $("#ajout-manuel-dialog").dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                ajoutManuel();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#edit-manuel-dialog").dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Modifier": function () {
                editManuel();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    if (!$.fn.DataTable.isDataTable("#tableManuel")) {
        $("#tableManuel").DataTable({
            bInfo: false,
            paging: false,
            columns: [
                null,
                null,
                null,
                {"width": "13%"},
                {"width": "7%"}
            ]
        });
    }
});
function openAjoutForm() {
    $("input[name=titre]").val("");
    $("textarea[name=editeurs]").val("");
    $("textarea[name=auteurs]").val("");
    $("input[name=prix]").val("");
    $("#ajout-manuel-dialog").dialog("open");
}
function openEditForm(__idmanuel) {
    $.ajax({
       url: "./manuelscolaire/ajax",
       type: "POST",
       dataType: "json",
       data: {
           idmanuel: __idmanuel,
           action: "fetch_edit"
       },
       success: function(result){
            $("input[name=idmanuel]").val(__idmanuel),
            $("input[name=edit_titre]").val(result[0]);
            $("textarea[name=edit_editeurs]").val(result[1]);
            $("textarea[name=edit_auteurs]").val(result[2]);
            $("input[name=edit_prix]").val(result[3]);
       },
       error: function(xhr){
           alert(xhr.responseText);
       }
    });
   
    $("#edit-manuel-dialog").dialog("open");
}
function ajoutManuel() {
    if($("input[name=titre]").val() === ""){
        return;
    }
    $.ajax({
        url: "./manuelscolaire/ajax",
        type: "POST",
        dataType: "json",
        data: {
            action: "ajout",
            titre: $("input[name=titre]").val(),
            editeurs: $("textarea[name=editeurs]").val(),
            auteurs: $("textarea[name=auteurs]").val(),
            prix: $("input[name=prix]").val()
        },
        success: function (result) {
            $("#manuel-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function editManuel() {
    if($("input[name=edit_titre]").val() === ""){
        return;
    }
    $.ajax({
        url: "./manuelscolaire/ajax",
        type: "POST",
        dataType: "json",
        data: {
            action: "submit_edit",
            idmanuel: $("input[name=idmanuel]").val(),
            titre: $("input[name=edit_titre]").val(),
            editeurs: $("textarea[name=edit_editeurs]").val(),
            auteurs: $("textarea[name=edit_auteurs]").val(),
            prix: $("input[name=edit_prix]").val()
        },
        success: function (result) {
            $("#manuel-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function supprimerManuel(__idmanuel, __titre) {
    var ok = confirm("Etes vous sûr de vouloir supprimer le manuel " + __titre + " ?");
    if (ok) {
        document.location = "./manuelscolaire/delete/" + __idmanuel;
    }
}
function imprimer() {
    if($("select[name=code_impression]").val() === ""){
        return;
    }
    
    var frm = $("<form>", {
        action: "./manuelscolaire/imprimer", 
        target: "_blank", 
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "type_impression",
        type: "hidden",
        value: $("input[name=type_impression]:checked").val()
    })).appendTo("body");
    
   frm.submit();
}