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
<script>
    if (!$.fn.DataTable.isDataTable("#tableEtablissement")) {
        $("#tableEtablissement").DataTable({
            bInfo: false,
            paging: false,
            columns: [
                {"width": "5%"},
                null,
                {"width": "7%"}
            ]
        });
    }
</script>
