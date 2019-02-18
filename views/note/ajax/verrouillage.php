<table class="dataTable" id="tableVerrouillage">
    <thead><th>Date</th><th>P&eacute;riode</th><th>Mati&egrave;re - classe</th>
    <th>Coeff.</th><th>Libell&eacute; du devoir</th><th><img src="<?php echo img_lock(); ?>" /></th><th></th></thead>
<tbody>
    <?php
    foreach ($notations as $n) {
        $d = new DateFR($n['DATEDEVOIR']);
        echo "<tr><td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td><td>" . $n['SEQUENCELIBELLE'] . "</td>";
        echo "<td>" . $n['MATIERELIBELLE'] . " - " . $n['CLASSELIBELLE'] . "</td><td align='right'>" . $n['COEFF'] . "</td>";
        echo "<td>" . $n['DESCRIPTION'] . "</td>";
        if ($n['NOTATIONVERROUILLER'] == 1) {
            echo "<td align='center'><input type='checkbox' checked disabled='disabled' /></td>";
        } else {
            echo "<td align='center'><input disabled='disabled' type='checkbox' /></td>";
        }
        echo "<td align='center'>";
        
        if (isAuth(604) && $n['NOTATIONVERROUILLER'] != 1) {
            echo "<img style='cursor:pointer' src='" . img_valider() . "' onclick=\"btnVerrouiller(".$n['IDNOTATION'].")\" />&nbsp;&nbsp;";
        } else {
            echo "<img style='cursor:pointer' src='" . img_valider_disabled() . "' />&nbsp;&nbsp;";
        }
        
        if ($n['NOTATIONVERROUILLER'] == 1 && isAuth(604)) {
             echo "<img style='cursor:pointer' src='" . img_delete() . "' onclick=\"supprimerVerrouillage(".$n['IDNOTATION'].")\" />";
        }  else {
            echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
        }
        echo "</td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableVerrouillage")) {
            $("#tableVerrouillage").DataTable({
                columns: [
                    {"width": "8%"},
                    {"width": "12%"},
                    null,
                    {"width": "5%"},
                    null,
                    {"width": "3%"},
                    {"width": "7%"}
                ]
            });
        }
    });
</script>