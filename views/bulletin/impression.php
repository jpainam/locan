<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_impression.png"; ?>" /></div>
</div>
<div class="titre">Impression des bulletins</div>
<div class="page" style="margin: auto;">
    <form action="<?php echo Router::url("bulletin", "impression"); ?>" method="post" name="frmbulletin" target="_blank">
        <fieldset style="float: none !important; width: 75%; margin: auto;margin-bottom: 40px;">
            <input type="hidden" name="code" value="0001" />
            <legend>Classe et P&eacute;riode</legend>
            <span class="select" style="width: 250px"><label>Classes : </label>
                <?php echo $comboClasses; ?>
            </span>
            <span class="select" style="width: 250px; margin-left: 90px"><label>P&eacute;riodes : </label>
                <?php echo $comboPeriodes; ?>
            </span>
        </fieldset>
        <fieldset style="float: none !important; width: 75%; margin: auto;"><legend>Options d'impressions</legend>
            <span class="select" style="width: 250px"><label>El&egrave;ves : </label>
                <select name="comboEleves" id="comboEleves">
                    <option></option>
                </select>
            </span>
             <span class="select" style="width: 100px; margin-left: 90px"><label>Du</label>
                <select name="debutinterval"><option></option></select>
            </span>
             <span class="select" style="width: 100px; margin-left: 30px"><label>Au</label>
                <select name="fininterval"><option></option></select>
            </span>
        </fieldset>
    </form>
</div>
<div class="recapitulatif"></div>
<div class="navigation">
    <?php echo btn_print("impression();"); ?>
</div>
<div class="status"></div>