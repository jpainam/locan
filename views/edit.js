$(document).ready(function () {
    $("#eleveTable").DataTable({
        bInfo: false,
        columns: [
            {"width": "10%"},
            null,
            {"width": "7%"},
            {"width": "7%"},
            {"width": "10%"},
            {"width": "30%"}
        ]
    });
});

function noter(_ideleve) {
    var note = "note_" + _ideleve;
    var nnoter = "nonNote_" + _ideleve;

    if ($("input[name=" + note + "]").val() === "") {
        $("input[name=" + nnoter + "]").prop("checked", true);
    } else {
        $("input[name=" + nnoter + "]").prop("checked", false);
    }
}

function soumettreNotes(){
   var frm = $("form[name=editNote]");
    frm.submit();
}