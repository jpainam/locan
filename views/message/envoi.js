function envoyerSMS() {
    var frm = $("form[name=frmenvoi]");
    removeRequiredFields([$("input[name=destinataire]"),$("textarea[name=message]")]);
    if ($("input[name=destinataire]").val() === "" || $("textarea[name=message]").val() === "") {
        
        addRequiredFields([$("input[name=destinataire]"),$("textarea[name=message]")]);
        alertWebix("Veuilez remplir tous les champs obligatoires");
        return;
    }
    frm.submit();
}

function envoyerCollectif() {
    var frm = $("form[name=frmenvoi]");
    removeRequiredFields([$("select[name=collectif]"),$("textarea[name=messagecollectif]")]);
    if ($("select[name=collectif]").val() === "" || $("textarea[name=messagecollectif]").val() === "") {
        
        addRequiredFields([$("input[name=collectif]"),$("textarea[name=messagecollectif]")]);
        alertWebix("Veuilez remplir tous les champs obligatoires");
        return;
    }
    frm.submit();
}
function envoyerParclasse() {
    var frm = $("form[name=frmenvoi]");
    removeRequiredFields([$("select[name=parclasse]"),$("textarea[name=messageparclasse]")]);
    if ($("select[name=parclasse]").val() === "" || $("textarea[name=messageparclasse]").val() === "") {
        
        addRequiredFields([$("select[name=parclasse]"),$("textarea[name=messageparclasse]")]);
        alertWebix("Veuilez remplir tous les champs obligatoires");
        return;
    }
    frm.submit();
}