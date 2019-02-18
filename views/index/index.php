<style>
    .page fieldset{
        float: none !important;
        display: inline-table;
        background-image:-webkit-linear-gradient(right, #e2967e 30%, #fef3f0 100%);
        background-image: -o-linear-gradient(right, #e2967e 30%, #fef3f0 100%);
        background-image: -moz-linear-gradient(right, #e2967e 30%, #fef3f0 100%);
        background-image: linear-gradient(right, #e2967e 30%, #fef3f0 100%);
    }

    .page span{
        display: block;
        text-align: center; 
        margin-bottom: 5px;
    }
    .page h2{
        font-family: "Arial";
    }
</style>
<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_etablissement.png"; ?>" /></div>
    <span style="margin-left: 100px; margin-top: 10px; width: 550px; display: inline-block">
        <h2>SYST&Egrave;ME DE GESTION DES ACTIVIT&Eacute;S ACADEMIQUES</h2>
    </span>
    <span style="margin-left: 50px; clear: both;">
        <!-- Y mettre le calendrier -->
    </span>
</div>
<div class="titre"></div>
<div class="page" style="font-size: 14px; font-family: arial;">
    <fieldset style="width: 90%; margin-left: auto; margin-right: auto;">
        <legend style="text-align: center">Informations de l'&eacute;tablissement</legend>

        <span>Minist&egrave;re des enseignements secondaires</span>
        <span>*************</span>
        <span>D&eacute;l&eacute;gation R&eacute;gionale du Centre</span>
        <span>*************</span>
        <span>D&eacute;l&eacute;gation D&eacute;partementale de la MEFOU</span>
        <span>AFAMBA</span>
        <span>*************</span>
        <span style="font-weight: bold;"><?php echo $school['NOM']; ?></span>
        <span style="font-style: oblique;">Autorisation d'ouverture N° 79/12/MINESEC</span>
        <span>BP 5062 YAOUNDE</span>
        <span>T&eacute;l&eacute;phone: +237 97 86 84 99</span>
        <span><address>Email: institutwague@yahoo.fr</address></span>
        <span><em>www.institutwague.com</em></span>
        <span>R&eacute;publique du Cameroun</span>
        <span>Paix-Travail-Patrie</span>
        <span style="margin-bottom: 0">***********</span>

    </fieldset>
    <fieldset style="width: 90%; margin: auto;"><legend style="text-align: center">Nous contacter</legend>
        <span style="text-align: left; font-weight: bold; margin-bottom: 10px;">Vous pouvez contacter les concepteurs du syst&egrave;me : </span>
        <span style="text-align: left"> les Lundis, les Mardis, les Jeudis 
            de 9h00 &agrave; 12h00 et de 14h00 &agrave; 18h00 | les Dimanches de 16h00 &agrave; 20h00</span>
        <span style="font-weight: bold; text-align: left; margin-bottom: 10px">Par t&eacute;l&eacute;phone :
            +237 698 10 60 57 / +237 695 25 46 91</span>
        <span style="text-align: left">Par E-mail 
            <a href="mailto:jpainam@gmail.com">jpainam@gmail.com</a> ou <a href="mailto:baack.corp@gmail.com">baack.corp@gmail.com</a><br/>
            <br/>
            Nous envoyer un message : <a href="<?php echo Router::url("index", "envoyer"); ?>" >Envoyer</a>
        </span>

    </fieldset>
</div>
<div class="recapitulatif"></div>
<div class="navigation">
</div>
<div class="status" style="padding: 2px;"><?php echo $infos; ?> | @ BAACK CORPORATION</div>
<script>
$(document).ready(function(){
   <?php 
   if(isset($errors)){
       if($errors){
           echo "alertWebix('Une erreur est survenue lors de l\'envoi');";
       }else{
           echo "alertWebix('Message envoy&eacute; avec succ&egraves;');";
       }
   }
   ?>
});
</script>
