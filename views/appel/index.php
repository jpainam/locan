<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 300px; margin-top: 0"><label>Classes : </label>
            <?php echo $comboClasses; ?>
        </span>
        <span class="select" style="width: 140px; clear: both;margin-top: 0"><label>P&eacute;riodes :</label>
            <select name="comboPeriodes"><option></option>
                <option value="1">Mensuelle</option>
                <option value="2">S&eacute;quentielle</option>
                <option value="3">Trimestrielle</option>
                <option value="4">Annuelle</option>
            </select></span>
        <span class="select" style="width: 145px; margin-top: 0"><label>Distribution : </label>
            <select name="comboDistributions"></select></span>
    </div>
</div>
<div class="page">
    <div id="absence-content">
        <table class="dataTable" id="tableAbsences">
            <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th><th><img src="<?php echo img_phone(); ?>" /></th>
                    <th>Abs. Non Just.</th><th>Abs. Just.</th><th>Retard</th>
                    <th>Exclu</th><th>Total</th><th></th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
    <p style="margin:5px 10px 0 10px; padding: 0">
        <?php
        echo $legendes;
        ?>
    </p>
</div>
<div class="navigation">
    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0005">R&eacute;sum&eacute; d'absence par classe</option>
        </select>
    </div>
</div>
<div class="status"></div>