var calpunition;
$(document).ready(function () {
    $("#comboClasses").change(chargerEleves);
    calpunition = getCalendar("datepunition");
    calpunition.setValue(new Date());
});


chargerEleves = function () {
    $.ajax({
        url: "./ajax/charger",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboEleves]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};
function soumettrePunition() {
    removeRequiredFields([$("#comboPersonnels"), $("#comboClasses"), $("select[name=comboEleves]")]);
    if ($("#comboPersonnels").val() === "" || $("#comboClasses").val() === "" || $("select[name=comboEleves]").val() === "") {
        addRequiredFields([$("#comboPersonnels"), $("#comboClasses"), $("select[name=comboEleves]")]);
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }
    var d = calpunition.getValue();
    $("input[name=datepunition]").val(d.split(' ')[0]);
    $("input[name=punipar]").val($("select[name=comboPersonnels]").val());
    var frm = $("form[name=frmpunition]");
    frm.submit();
}
