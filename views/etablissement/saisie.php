<div id="entete">

</div>
<div class="titre">
    Saisie des param&egrave;tres de l'&eacute;tablissement
</div>

<form action="<?php echo Router::url("etablissement", "saisie"); ?>" name="frmsaisieets" method="post" enctype="multipart/form-data" >
    <div class="page">
    <fieldset style="float: none !important; width: 30%; height: 20%; margin: auto;">
        <legend>Nouvel &eacute;tablissement</legend>
        <span class="text" style="width: 250px">
            <label>Nom du nouvel &eacute;tablissement</label>
            <input name="nouvelets" type="text" required="" />
        </span>
    </fieldset>
    </div>
    <div class="recapitulatif"></div>
    <div class="navigation">
        <?php echo btn_add("ajouterEts();") ?>
    </div>
</form>
<div class="status">

</div>