<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisiematiere.png"; ?>" /></div>
</div>
<div class="page">
    <?php
    echo $matieres;
    ?>
</div>
<div class="navigation">
    <div class="editions" style="float: left">
            <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
            <select onchange="imprimer();" name = "code_impression">
                <option></option>
                <option value="0001">Imprimer cette liste de mati&egrave;res</option>
            </select>
        </div>
    <?php
    if (isAuth(209)) {
        echo btn_add("document.location='" . Router::url("matiere", "saisie") . "'");
    }
    ?>
</div>
<div class="status"></div>