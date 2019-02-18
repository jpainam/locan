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
<form action="<?php echo url("appel", "periodique"); ?>" method="POST" name="periodiqueform" >
    <div class="page">
        <div id="periodique-content">
            <table class="dataTable" id="tablePeriodique">
                <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th><th>T.Abs</th><th>Abs.J</th><th>Cons</th><th>D&eacute;cis°</th></tr></thead>
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
                <option value="0006">Fiche de suivi p&eacute;riodique des &eacute;l&egrave;ves pr&eacute;-rempli Ou Non</option>
            </select>
        </div>
        <?php
        if (isAuth(330)) {
            echo btn_ok("validerSuivi()");
        } else {
            echo btn_ok_disabled();
        }
        ?>
    </div>
</form>
<div class="status">

</div>