$(document).ready(function () {
    $("#comboClasses").change(chargerDonnees);

});

chargerDonnees = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }
    $.ajax({
        url: "./classe/ajaxclasse",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);
            $("#onglet3").html(result[2]);
            $("#onglet4").html(result[3]);
            $("#prof-principal").html(result[4]);
            $("#cpe-principal").html(result[5]);
            $("#resp-admin").html(result[6]);
            $("#effectif").html(result[7]);
            $("#total-frais").html(result[8]);
            $("#onglet5").html(result[9]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboClasses]")]);
    if ($("select[name=comboClasses]").val() === "") {
        alertWebix("Veuillez d'abord choisir une classe");
        addRequiredFields([$("select[name=comboClasses]")]);
        return;
    }
    var frm = $("<form>", {
        action: "./classe/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "type_impression",
        type: "hidden",
        value: $("input[name=type_impression]:checked").val()
    })).append($("<input>", {
        name: "idclasse",
        type: "hidden",
        value: $("select[name=comboClasses]").val()
    })).appendTo("body");


    var frais = $(".idsfrais:checked").map(function () {
        return this.value;
    }).get();

    console.log(frais);

    if ($("select[name=code_impression]").val() === "0003") {
        frm.append($("<input>", {
            name: "frais",
            type: "hidden",
            value: JSON.stringify(frais)
        }));
    }
    frm.submit();
}

function envoyerRappel() {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }
    $.ajax({
        url: "./classe/envoyerRappel",
        type: "POST",
        dataType: "json",
        data: {
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("#onglet5").html(result[1]);
            if(result[0]){
                alertWebix("Messages de rappel envoy&eacute; avec succ&egrave;s");
            }else{
                alertWebix("Erreur lors de l'envoi des messages de rappel");
            }
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + status + " " + error);
        }
    });
}
function imprimerCompte(_ideleve) {

    removeRequiredFields([$("select[name=comboClasses]")]);
    if ($("select[name=comboClasses]").val() === "") {
        alertWebix("Veuillez d'abord choisir une classe");
        addRequiredFields([$("select[name=comboClasses]")]);
        return;
    }
    var frm = $("<form>", {
        action: "./eleve/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: "0004"
    })).append($("<input>", {
        name: "ideleve",
        type: "hidden",
        value: _ideleve
    })).appendTo("body");

    frm.submit();

}