$(document).ready(function(){
    
});

function imprimerMoratoire(_idmoratoire){
    var frm = $("<form>", {
        action: "../imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: "0001"
    })).append($("<input>", {
        name: "idmoratoire",
        type: "hidden",
        value: _idmoratoire
    })).appendTo("body");
    frm.submit();
}