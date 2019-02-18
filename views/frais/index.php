<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT."public/img/wide_frais.png"; ?>" />
    </div>
</div>
<div class="titre">Gestion de la scolarit&eacute;</div>
<div class="page">
    <?php echo $frais; ?>
</div>
<div class="navigation">
    <?php echo btn_add("document.location='".Router::url("frais", "saisie")."'"); ?>
</div>
<div class="status"></div>
