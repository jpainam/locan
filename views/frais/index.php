<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT . "public/img/wide_frais.png"; ?>" />
    </div>
</div>
<div class="titre">Gestion de la scolarit&eacute;</div>
<div class="page">
    <?php echo $frais; ?>
</div>
<div class="navigation">
    <div class="editions" style="float: left">
        <input type="radio" value="excel" name="type_impression" />
            <img src="<?php echo img_excel(); ?>" />&nbsp;&nbsp;
            <input type="radio" value="pdf" name="type_impression" checked="checked" />
            <img src="<?php echo img_pdf(); ?>" />&nbsp;&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Liste des frais pour toutes les classes</option>
        </select>
    </div>
    <?php echo btn_add("document.location='" . Router::url("frais", "saisie") . "'"); ?>
</div>
<div class="status"></div>
