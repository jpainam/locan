$(document).ready(function () {
});

function ajouterUser() {
    removeRequiredFields([$("select[name=personnel]"), $("select[name=profile]"), 
    $("input[name=login]"), $("input[name=pwd]")]);

    if ($("select[name=personnel]").val() === "" || $("select[name=profile]").val() === "" ||
            $("input[name=login]").val() === "" || $("input[name=pwd]").val() === "") {
        addRequiredFields([$("select[name=personnel]"), $("select[name=profile]"),
            $("input[name=login]"), $("input[name=pwd]")]);
        alertWebix("Remplir tous les champs obligatoires");
        return;
    }
    
    $("form[name=frmuser]").submit();
}

