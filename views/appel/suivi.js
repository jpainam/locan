$(document).ready(function(){
   $("#tableSuivi").DataTable({
       bInfo: false,
       "paging": false
   });
   $('select[name=comboEleves]').select2();
   $('select[name=comboClasses]').change(function(){
        if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
            $("select[name=comboDistributions]")[0].selectedIndex = 0;
            addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
            alertWebix("Veuillez d'abord remplir les champs obligatoires");
            return;
        }

        if ($("select[name=comboDistributions]").val() === "") {
            return;
        }
    
       if($(this).val() === ""){
           return
       }
       $.ajax({
           url: "./ajaxsuivi",
           type: "POST",
           dataType: "json",
           data: {
               action: "chargerEleves",
               idclasse: $(this).val(),
               distribution: $("select[name=comboDistributions]").val(),
               periode: $("select[name=comboPeriodes]").val(),
           },
           success: function(result){
                $("select[name=comboEleves]").html(result[0]);
                $("#suivi-content").html(result[1]);
           },
           error: function(xhr){
               alert(xhr.responseText);
           }
       });
   });
   $("select[name=comboPeriodes]").change(chargerDistribution);
   $("select[name=comboEleves]").change(chargerAbsences);
});

chargerDistribution = function(){
    removeRequiredFields([$("select[name=comboEleves]")]);
    if($("select[name=comboEleves]").val() === ""){
        addRequiredFields([$("select[name=comboEleves]")]);
        $("select[name=comboPeriodes]")[0].selectedIndex = 0;
        alertWebix("Veuillez d'abord choisir un &eacute;l&egrave;");
        return;
    }
    
    if($("select[name=comboPeriodes]").val() === ""){
        return;
    }
    
    $.ajax({
       url: "./ajaxsuivi",
       type: "POST",
       dataType: "json",
       data:{
           "periode": $("select[name=comboPeriodes]").val(),
           "action": "chargerDistribution"
       },
       success: function(result){
           $("select[name=comboDistributions]").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
};
chargerAbsences = function(){
  if($("select[name=comboDistributions]").val() === ""){
      return;
  }  
    removeRequiredFields([$("select[name=comboEleves]"), $("select[name=comboPeriodes]")]);
    if($("select[name=comboEleves]").val() === "" || $("select[name=comboPeriodes]").val() === ""){        
        $("select[name=comboDistributions]")[0].selectedIndex = 0;
        addRequiredFields([$("select[name=comboEleves]"), $("select[name=comboPeriodes]")]);
        alertWebix("Veuilez choisir l'eleve et la periode");
        return;
    }
    
    $.ajax({
        url: "./ajaxsuivi",
        type: "POST",
        dataType: "json",
        data:{
            action: "chargerAbsences",
            periode: $("select[name=comboPeriodes]").val(),
            distribution: $("select[name=comboDistributions]").val(),
            ideleve: $("select[name=comboEleves]").val()
        },
        success: function(result){
            $("#suivi-content").html(result[0]);
        },
        error: function(xhr, status, error){
            alert(xhr.responseText);
        }
    });
};

function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboEleves]"), $("select[name=comboPeriodes]"), $("select[name=comboDistributions]")]);
    if ($("select[name=comboEleves]").val() === "" || $("select[name=comboPeriodes]").val() === "" || 
            $("select[name=comboDistributions]").val() === "") {
        addRequiredFields([$("select[name=comboEleves]"), $("select[name=comboPeriodes]"), $("select[name=comboDistributions]")]);
        alertWebix("Veuillez d'abord remplir les champs obligatoires");
        $("select[name=code_impression]")[0].selectedIndex = 0;
        return;
    }

    var frm = $("<form>", {
        action: "./imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "ideleve",
        type: "hidden",
        value: $("select[name=comboEleves]").val()
    })).append($("<input>", {
        name: "periode",
        type: "hidden",
        value: $("select[name=comboPeriodes]").val()
    })).append($("<input>", {
        name: "distribution",
        type: "hidden",
        value: $("select[name=comboDistributions]").val()
    })).appendTo("body");
    frm.submit();
}