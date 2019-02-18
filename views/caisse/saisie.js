$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerComptes);
    $("select[name=comboComptes]").change(chargerPhoto);
});

var chargerComptes = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            idclasse: $("select[name=comboClasses]").val(),
            action: "chargerComptes"
        },
        success: function (result) {
            $("select[name=comboComptes]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s' est produite " + xhr + " " + error);
        }
    });

};

var chargerPhoto = function () {
    removeRequiredFields([$("select[name=comboClasses]")]);

    if ($("select[name=comboJournals]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]")]);
        alertWebix("Veuillez d'abord choisir une classe");
        return;
    }
    if ($("select[name=comboComptes]").val() === "") {
        $(".photo-eleve").attr("src", "");
        return;
    }

    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            idcompte: $("select[name=comboComptes]").val(),
            action: "chargerPhoto"
        },
        success: function (result) {
            $(".photo-eleve").attr("src", result[0]);
            $("input[name=idjournal]").val(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s' est produite " + xhr + " " + error);
        }
    });

};

function ValiderCaisse() {
    var frm = $("form[name=frmcaisse]");
    removeRequiredFields([$("input[name=reftransaction]"), $("select[name=typetransaction]"),
        $("input[name=description]"), $("input[name=montant]"),
        $("select[name=comboClasses]"), $("select[name=comboComptes]")]);

    if ($("input[name=reftransaction]").val() === "" || $("select[name=typetransaction]").val() === "" ||
            $("input[name=description]").val() === "" || $("input[name=montant]").val() === ""
            || $("select[name=comboClasses]").val() === "" || $("select[name=comboComptes]").val() === "") {
        addRequiredFields([$("input[name=reftransaction]"), $("select[name=typetransaction]"),
            $("input[name=description]"), $("input[name=montant]"), $("select[name=comboClasses]"),
            $("select[name=comboComptes]")]);
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }
    $("input[name=idcompte]").val($("select[name=comboComptes]").val());
    frm.submit();
}

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboComptes]")]);
    if ($("select[name=comboComptes]").val() === "") {
        addRequiredFields([$("select[name=comboComptes]")]);
        $("select[name=code_impression]")[0].selectedIndex = 0;
        alertWebix("Veuillez d'abord choisir un compte");
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
        name: "idcompte",
        type: "hidden",
        value: $("select[name=comboComptes]").val()
    })).appendTo("body");
    frm.submit();
}
