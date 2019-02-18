var __idactivite, __idchapitre;
$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerEnseignement);
    $("select[name=comboEnseignements]").change(chargerActivite);


    $("#activite-dialog-form").dialog({
        autoOpen: false,
        height: 160,
        width: 375,
        modal: true,
        resizable: false,
        buttons: {
            "Editer": function () {
                editerActivite();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#chapitre-dialog-form").dialog({
        autoOpen: false,
        height: 160,
        width: 375,
        modal: true,
        resizable: false,
        buttons: {
            "Editer": function () {
                editerChapitre();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
});

function modifierActivite(_idactivite) {
    $("#activite-dialog-form").dialog("open");
    __idactivite = _idactivite;

}
function modifierChapitre(_idchapitre, _idactivite) {
    $("#chapitre-dialog-form").dialog("open");
    __idactivite = _idactivite;
    __idchapitre = _idchapitre;

}
function editerActivite() {
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "editerActivite",
            idactivite: __idactivite,
            description: $("input[name=txtdialogactivite]").val(),
            idenseignement: $("select[name=comboEnseignements]").val()
        },
        success: function (result) {
            $("#activite-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
}
function editerChapitre() {
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "editerChapitre",
            idactivite: __idactivite,
            description: $("input[name=txtdialogchapitre]").val(),
            idchapitre: __idchapitre
        },
        success: function (result) {
            $("#chapitre-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
}


var chargerEnseignement = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerEnseignement",
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboEnseignements]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
};

var chargerActivite = function () {
    removeRequiredFields([$("select[name=comboClasses]")]);
    if ($("select[name=comboClasses]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]")]);
        alertWebix("Veuillez d'abord choisir une classe");
        return;
    }

    if ($("select[name=comboEnseignements]").val() === "") {
        return;
    }

    $.ajax({
        url: "ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerActivite",
            idenseignement: $("select[name=comboEnseignements]").val()
        },
        success: function (result) {
            $("#activite-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
};

function chargerChapitre(_idactivite) {
    if ($("select[name=comboEnseignements]").val() === "") {
        addRequiredFields([$("select[name=comboEnseignements]")]);
        alertWebix("Veuillez choisir une mati&egrave;re");
        return;
    }
    $.ajax({
        url: "ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerChapitre",
            idactivite: _idactivite
        },
        success: function (result) {
            $("#chapitre-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
}

function ajouterActivite() {
    removeRequiredFields([$("select[name=comboEnseignements]")]);

    if ($("select[name=comboEnseignements]").val() === "") {
        alertWebix("Veuillez choisir d'abord une classe");
        addRequiredFields([$("select[name=comboEnseignements]")]);
        return;
    }

    removeRequiredFields([$("input[name=txtactivite]")]);

    if ($("input[name=txtactivite]").val() === "") {
        addRequiredFields([$("input[name=txtactivite]")]);
        alertWebix("Veuillez remplir le champ activit&eacute;");
        return;
    }

    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "ajouterActivite",
            idenseignement: $("select[name=comboEnseignements]").val(),
            description: $("input[name=txtactivite]").val()
        },
        success: function (result) {
            $("#activite-content").html(result[0]);
            $("input[name=txtactivite]").val("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function supprimerActivite(_idactivite) {
    if(!confirm("Etes vous certain de vouloir supprimer cette activité ? ")){
        return;
    }
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "supprimerActivite",
            idenseignement: $("select[name=comboEnseignements]").val(),
            idactivite: _idactivite
        },
        success: function (result) {
            $("#activite-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function supprimerLecon(_idlecon, _idchapitre) {
    if(!confirm("Etes vous certain de vouloir supprimer cette lecon ? ")){
        return;
    }
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "supprimerLecon",
            idlecon: _idlecon,
            idchapitre: _idchapitre
        },
        success: function (result) {
            $("#lecon-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
}

function ajouterChapitre(_idactivite) {
    removeRequiredFields([$("select[name=comboEnseignements]")]);

    if ($("select[name=comboEnseignements]").val() === "") {
        alertWebix("Veuillez choisir d'abord une classe");
        addRequiredFields([$("select[name=comboEnseignements]")]);
        return;
    }

    removeRequiredFields([$("input[name=txtchapitre]")]);

    if ($("input[name=txtchapitre]").val() === "") {
        addRequiredFields([$("input[name=txtchapitre]")]);
        alertWebix("Veuillez remplir le champ chapitre");
        return;
    }
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "ajouterChapitre",
            idactivite: _idactivite,
            description: $("input[name=txtchapitre]").val()
        },
        success: function (result) {
            $("#chapitre-content").html(result[0]);
            $("input[name=txtchapitre]").val("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
function supprimerChapitre(_idchapitre, _idactivite) {
    if(!confirm("Etes vous certain de vouloir supprimer ce chapitre ? ")){
        return;
    }
    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "supprimerChapitre",
            idchapitre: _idchapitre,
            idactivite: _idactivite
        },
        success: function (result) {
            $("#chapitre-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function chargerLecon(_idchapitre) {

    if ($("select[name=comboEnseignements]").val() === "") {
        addRequiredFields([$("select[name=comboEnseignements]")]);
        alertWebix("Veuillez choisir une mati&egrave;re");
        return;
    }
    $.ajax({
        url: "ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerLecon",
            idchapitre: _idchapitre
        },
        success: function (result) {
            $("#lecon-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite");
        }
    });
}
function ajouterLecon(_idchapitre) {
    removeRequiredFields([$("select[name=comboEnseignements]")]);

    if ($("select[name=comboEnseignements]").val() === "") {
        alertWebix("Veuillez choisir d'abord une classe");
        addRequiredFields([$("select[name=comboEnseignements]")]);
        return;
    }

    removeRequiredFields([$("input[name=txtlecon]")]);

    if ($("input[name=txtlecon]").val() === "") {
        addRequiredFields([$("input[name=txtlecon]")]);
        alertWebix("Veuillez remplir le champ lecon");
        return;
    }

    $.ajax({
        url: "./ajaxsaisie",
        type: "POST",
        dataType: "json",
        data: {
            action: "ajouterLecon",
            idchapitre: _idchapitre,
            description: $("input[name=txtlecon]").val()
        },
        success: function (result) {
            $("#lecon-content").html(result[0]);
            $("input[name=txtlecon]").val("");
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}