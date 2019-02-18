<div id="entete">

</div>
<form name="frmNewEts" action="<?php echo Router::url("etablissement", "saisie"); ?>" method="post" >
    <div class="page">
        <table class="dataTable" id="tableEtablissement">
            <thead><tr><th>N°</th><th>Libell&eacute;</th><th></th></tr></thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($etablissements as $ets) {
                    echo "<tr><td>" . $i . "</td><td>" . $ets['ETABLISSEMENT'] . ""
                    . "<input type='hidden' value='" . $ets['ETABLISSEMENT'] . "' name='desc" . $ets['IDETABLISSEMENT'] . "' />"
                    . "</td><td style='text-align:center'>";
                    if (isAuth(529)) {
                        echo "<img style='cursor:pointer' src='" . img_edit() . "' "
                        . "onclick=\"openDialogEdit(" . $ets['IDETABLISSEMENT'] . ")\" />&nbsp;&nbsp;";
                    } else {
                        echo "<img style='cursor:pointer' src='" . img_edit_disabled() . "' />&nbsp;&nbsp;";
                    }

                    if (!isAuth(530) || $ets['IDETABLISSEMENT'] == ETS_ORIGINE) {
                        echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
                    } else {
                        echo "<img style='cursor:pointer' src='" . img_delete() . "' "
                        . "onclick=\"document.location='" . Router::url("etablissement", "delete", $ets['IDETABLISSEMENT']) . "'\" />";
                    }

                    echo "</td></tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="addnewets" value="true" />  
    <div class="navigation">
        <?php
        if (isAuth(501)) {
            echo btn_add("ajouterEtablissement();");
        } else {
            echo btn_add_disabled();
        }
        ?>
    </div>
</form>
<div class="status"></div>
<div id="editets-dialog-form" class="dialog" title="Modification d'un etablissement de provenance" >
    <span><label>Libell&eacute; de l'&eacute;tablissement</label>
        <input type="text" name="libelle" style="width: 100%" />
    </span>
</div>
