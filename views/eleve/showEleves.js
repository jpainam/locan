function ouvrirFiche(_ideleve) {
    var frm = $("<form>", {
        action: "../eleve",
        method: "post"
    }).append($("<input>", {
        name: "ideleve",
        type: "hidden",
        value: _ideleve
    })).appendTo("body");

    frm.submit();
}

function supprimerEleve($ideleve) {
    alertWebix("Attention, cette action est irreversible");
    var $ok = confirm("Etes vous sur de vouloir supprimer cet eleve?");
    if ($ok) {
        document.location = "./delete/" + $ideleve;
    }
}