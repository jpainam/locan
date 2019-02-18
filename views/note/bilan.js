$(document).ready(function(){
   $("select[name=comboClasses]").change(chargerRecapitulatif);
    $("select[name=comboPeriodes]").change(chargerRecapitulatif);
});

chargerRecapitulatif = function () {
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        return;
    }
    $.ajax({
        url: "./ajaxrecapitulatif",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerRecapitulatif",
            idclasse: $("select[name=comboClasses]").val(),
            periode: $("select[name=comboPeriodes]").val()
        },
        success: function (result) {
            $("#recapitulatif-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
};

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);

        $("select[name=code_impression]")[0].selectedIndex = 0;
        alertWebix("Veuillez d'abord remplir les champs obligatoires");
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
        name: "idclasse",
        type: "hidden",
        value: $("select[name=comboClasses]").val()
    })).append($("<input>", {
        name: "periode",
        type: "hidden",
        value: $("select[name=comboPeriodes]").val()
    })).appendTo("body");

    frm.submit();
}