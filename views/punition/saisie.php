<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/punition.png"; ?>" /></div>
    <span class="select" style="width: 250px; margin-left: 100px"> <label>Puni par : </label>
        <?php echo $comboPersonnels; ?>
    </span>
</div>
<div class="titre">Saisie d'une punition</div>
<form action="<?php echo Router::url("punition", "saisie") ?>" method="post" name="frmpunition">
    <div class="page">
        <input type="hidden" name="punipar" value="" />
        <input type="hidden" name="datepunition" value="" />
        <fieldset style="float: none; margin: auto; width: 80%"><legend>El&egrave;ve puni</legend>
            <span class="select" style="width: 300px;margin-right: 200px;">
                <label>Classe: </label>
                <?php echo $comboClasses; ?> 
            </span>
            <span class="select" style="width: 300px">
                <label> El&egrave;ve:</label>
                <select name="comboEleves"><option></option></select>
            </span>
        </fieldset>
        <fieldset style="float: none; margin: auto; width: 80%;height: 60%;"><legend>Punition</legend>
            <span class="text" style="width: 150px">
                <label>Date</label><div id="datepunition" style="margin-top: 10px" ></div>
                <input type="hidden" name="datepunition" value="" />
            </span>
            <span class="select" style="width: 135px"><label>Dur&eacute;e (jrs):</label><select name ="duree"><option></option>
            <?php for($i = 1; $i < 100; $i++){
                echo "<option value = '$i'>$i jrs</option>";
            } ?></select></span>
            <span class="select" style="width: 300px">
                <label>Type:</label><?php echo $comboTypes; ?>
            </span>
            <span class="text" style="width: 88%">
                <label>Motif:</label><input type="text" name="motif" />
            </span>
            <span class="text" style="width: 88%">
                <label>Motif d&eacute;taill&eacute;</label>
                <textarea rows="12" cols="85" name="description"></textarea>
            </span>
        </fieldset>
    </div>
    <div class="recapitulatif"></div>
    <div class="navigation">
        <?php
        if(isAuth(315)){
            echo btn_ok("soumettrePunition();");
        }else{
            echo btn_ok_disabled();
        }
        if(isAuth(311)){
            echo "&nbsp;&nbsp;&nbsp;".btn_cancel("document.location='".Router::url("punition")."'");
        }else{
            echo "&nbsp;&nbsp;&nbsp;".btn_cancel_disabled();
        }
        ?>
    </div>
</form>
<div class="status"></div>