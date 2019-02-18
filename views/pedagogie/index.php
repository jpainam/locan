<div id="entete">
    <div class="logo"></div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 250px"><label>Classes : </label>
            <?php echo $comboClasses; ?></span>
        <span class="select" style="width: 250px"><label>Enseignements : </label>
            <select name="comboEnseignements">
                <option></option>
            </select></span>
    </div>
</div>
<div class="titre">

</div>
<div class="page">

</div>
<div class="recapitulatif">

</div>
<div class="navigation">
    <div class="editions" style="float: left">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Programmation des activit&eacute;s p&eacute;dagogiques</option>
        </select>
    </div>
</div>
<div class="status">

</div>