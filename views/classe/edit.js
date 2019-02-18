var enseignement;
$(document).ready(function () {
    $('#tab_mat').DataTable({
        "paging": false,
        "bInfo": false,
        "scrollY": 300,
        "columns": [
            {"width": "5%"},
            null,
            null,
            {"width": "7%"},
            {"width": "5%"},
            {"width": "7%"}
        ]
    });
    $('#tab_elv').DataTable({
        "paging": false,
        "bInfo": false,
        "scrollY": 300,
        "columns": [
            {"width": "20%"},
            null,
            {"width": "5%"}
        ]
    });
    $('#tab_pp, #tab_ra, #tab_cpe').DataTable({
        "paging": false,
        "scrollCollapse": true,
        "bInfo": false,
        "searching": false,
        "columns": [
            {"width": "20%"},
            null,
            {"width": "5%"}
        ]
    });

    var pop1 = popup("#dialog-1");
    var pop2 = popup("#dialog-2");
    var pop3 = popup("#dialog-3");
    var pop4 = popup("#dialog-4");
    var pop5 = popup("#dialog-5");
    pop5.dialog("option", "height", 300);

    $("#ajout_eleve").button().on("click", function () {
        openPopup(pop1);
    });

    $("#ajout_pp").button().on("click", function () {
        openPopup(pop2);
    });
    $("#ajout_cpe").button().on("click", function () {
        openPopup(pop3);
    });
    $("#ajout_ra").button().on("click", function () {
        openPopup(pop4);
    });

    $("#ajout_mat").button().on("click", function () {
        openPopup(pop5);
    });

    $("#spinner").spinner({
        max: 6,
        min: 1
    });
    $("#spinner1").spinner({
        max: 6,
        min: 1
    });
    $("#dialog-6").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            Modifier: function () {
                ajoutForm("#dialog-6");
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });

    disableAdd();
});
/**
 * 
 * Function permettant de desactiver les bouton add
 * s'il existe deja des principaux( pp, cpe, admin)
 */
function disableAdd() {
    if ($("#tab_pp td").length > 2) {
        $("#ajout_pp").unbind("click");
    }
    if ($("#tab_ra td").length > 2) {
        $("#ajout_ra").unbind("click");
    }
    if ($("#tab_cpe td").length > 2) {
        $("#ajout_cpe").unbind("click");
    }
}

var openPopup = function (_pop) {
    removeRequiredFields([$("select[name=niveau]"), $("input[name=libelle]")]);
    if ($("select[name=niveau]").val() === "" || $("input[name=libelle]").val() === "") {
        alertWebix("Les informations de la classe doivent d'abord être renseignées");
        addRequiredFields([$("select[name=niveau]"), $("input[name=libelle]")]);
        return;
    }
    _pop.dialog("open");
};

function AddMatiere(mat, ens, grp, cof, _ord) {
    this.matiere = mat;
    this.enseignant = ens;
    this.groupe = grp;
    this.coeff = cof;
    this.ordre = _ord;
}

var ajoutForm = function (id) {
    var elems = id.split('-'), elem = parseInt(elems[1]), tmp = [];
    var identifiant = $("input[name=identifiant]");
    identifiant.val($(id + " span select").val());
    var frmclasse = $("form[name=frmclasse]");
    var _url, content, img_pp;
    switch (elem) {
        case 1:
            _url = "../ajax/eleve";
            content = $("#eleve_content");
            img_pp = $("#dialog-1");
            break;
        case 2:
            _url = "../ajax/profprincipale";
            content = $("#prof_content");
            img_pp = $("#ajout_pp");
            break;
        case 3:
            _url = "../ajax/cpeprincipale";
            content = $("#cpe_content");
            img_pp = $("#ajout_cpe");
            break;
        case 4:
            _url = "../ajax/adminprincipale";
            content = $("#admin_content");
            img_pp = $("#ajout_ra");
            break;
        case 5:
            _url = "../ajax/ajoutmatiere";
            content = $("#matiere_content");
            img_pp = $("#listematiere");
            var matiere = $("input[name=matiere]");
            tmp = $(id + " span select");
            var mat = new AddMatiere(tmp[0].value, tmp[1].value, tmp[2].value, parseInt($("#spinner").val()), $("select[name=ordre]").val());
            matiere.val(JSON.stringify(mat));
            break;
        case 6:
            _url = "../ajax/editenseignement";
            content = $("#matiere_content");
            var matiere = $("input[name=matiere]");
            tmp = $(id + " span select");
            console.log(tmp);
            var mat = new AddMatiere(tmp[0].value, tmp[1].value, tmp[2].value, parseInt($("#spinner1").val()), $("select[name=ordre1]").val());
            matiere.val(JSON.stringify(mat));
            identifiant.val(enseignement);
            break;
    }
    $.ajax({
        url: _url,
        type: "POST",
        data: frmclasse.serialize(),
        dataType: "json",
        success: function (result) {
            $("input[name=idclasse]").val(result[0]);
            content.html(result[1]);
            if (elem > 1 && elem < 5) {
                img_pp.attr('src', result[2]);
                img_pp.unbind("click");
            } else if (elem < 6)
                img_pp.html(result[2]);
            if (result[3]) {
                if (result[3] !== 0 && result[4] === "debitaire") {
                    alertWebix('Eleve non inscrit<br/>Le solde de cet eleve est debiteur de ' + result[3] + '\n\
dans l\'annee precedente');
                }else if(result[3] !== 0 && result[4] === "exclus"){
                    alertWebix("Impossible d'inscrire cet eleve <br/>Eleve exclus en date du " + result[3]);
                }
            }
        },
        error: function (xhr, status, error) {
            alert("Veuillez actualiser la page " + xhr + " " + error);
        }
    });


};


