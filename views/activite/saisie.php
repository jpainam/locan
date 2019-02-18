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
<div class="page" style="margin: auto;">
    <fieldset style="width: 45%; height: 45%;">
        <legend>Saisie des activit&eacute;s</legend>
        <div id="activite-content">

        </div>
        <div id="activite-dialog-form" class="dialog" title="Editer une activit&eacute;" >
            <span><label>Titre de l'activit&eacute;</label>
                <input type="text" name="txtdialogactivite" style="width: 100%" /></span>
        </div>
    </fieldset>
    <fieldset style="width: 45%; height: 45%;">
        <legend>Chapitres de l'activit&eacute;s</legend>
        <div id="chapitre-content">

        </div>
        <div id="chapitre-dialog-form" class="dialog" title="Editer ce chapitre" >
            <span><label>Titre du chapitre</label>
                <input type="text" name="txtdialogchapitre" style="width: 100%" /></span>
        </div>
    </fieldset>
    <fieldset style=" float: none !important; width: 50%; height: 45%; margin: auto;">
        <legend>Le&ccedil;ons du chapitre</legend>
        <div id="lecon-content">

        </div>

    </fieldset>
</div>
<div class="recapitulatif">

</div>
<div class="navigation">
    <?php
    echo btn_ok("document.location='" . Router::url("activite") . "'");
    ?>
</div>
<div class="status"></div>