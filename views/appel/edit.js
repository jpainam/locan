$(document).ready(function () {

});
function choisir(elm) {
    if ($(elm).val() === "") {
        $(elm).parent().removeClass("absent exclu retard");
    } else if ($(elm).val() === "A") {
        $(elm).parent().addClass('absent');
    } else if ($(elm).val() === "E") {
        $(elm).parent().addClass('exclu');
    } else if ($(elm).val() === "R") {
        $(elm).parent().addClass('retard');
    }
}

function validerAppel() {

    if (!$("input[name=certifier]").is(":checked")) {
        alertWebix("Veuillez certifier l'exactitude des donn&eacute;es saisies\n \n\
            en votre nom en cochant la case certification");
        addRequiredFields([$(".navigation")]);
        return;
    }

    var frm = $("form[name=formAppel]");

    frm.append($("<input>", {
        name: "idclasse",
        value: $("select[name=comboClasses]").val(),
        type: "hidden"
    }));
    frm.submit();
}

