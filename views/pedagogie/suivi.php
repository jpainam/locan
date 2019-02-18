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

<form name="frmSuivi" action="<?php echo Router::url("pedagogie", "suivi"); ?>" method="post">
    <div class="page">
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant"><a onclick="onglets(1, 1, 2);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/suivi.png"; ?>" />
                    Saisie du suivi p&eacute;dagogique </a>
                </li>
                <li id="tab2" class="noncourant"><a onclick="onglets(1, 2, 2);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/activite.png"; ?>" />
                    Liste des chapitres effectu&eacute;s </a>
                </li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;height: 90%"></div>
        <div id="onglet2" class="onglet" style="display: none;height: 90%"></div>
    </div>

    <div class="navigation">
        <div class="editions" style="float: left">
            <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
            <select onchange="imprimer();" name = "code_impression">
                <option></option>
                <option value="0002">Imprimer cette fiche de suivi p&eacute;dagogique</option>
            </select>
        </div>
        <?php
        if (isAuth(527)) {
            echo btn_ok("validerSuivi()");
        }
        ?>
        
    </div>
    <input type="hidden" value="" name="idenseignement" />
    <input type="hidden" name="suivi" value="true" />
</form>
<div class="status">

</div>