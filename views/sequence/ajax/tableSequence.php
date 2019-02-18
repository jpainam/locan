<table class="dataTable" id="sequenceTable">
    <thead><tr><th>N°</th><th>Libell&eacute;</th><th>Date d&eacute;but</th>
            <th>Date fin</th><th><img src="<?php echo SITE_ROOT . "public/img/lock.png"; ?>" /></th>
            <th></th></tr></thead><tbody>
        <?php
        $i = 1;
        $d = new DateFR();
        foreach ($sequences as $seq) {
            $d->setSource($seq['DATEDEBUT']);
            echo "<tr><td>" . $i . "</td><td>" . $seq['LIBELLE'] . "</td><td>" . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3)
            . " " . $d->getYear() . "</td>";
            $d->setSource($seq['DATEFIN']);
            echo "<td>" . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>";

            if ($seq['VERROUILLER'] == 1) {
                echo "<td align='center'><input type='checkbox' checked disabled /></td>";
            } else {
                echo "<td align='center'><input type='checkbox' disabled /></td>";
            }
            if ($seq['VERROUILLER'] == 1) {
                echo "<td align='center'><img style='cursor:pointer' src='" . img_valider_disabled() . "' />&nbsp;&nbsp;"
                . "<img src='" . img_delete() . "' style='cursor:pointer' onclick=\"deverrouiller(" . $seq['IDSEQUENCE'] . ")\" /></td>";
            } else {
                echo "<td align='center'><img src='" . img_valider() . "' style='cursor:pointer' "
                . "onclick=\"verrouiller(" . $seq['IDSEQUENCE'] . ")\" />&nbsp;&nbsp;
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
        if (!$.fn.DataTable.isDataTable("#sequenceTable")) {
            $("#sequenceTable").DataTable({
                bInfo: false,
                paging: false,
                searching: false,
                scrollY: $(".page").height() - 75,
                columns: [
                    {"width": "7%"},
                    null,
                    {"width": "15%"},
                    {"width": "15%"},
                    {"width": "5%"},
                    {"width": "7%"}
                ]
            });
        }
    });
</script>