function popup(_id) {
    var dial = $(_id).dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                ajoutForm(_id);
                dial.dialog("close");
            },
            Annuler: function () {
                dial.dialog("close");
            }
        }
    });
    return dial;
}
function searchElem(tab, val) {
    for (var j = 0, i = 0; i < tab.length; i++) {
        if (tab[i].innerHTML === val) {
            j = i;
        }
        tab[i].removeAttribute("selected");
    }
    return j;
}
function setOptions(mat, ens, grp, cof) {
    //$("#matiere").append("<option selected = 'selected'>" + mat + "</option>");
    $("#spinner1").val(cof);
    var options = document.getElementById("groupe2").childNodes,
            options2 = document.getElementById("listeenseignant2").childNodes;
    var j = searchElem(options, grp), i = searchElem(options2, ens);
    options[j].setAttribute('selected', 'selected');
    options2[i].setAttribute('selected', 'selected');
}


function editEnseignement(ens, elem) {
    var td = $(elem).parent().parent().children("td").first().siblings().first();
    var input = td.children("input").first();
    //console.log(input.val());
    $("select[name=matiereedit]").val(input.val());
    // console.log(td.prev().html());
    $("select[name=ordre1]").val(td.prev().html());
    //preselectionner le groupe
    //console.log(td.next().next().children("input").val());
    $("select[name=groupe2]").val(td.next().next().children("input").val());
    var frere = elem.parentNode.previousSibling;

    setOptions(frere.previousSibling.previousSibling.previousSibling.innerHTML.split('-')[1],
            frere.previousSibling.previousSibling.innerHTML,
            frere.previousSibling.innerHTML,
            frere.innerHTML
            );
    $("#dialog-6").dialog("open");
    enseignement = ens;
}

function desinscrire(idinscription) {
    $.ajax({
        url: "../../inscription/delete/" + idinscription,
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#eleve_content").html(result[0]);
            $("#dialog-1").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Veuillez rafraichir la page " + xhr + " " + error);
        }
    });
}
/**
 * Effectue la suppresion d'un principal precedement choisi
 *  1 = prof principal
 *  2 = cpe principal
 *  3 = administrateur principal
 *  @param {type} action
 */
function deletePrincipale(action) {
    var container, btajouter, _url, pop;
    switch (action) {
        case 1:
            container = $("#prof_content");
            btajouter = $("#ajout_pp");
            pop = popup("#dialog-2");
            break;
        case 2:
            container = $("#cpe_content");
            btajouter = $("#ajout_cpe");
            pop = popup("#dialog-3");
            break;
        case 3:
            container = $("#admin_content");
            btajouter = $("#ajout_ra");
            pop = popup("#dialog-4");
            break;
    }
    $.ajax({
        url: "../deletePrincipale",
        type: "POST",
        data: {
            "action": action,
            "idclasse": $("input[name=idclasse]").val()
        },
        dataType: "json",
        success: function (result) {
            container.html(result[1]);
            btajouter.attr('src', result[2]);
            btajouter.button().on("click", function () {
                openPopup(pop);
            });
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function deleteEnseignement(id) {
    $.ajax({
        url: "../deleteEnseignement",
        type: "POST",
        data: {
            "idenseignement": id,
            "idclasse": $("input[name=idclasse]").val()
        },
        dataType: "json",
        success: function (result) {
            $("#listematiere").html(result[0]);
            $("#matiere_content").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite ,rafraichir la page " + xhr + " " + error);
        }
    });
}