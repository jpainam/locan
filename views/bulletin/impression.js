$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerEleves);
});

var chargerEleves = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./ajaximpression",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerEleves",
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboEleves]").html(result[0]);
            $("select[name=debutinterval]").html(result[1]);
            $("select[name=fininterval]").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function impression() {
    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }
    var periode = $("select[name=comboPeriodes]").val();
    var codeperiode = periode.substring(0, 1);
    
    console.log(codeperiode);
    //Si c'est un bulletin annuelle, diriger vers le code 0002
    // pour les bulletin sequentielle et trimestrielle, code 0001
    if(codeperiode === "A"){
        $("input[name=code]").val("0002");
    }else{
        $("input[name=code]").val("0001");
    }
    var frm = $("form[name=frmbulletin]");
    frm.submit();

}