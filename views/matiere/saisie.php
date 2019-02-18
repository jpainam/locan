<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisiematiere.png"; ?>" /></div>
</div>
<div class="titre">
    Saisie d'une mati&egrave;re
</div>
<form action ="<?php echo url('matiere', 'saisie'); ?>" method="post" name="saisiematiere">
    <div class="page">
        <fieldset style="margin: auto; width: 450px; float: none;"><legend>Saisie de mati&egrave;res</legend>
            <span class="text" style="width: 200px"><label>Nom abr&eacute;g&eacute;</label><input type ="text" name ="code" /></span>
            <span class="text" style="width: 200px"><label>Libell&eacute;</label><input type="text" name="libelle" /></span>
        </fieldset>
    </div>
    <div class="recapitulatif"><div class="errors">
            <?php
            if ($errors)
                echo $message;
            ?>
        </div>
    </div>
    <div class="navigation">
        <?php echo btn_ok("soumettreMatiere();"); ?>
        <?php echo btn_cancel("document.location=\"" . Router::url('matiere') . "\""); ?>
    </div>
</form>
<div class="status">

</div>