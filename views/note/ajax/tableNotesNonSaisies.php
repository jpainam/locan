<?php 
# droitTable -> tableNotesNonSaisie
?>
<table class="dataTable" id="droitTable">
    <thead><th>P&eacute;riode</th><th>Enseignants</th>
    <th>Mati&egrave;res</th><th>Coeff.</th></thead>
<tbody>
    <?php
    foreach ($notesnonsaisies as $n) {
        echo "<tr><td>".$n['SEQUENCELIBELLE']."</td>";
        echo "<td>" . $n['NOM'] . " - " . $n['PRENOM'] . "</td>";
        echo "<td>". $n['MATIERELIBELLE'].'</td>';
        echo "<td align='right'>". $n['COEFF']."</td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#droitTable")) {
            $("#droitTable").DataTable({
                columns: [
                    {"width": "15%"},
                    null,
                    null,
                    {"width": "5%"},
                ]
            });
        }
    });
</script>