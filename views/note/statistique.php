<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_statistique.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 355px; margin: 0"><label>Statistiques par mati&egrave;res : </label>
            <?php echo $comboMatieres; ?>
        </span>
        <span class="select" style="width: 170px;clear: both;margin-top: 0"><label>Statistiques par classes : </label>
            <?php echo $comboClasses; ?>
        </span>
        <span class="select" style="width: 170px; margin-top: 0"><label>P&eacute;riode : </label>
            <?php echo $comboPeriodes; ?>
        </span>
    </div>
</div>
<div class="titre"></div>
<div class="page">

</div>
<div class="navigation">
    <div class="editions" style="float: left">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0002">Imprimer les statistiques par mati&egrave;res</option>
            <option value="0002">Imprimer les statistiques par classes</option>
        </select>
    </div>
</div>
<div class="status"></div>