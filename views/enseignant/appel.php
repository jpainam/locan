<style>
    .dataTable .centrer{
        text-align: center;
    }
</style>
<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 150px">
        <span class="text" style="width: 230px; margin-top: 0"><label>Du</label>
            <input type="text" name="datedebut" id="datedebut" /> 
        </span>
        <span class="text" style="width: 230px; margin-top: 0"><label>Au</label>
            <input type="text" name="datefin" id="datefin" /> 
        </span>
        <span style="width: 150px; display: inline-block;margin-top: 12px">
            <img src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" id="img-ajout" style="cursor:pointer" />
        </span>
    </div>
</div>
<form name="appelEnseignant" action="<?php echo Router::url("enseignant", "appel"); ?>" method="post">
    <div class="page">
        <div id="table-absences">
            <?php echo $appel; ?>
        </div>
        <!-- p style="margin:5px 10px 0 10px; padding: 0">
            <?php
            ///echo $legendes;
            ?>
        </p -->
    </div>
    <div class="navigation">
        <div class="editions">
            <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
            <select onchange="imprimer();" name = "code_impression">
                <option></option>
                <option value="0005">Fiche de suivi disciplinaire vierge</option>
                <option value="0006">Fiche de suivi disciplinaire</option>
            </select>
        </div>
    </div>
</form>
<div class="status"></div>
<div id="appel-dialog-form" class="dialog" title="Ajouter une absence ou un retard" >
    <span><label>Classes : </label>
        <?php echo $comboClasses; ?>
    </span>
    <span><label>Enseignants : </label>
        <select name="comboEnseignants" style="width: 100%"><option value=""></option></select>
    </span>
    <span><label>Mati&egrave;res : </label>
        <select name="comboMatieres" style="width: 100%"><option value=""></option></select>
    </span>

    <span style="display: inline-block; width: 140px">
        <label>Absence : </label><select name="absence" style="width: 100%">
            <option value=""></option>
            <?php
            for ($i = 1; $i < 15; $i++) {
                echo "<option value='" . $i . "'>" . $i . " H </option>";
            }
            ?>
        </select>
    </span>
    <span style="display: inline-block; width: 140px; margin-left: 10px">
        <label>Retard : </label><select name="retard" style="width: 100%">
            <option value=""></option>
            <?php
            for ($i = 15; $i < 180; $i += 15) {
                echo "<option value='" . date("H:i", $i * 60 - 3600) . "'>" . date("H:i", $i * 60 - 3600) . "</option>";
            }
            ?>
        </select>
    </span>
    <span class="text" style="width: 100%">
        <label>Autres</label>
        <input type="text" name="autres" style="width: 95%" />
    </span>
    <div id="zoneAlerte" style="color: #ff9999;font-size: 10px;text-align: center"></div>
</div>