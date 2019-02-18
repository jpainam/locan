<div id="entete">
    <div class="logo">

    </div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 350px">
            <label>Mati&egrave;res : </label>
            <?php echo $comboMatieres; ?>
        </span>
    </div>
</div>
<div class="page">
    <?php
    var_dump($leconsprevues);
    var_dump($leconsfaites);
    var_dump($heuresprevues);
    ?>
</div>
<div class="recapitulatif">

</div>
<div class="navigation">
    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Taux de couverture des programmes et heures</option>
        </select>
    </div>
</div>
<div class="status">
</div>