<div id="entete">
    <div class="logo">

    </div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 300px;"><label>P&eacute;riodes :</label>
            <?php
            echo $comboPeriodes;
            ?>
    </div>
</div>
<div class="titre">

</div>
<div class="page">

</div>
<div class="recapitulatif">

</div>
<div class="navigation">
    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0005">Bilan global des resultats par classe et pour l'&eacute;tablissement</option>
        </select>
    </div>
</div>
<div class="status"></div>