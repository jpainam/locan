<div id="entete">
    <div style="margin-left: 80px">
        <span class="select" style="width: 350px"><label>Classes : </label><?php echo $comboClasses; ?></span>
        <span class="select" style="width: 200px"><label>P&eacute;riode : </label><?php echo $comboPeriodes; ?></span>
    </div>
</div>
<div class="page">
    <div class="tabs" style="width: 100%">
        <ul>
            <li id="tab1" class="courant">
                <a onclick="onglets(1, 1, 2);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/pedagogique.png"; ?>" />
                    Notes saisies
                </a>
            </li>
            <li id="tab2" class="noncourant">
                <a onclick="onglets(1, 2, 2);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/repertoire.png"; ?>" />
                    Notes non saisies
                </a>
            </li>
        </ul>
    </div>
    <div id="onglet1" class="onglet" style="display: block;height: 90%">
        <div id="notes-content">
            <?php echo $tableNotes; ?>
        </div>
    </div>
    <div id="onglet2" class="onglet" style="display: block;height: 90%">
         <div id="notes-non-saisies-content">
            <?php echo $tableNotesNonSaisies; ?>
        </div>
    </div>

</div>
<div class="navigation">
    <?php
    if (isAuth(401)) {
        echo btn_add("document.location='" . Router::url("note", "saisie") . "'");
    } else {
        echo btn_add_disabled();
    }
    ?>
</div>
<div class="status"></div>
