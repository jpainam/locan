$(document).ready(function(){
   $("select[name=comboClasses]").change(chargerFrais);
   
   $("select[name=comboFrais]").change(chargerEleves);
});

var chargerFrais = function(){
    
    if($("select[name=comboClasses]").val() === ""){
        return;
    }
    
    $.ajax({
       url: "./ajaxpayement",
       type: "POST",
       dataType: "json",
       data:{
           action: "chargerFrais",
           idclasse: $("select[name=comboClasses]").val()
       },
       success:function(result){
           $("select[name=comboFrais]").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
};
var chargerEleves = function (){
    if($("select[name=comboFrais]").val() === ""){
        return;
    }
    
    $.ajax({
       url: "./ajaxpayement",
       type: "POST",
       dataType: "json",
       data:{
           action: "chargerEleves",
           idclasse: $("select[name=comboClasses]").val(),
           idfrais: $("select[name=comboFrais]").val()
       },
       success:function(result){
           $("#scolarite-content").html(result[0]);
           $("#montantFrais").html(result[1]);
           $("#echeanceFrais").html(result[2]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
};

function payer(_ideleve){
    removeRequiredFields([$("select[name=comboFrais]"),$("select[name=comboClasses]")]);
    if($("select[name=comboFrais]").val() === "" || $("select[name=comboClasses]").val() === ""){
        addRequiredFields([$("select[name=comboFrais]"),$("select[name=comboClasses]")]);
        alertWebix("Veuillez choisir la classes et le frais scolaire");
        return;
    }
    $.ajax({
       url: "./ajaxpayement",
       type: "POST",
       dataType: "json",
       data:{
           ideleve: _ideleve,
           idfrais: $("select[name=comboFrais]").val(),
           action: "payer"
       },
       success: function(result){
           $("#scolarite-content").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
}

function depayer(_idscolarite){
    removeRequiredFields([$("select[name=comboFrais]"),$("select[name=comboClasses]")]);
    if($("select[name=comboFrais]").val() === "" || $("select[name=comboClasses]").val() === ""){
        addRequiredFields([$("select[name=comboFrais]"), $("select[name=comboClasses]")]);
        alertWebix("Veuillez choisir la classes et le frais scolaire");
        return;
    }
    $.ajax({
       url: "./ajaxpayement",
       type: "POST",
       dataType: "json",
       data:{
           idscolarite: _idscolarite,
           action: "depayer",
           idfrais: $("select[name=comboFrais]").val()
       },
       success: function(result){
           $("#scolarite-content").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
}