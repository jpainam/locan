function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboPeriodes]")]);
    if ($("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboPeriodes]")]);
        alertWebix("Veuillez remplir les champs obligatoires");
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
        name: "periode",
        type: "hidden",
        value: $("select[name=comboPeriodes]").val()
    })).appendTo("body");

    frm.submit();
}