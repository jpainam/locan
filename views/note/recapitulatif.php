<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 250px"><label>Classes : </label>
            <?php echo $comboClasses; ?>
        </span>
        <span class="select" style="width: 200px"><label>P&eacute;riodes : </label>
            <?php echo $comboPeriodes ?>
        </span>
    </div>
</div>
<div class="page">
    <div id="recapitulatif-content">
        <table class="dataTable" id="tableRecapitulatif">
            <thead><tr><th>Noms & Pr&eacute;noms</th><th>Mati&egrave;res</th><th>Notes</th></tr></thead>
            <tbody>
            </tbody>
        </table>

    </div>
</div>
<div class="navigation">
    <div class="editions" style="float: left">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0006">Proc&egrave;s verbal r&eacute;capitulatif des r&eacute;sultats/Note classe</option>
            <option value="0007">Synth&egrave;se r&eacute;capitulative des r&eacute;sultats/Notes par classe</option>
            <option value="0008">Courbe r&eacute;capitulative des r&eacute;sultats/Notes par classe</option>
            <option value="0009">Tableau d'honneur par classe</option>
        </select>
    </div>
</div>
<div class="status">

</div>