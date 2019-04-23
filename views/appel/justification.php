<style>
#page-content span.select2{
    width: inherit !important;
}
</style>
<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_justification.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 250px; margin-top: 0"><label>Date</label>
            <div id="datejour" style="margin-top: 10px;"></div></span>
        <span class="select" style="width: 250px; margin-top: 0; clear: both;"><label>Classe</label>
            <?php echo $comboClasses; ?></span>
    </div>
</div>
<div class="page">
    <div class="tabs" style="width: 100%">
        <ul>
            <li id="tab1" class="courant">
                <a onclick="onglets(1, 1, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                    Justification individuelle</a></li>
            <li id="tab2" class="noncourant">
                <a onclick="onglets(1, 2, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/justification.png"; ?>" />
                    Justification par p&eacute;riode</a></li>
            <li id="tab3" class="noncourant">
                <a onclick="onglets(1, 3, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/gestionuser.png"; ?>" />
                    Justification par classe </a></li>
        </ul>
    </div>
    <div id="onglet1" class="onglet" style="display: block; height: 90%">
    </div>
    <div id="onglet2" class="onglet" style="display: none; height: 90%">
        <form style="height: 80%" action="<?php echo Router::url("appel", "justifierparperiode"); ?>" method="post" name="frmJustificationParPeriode">
            <fieldset style="float: none; margin: auto; width: 70%; height: 90%"><legend>Saisie par &eacute;l&egrave;ve</legend>
                <span class="select" style="width: 250px;margin-left: 20px;"><label>El&egrave;ves</label>
                    <select name="comboEleves"><option></option></select></span>
                <fieldset style="float: none; margin:20px auto; width: 90%;"><legend>Dates et Heures</legend>
                    <span class="text" style="width: 200px"><label>Du</label><div id="datedu" style="margin-top: 10px"></div></span>
                    <span class="text" style="width: 200px"><label>Au</label><div id="dateau" style="margin-top: 10px"></div></span>
                    <div style="clear: both">
                        <span class="text" style="width: 200px"><label>De</label>
                            <select style="width: 75px;padding: 2px" name="heurede" >
                                <?php for($i = 1; $i <= MAX_HORAIRE + 1; $i++){
                                    if($i === 1){
                                     echo "<option value = '1'>1<sup>&egrave;re</sup>H</option>";
                                    }else{
                                        echo "<option value ='".$i."'>".$i."<sup>&egrave;me</sup>H</option>";
                                    }
                                }
                                ?>
                            </select>
                        </span>
                        <span class="text" style="width: 200px"><label>A</label>
                            <select style="width: 75px;padding: 2px" name="heurea" >
                                <?php for($i = 1; $i <= MAX_HORAIRE + 1; $i++){
                                    if($i === 1){
                                     echo "<option value = '1'>1<sup>&egrave;re</sup>H</option>";
                                    }else{
                                        echo "<option value ='".$i."'>".$i."<sup>&egrave;me</sup>H</option>";
                                    }
                                }
                                ?>
                            </select></span>
                    </div>
                </fieldset>
                <fieldset style="float: none; margin:20px auto; width: 90%; height: 45%"><legend>Justification</legend>
                    <span class="text" style="width: 300px"><label>Motif de la justification</label>
                        <input type="text" name="motif2" /></span>
                    <span class="text" style="width: 300px"><label>Description d&eacute;taill&eacute;e</label>
                        <textarea name="description2" rows="3" cols="30" ></textarea></span>
                </fieldset>
                <p style="text-align: right"><?php echo btn_ok("justifierParPeriode()"); ?>&nbsp;&nbsp;&nbsp;
                    <?php echo btn_cancel("document.location='" . Router::url("appel", "liste")); ?></p>
            </fieldset>
        </form>
    </div>
    <div id="onglet3" class="onglet" style="display: none;height: 90%">
        <p style="color: #ff9999; margin: 0; padding: 0; text-align: center">Fonctionnalit&eacute; non impl&eacute;ment&eacute;e</p>
        <div id="justification-par-classe-content">
            <fieldset id='checbox-eleves' style="float: none; margin: auto; width: 80%">
                <legend>Choix des &eacute;l&egrave;ves</legend>
            </fieldset>
            <fieldset id="justifier-par-classe" style="float: none; margin: auto;height: 200px; width: 80%">
                <legend>Justification des &eacute;l&egrave;ves</legend>
                <span class="text" style="width: 95%"><label>Motif</label><input type="text" name="motifclasse" /></span>
                <span class="text" style="width: 95%"><label>Description:</label>
                    <textarea rows="3" cols="12"></textarea></span>
            </fieldset>
        </div>
        <p style="text-align: right;margin-right: 100px;">
            <?php echo btn_ok("") . "&nbsp;&nbsp;&nbsp;" . btn_cancel(""); ?>
        </p>
    </div>
    <p style="margin:5px 10px 0 10px; padding: 0">
        <?php echo $legendes; ?>
    </p>
</div>
<div class="navigation" >
</div>
<div class="status"></div>
