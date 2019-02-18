function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboMatieres]")]);
    if ($("select[name=comboMatieres]").val() === "") {
        addRequiredFields([$("select[name=comboMatieres]")]);
        alertWebix("Veuillez d'abord choisir un &eacute;l&egrave;ve");
        $("select[name=code_impression]")[0].selectedIndex = 0;
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
    })).appendTo("body");

    frm.submit();
}