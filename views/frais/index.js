$(document).ready(function () {
    $("#fraisTable").DataTable({
        "bInfo": false,
        "searching": false,
        "paging": false,
        scrollY : $(".page").height() - 50,
        "columns": [
            {"width": "20%"},
            null,
			null,
            {"width": "15%"},
            {"width": "15%"},
            {"width": "5%"}
        ]
    });
});


function imprimer() {
    if($("select[name=code_impression]").val() === ""){
        return;
    }
    
    var frm = $("<form>", {
        action: "./frais/imprimer", 
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
