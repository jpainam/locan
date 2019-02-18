function changerPwd(){
    
    var frm = $("form[name=frmPwd]");
    removeRequiredFields([$("select[name=comboUtilisateurs]"), $("input[name=pwd]")]);
    if($("select[name=comboUtilisateurs]").val() === "" || $("input[name=pwd]").val() === ""){
        addRequiredFields([$("select[name=comboUtilisateurs]"), $("input[name=pwd]")]);
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }
    
    frm.submit();
}