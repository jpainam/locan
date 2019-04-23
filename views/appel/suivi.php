<style>
#page-content span.select2{
    width: inherit !important;
}
</style>
<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px;">
        <span class="select" style="width: 250px; clear: both;margin-top: 0"><label>P&eacute;riodes :</label>
            <select name="comboPeriodes"><option></option>
                <option value="1">Mensuelle</option>
                <option value="2">S&eacute;quentielle</option>
                <option value="3">Trimestrielle</option>
                <option value="4">Annuelle</option>
            </select></span>
        <span class="select" style="width: 250px; margin-top: 0"><label>Distribution : </label>
            <select name="comboDistributions"></select>
        </span>
         <span class="select" style="width: 250px;margin-top: 0"><label> Classes :</label>
             <?php echo $comboClasses; ?>
          </span>
        <span class="select2" style="width: 250px !important; margin-top: 0"><label>El&egrave;ves : </label>
            <select name="comboEleves">
           
            </select>
        </span>
    </div>
</div>
<div class="page">
    <div id="suivi-content" style="height: 95%">
        <table class="dataTable" id="tableSuivi">
            <thead><tr><th>Jour/Date</th>
                    <?php
                    for ($i = 1; $i <= MAX_HORAIRE + 1; $i++) {
                        if ($i === 1) {
                            echo "<th>1<sup>&egrave;re</sup>H</th>";
                        } else {
                            echo "<th>" . $i . "<sup>&egrave;me</sup>H</th>";
                        }
                    }
                    ?><th>Total</th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
    <p style="margin:5px 10px 0 10px; padding: 0">
        <?php echo $legendes; ?>
    </p>
</div>
<div class="navigation">
    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0003">Imprimer ce suivi d'absences</option>
        </select>
    </div>
</div>
<div class="status"></div>