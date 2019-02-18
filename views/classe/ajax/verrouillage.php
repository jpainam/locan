<table class="dataTable" id="classeTable">
    <thead><tr><th>N°</th><th>Libell&eacute;</th>
            <th><img src="<?php echo SITE_ROOT . "public/img/lock.png"; ?>" /></th>
            <th></th></tr></thead><tbody>
        <?php
        $i = 1;
        foreach ($classes as $cl) {
            echo "<tr><td>" . $i . "</td><td>" . $cl['NIVEAUHTML'] . ' ' . $cl['LIBELLE'] . "</td>";
            if (!is_null($cl['IDVERROUILLAGECLASSE'])) {
                echo "<td align='center'><input type='checkbox' checked disabled /></td>";
            } else {
                echo "<td align='center'><input type='checkbox' disabled /></td>";
            }
            if (!is_null($cl['IDVERROUILLAGECLASSE'])) {
                echo "<td align='center'><img style='cursor:pointer' src='" . img_valider_disabled() . "' />&nbsp;&nbsp;"
                . "<img src='" . img_delete() . "' style='cursor:pointer' onclick=\"deverrouiller(" . $cl['IDCLASSE'] . ", " .
                $cl['SEQUENCE'] . ")\" /></td>";
            } else {
                echo "<td align='center'><img src='" . img_valider() . "' style='cursor:pointer' "
                . "onclick=\"verrouiller(" . $cl['IDCLASSE'] .")\" />&nbsp;&nbsp;
                   <img style='cursor:pointer' src='" . img_delete_disabled() . "' /></td>";
            }
            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#classeTable")) {
            $("#classeTable").DataTable({
                bInfo: false,
                paging: false,
                columns: [
                    {width: "7%"},
                    null,
                    {width: "10%"},
                    {width: "10%"}
                ]
            });
        }
    });
</script>