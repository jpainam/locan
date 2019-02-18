$(document).ready(function () {
    if (!$.fn.DataTable.isDataTable("#sauvegardeTable")) {
        $("#sauvegardeTable").DataTable({
            bInfo: false,
            searching: false,
            paging: false,
            scrollY: $(".page").height() - 120,
            columns: [
                {"width": "5%"},
                null,
                {"width": "10%"},
                {"width": "7%"},
                {"width": "5%"}
            ]
        });
    }
});
function nouvelleSauvegarde() {
    $.ajax({
        url: "sauvegarde/ajaxSauvegarde",
        data: {
            action: "nouvelle"
        },
        type: "POST",
        dataType: "html",
        success: function (result) {
            $(".page").html(result);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function supprimerSauvegarde(_idsauvegarde){
    if(!confirm("Etes vous sur de vouloir supprimer cette sauvegarde")){
        return;
    }
     $.ajax({
        url: "sauvegarde/ajaxSauvegarde",
        data: {
            action: "supprimer",
            idsauvegarde : _idsauvegarde
        },
        type: "POST",
        dataType: "html",
        success: function (result) {
            $(".page").html(result);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function telechargerSauvegarde(_idsauvegarde){
     var __url = $(location).attr("pathname");
    __url = __url.split("/");
   
    var __location = $(location).attr("pathname");
    if(__url.length === 3){
        __location += "/telecharger/" + _idsauvegarde;
    }
     window.location = __location;
}

function restaurerSauvegarde(_idsauvegarde){
    alert("Vous n'avez pas les droit de restaurer une sauvegarder\n\n\
Contactez l'administrateur");
    /*if(!confirm("Voulez vous restaurer une ancienne sauvegarde?")){
        return;
    }
     $.ajax({
        url: "sauvegarde/ajaxSauvegarde",
        data: {
            action: "restaurer",
            idsauvegarde : _idsauvegarde
        },
        type: "POST",
        dataType: "html",
        success: function (result) {
            $(".page").html(result);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });*/
}