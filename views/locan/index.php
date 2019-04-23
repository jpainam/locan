<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT . "public/img/wide_etablissement.png"; ?>" />
    </div>
</div>
<div class="titre">Paramètres de l'établissement</div>
<form action="<?php echo Router::url("locan", "index"); ?>" method="post" name="frmlocan">
    <div class="page">
        <img src="" alt="Photo eleve" class="photo-eleve">
        <input type="hidden" name="idcompte" value="" />
        <input type="hidden" name="idjournal" value="" />
        <span class="text" style="width: 200px"><label>Ref. Transaction : </label>
            <input type="text" name="reftransaction" /></span>
        <span class="select" style="width: 190px;"><label>Type de transaction : </label>
            <select name="typetransaction" <?php echo!isAuth(537) ? 'disabled="disabled"' : ''; ?>>
                <option value="C" selected="selected">Cr&eacute;dit</option>
                <option value="R">R&eacute;mise</option>
                <?php
                if (isAuth(538)) {
                    echo '<option value="M">Moratoire</option>';
                }
                ?>
                <option value="D">D&eacute;bit</option>
            </select>
        </span>
        <span class="text" style="width: 400px;"><label>Description : </label>
            <input type="text" name="description" />
        </span>
        <span class="text" style="width: 400px;"><label>Montant : </label>
            <input type="text" name="montant" style="text-align: right;" />
        </span>
    </div>
</form>
<div class="navigation">
<?php echo btn_add("document.location='" . Router::url("locan", "index") . "'"); ?>
</div>
<div class="status"></div>
