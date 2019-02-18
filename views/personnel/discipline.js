function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    /*removeRequiredFields([$("#comboEnseignants")]);
    if ($("#comboEnseignants").val() === "") {
        $("select[name=code_impression]")[0].selectedIndex = 0;
        addRequiredFields([$("#comboEnseignants")]);
        alertWebix("Veuillez d'abord choisir un enseignant");

        return;
    } */
    
    var frm = $("<form>", {
        action: "./imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).appendTo("body");
    frm.submit();
}