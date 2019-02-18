<div id="entete" style="height: 80px;">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px; ">
         <span class="select" style="width: 300px; margin-top: 0"><label>Classe</label><?php echo $comboClasses; ?></span>
        <span class="text" style="width: 200px; margin-top: 0"><label>Date</label><div id="datejour" style="margin-top: 10px;"></div></span>
        <span class="select" style="width: 300px;margin-top: 0;"><label>Enseignements :</label>
            <select name ="comboEnseignements"><option></option></select>
        </span>
        <span class="text" style="width: 200px;margin-top: 15px; font-weight: bold" id="horaires">De 00h:00 &agrave; 00h:00</span>
    </div>
</div>
<form action="<?php echo url('appel', 'saisie'); ?>" method="post" name="frmappel">
    <div class="page" style="">
        <fieldset style="margin: auto; margin-top: 10px;height: 85%; width: 95%;float: none;background-color: #FFF;"><legend>El&egrave;ves</legend>
        <div id="listeeleve" style="max-height: 100%; overflow: auto;" >
           
        </div>
        </fieldset>
        <p style="margin:0 10px 0 10px;">
            <label style="font-weight: bold;text-decoration: underline">L&eacute;gendes : <br/></label>
            <b><span style="background-color: #99ff99;">&nbsp;&nbsp;&nbsp;&nbsp;</span>P : </b>Pr&eacute;sent &nbsp;&nbsp;&nbsp; 
            <b><span style=" background-color: #ff9999;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                A : </b> Absent &nbsp;&nbsp;&nbsp;
                <b><span style="border: 1px solid #000; background-color: #FFF;">&nbspR&nbsp;</span>R : 
                </b>en Retard &nbsp;&nbsp;&nbsp;<b>
                    <span style="border: 1px solid #000; background-color: #FFF;">&nbsp;E&nbsp;</span>E : </b>Exclu de cours
                    <b>&nbsp;&nbsp;&nbsp;<span style="background-color: #ffff66;">&nbsp;&nbsp;&nbsp;&nbsp;</span>A : </b> Absence justifi&eacute;e
        </p>
    </div>
    <div class="navigation" style="padding: 5px">
        En cochant cette case, vous certifiez l'exactitude des donn&eacute;es saisies 
        en votre nom : <input style="vertical-align: middle;" type="checkbox" name="certifier" />
            <?php echo btn_save_appel("soumettreAppel();"); ?>
    </div>
</form>
<div class="status"></div>
