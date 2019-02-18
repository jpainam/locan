$(document).ready(function () {
    $("#tableMatieres").DataTable({
        "bInfo": true,
        "columns": [
            {"width": "10%"},
            null,
            {"width": "7%"}
        ]
    });
});
function imprimer() {
    if($("select[name=code_impression]").val() === ""){
        return;
    }
    
    var frm = $("<form>", {
        action: "./matiere/imprimer", 
        target: "_blank", 
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).appendTo("body");
    
   frm.submit();
}
