<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/punition.png"; ?>" /></div>
    <span class="select" style="width: 200px; margin-left: 100px"><label>Classe : </label>
        <?php echo $comboClasses; ?>
    </span>
    <span class="select" style="width: 150px"><label>Ann&eacute;e acad&eacute;mique :</label>
        <?php echo $comboAnneeAcademique; ?>
    </span>
</div>
<div class="titre"></div>
<div class="page"><div id="punition-content">
    <?php echo $punitionTable; ?>
    </div></div>
<div class="navigation">
    <?php
        if(isAuth(315)){
            echo btn_add("document.location='".Router::url("punition", "saisie")."'");
        }
    ?>
</div>
<div class="status"></div>