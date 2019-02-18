<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisiematiere.png"; ?>" /></div>
</div>
<div class="titre">
    Modification de la mati&egrave;re : <?php echo $code . " - " . $libelle; ?>
</div>
<form action ="<?php echo Router::url('matiere', 'edit', $idmatiere); ?>" method="post">
    <div class="page">
        <fieldset style="margin: auto; width: 450px; float: none;"><legend>Saisie de mati&egrave;res</legend>
            <span class="text" style="width: 200px"><label>Nom abr&eacute;g&eacute;</label>
                <input value="<?php echo $code; ?>" type ="text" name ="code" /></span>
            <span class="text" style="width: 200px"><label>Libell&eacute;</label>
                <input value="<?php echo $libelle; ?>" type="text" name="libelle" /></span>
            <input type="hidden" name="idmatiere" value="<?php echo $idmatiere; ?>" />
        </fieldset>
    </div>
    <div class="recapitulatif"><div class="errors">
            <?php
            if ($errors) {
                echo "Une erreur s'est produite";
            }
            ?>
        </div>
    </div>
    <div class="navigation">
        <?php echo btn_ok("document.forms[0].submit()"); ?>
        <?php echo btn_cancel("document.location=\"" . Router::url('matiere') . "\""); ?>
    </div>
</form>
<div class="status">

</div>