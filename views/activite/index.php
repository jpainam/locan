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
    <fieldset style="width: 40%; height: 90%"><legend>Les activit&eacute;s</legend>
        <div id="activite-content">
        <table class="dataTable" id="tableActivite">
            <thead><tr><th>N°</th><th>Titre</th></tr></thead>
            <tbody></tbody>
        </table>
        </div>
    </fieldset>
    <fieldset style="float: right; width: 50%; height: 90%;">
        <legend>Les chapitres et le&ccedil;ons</legend>
        <div id="chapitre-content" style="max-height: 100%; overflow: auto;">
            
        </div>
    </fieldset>
</div>
<div class="recapitulatif">

</div>
<div class="navigation">
 <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Imprimer cette fiche des activit&eacute;s p&eacute;dagogiques</option>
        </select>
 </div>
</div>
<div class="status">

</div>