<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_user.png"; ?>" /></div>
    <div style="padding-left: 100px">
        <span class="select" style="width: 250px">
            <label>Classes :</label>
            <?php echo $comboClasses; ?>
        </span>
    </div>
</div>
<div class="titre">
    El&egrave;ves &agrave; exclures
</div>
<div class="page">
    <div id="eleve-exclus">
         <?php 
            echo $eleve_exclus;
         ?>
    </div>
    <div id="dialog-5" class="dialog" title="Ajouter un eleve exclus">
        <span>
            <label>Noms et Prénoms</label>
            <select name="eleve-classe" id="eleve-classe" style="width: 250px">
            </select>
       
            <label>Date d'exclusion</label>
            <input style="width: 250px" type="text" id="dateexclusion" name="dateexclusion" value="" />
        </span>
    </div>

</div>
<div class="navigation">
    <img  src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?> " 
          onclick="ajouterExclus();" />
</div>
<div class="status"></div>