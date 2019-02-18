$(document).ready(function () {
    $("#eleveTable").DataTable({
        columns: [
            {"width": "10%"},
            null,
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
    if ($("input[name=" + note + "]").val() > 20 || $("input[name=" + note + "]").val() < 0) {
        alert("Veuillez entrer une note > 0 et < 20");
}
}
function check_note(_ideleve) {
    var note = "note_" + _ideleve;
    if ($("input[name=" + note + "]").val() > 20 || $("input[name=" + note + "]").val() < 0) {
        alert("Veuillez entrer une note > 0 et < 20");
    }
    $("input[name=" + note + "]").focus();
}

function soumettreNotes() {
   var frm = $("form[name=editNote]");
    frm.submit();
}