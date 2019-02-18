$(document).ready(function () {

});
function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboMatieres]")]);
    if ($("select[name=comboMatieres]").val() === "") {
        addRequiredFields([$("select[name=comboMatieres]")]);
        $("select[name=code_impression]")[0].selectedIndex = 0;
        alertWebix("Veuillez d'abord choisir une mati&egrave;re");
        return;
    }

    var frm = $("<form>", {
        action: "./imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "idmatiere",
        type: "hidden",
        value: $("select[name=comboMatieres]").val()
    })).append($("<input>", {
        name: "periode",
        type: "hidden",
        value: $("select[name=comboPeriodes]").val()
    })).appendTo("body");

    frm.submit();
}