<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT . "public/img/wide_frais.png"; ?>" />
    </div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 300px"><label>Classes : </label><?php echo $comboClasses; ?></span>
    </div>
</div>
<div class="page">
    <p style="text-align: right;margin: 0"><img id="img-ajout" style="cursor: pointer" src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" />
        <input type="hidden" name="echeances" value="" /></p>

    <div id="frais-content">
        <table class="dataTable" id="fraisTable">
            <thead><tr><th>Description du frais scolaire</th><th>Montant</th><th>Ech&eacute;ances</th><th></th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div class="navigation">
    <?php
    if (isAuth(211)) {
        echo btn_ok("document.location='" . Router::url("frais") . "'");
    } else {
        echo btn_ok_disabled();
    }
    ?></div>
<div class="status"></div>
<div id="frais-dialog-form" class="dialog" title="Ajouter d'un frais scolaire" >
    <span><label>Libell&eacute; du frais scolaire</label>
        <input type="text" name="description" style="width: 100%" /></span>
    <span><label>Montant du frais</label>
        <input type="text" name="montant" style="width: 100%" /></span>
    <span><label>Date de l'&eacute;ch&eacute;ance</label>
        <div id="echeances" style="margin-top: 10px;z-index: 10">
        </div></span>
</div>
<div id="editfrais-dialog-form" class="dialog" title="modification d'un frais scolaire" >
    <span><label>Libell&eacute; du frais scolaire</label>
        <input type="text" name="editdescription" style="width: 100%" />
    </span>
    <span><label>Montant du frais</label>
        <input type="text" name="editmontant" style="width: 100%" />
    </span>
    <span><label>Date de l'&eacute;ch&eacute;ance</label>
        <div id="editecheances" style="margin-top: 5px;z-index: 10"></div>
    </span>
</div>
