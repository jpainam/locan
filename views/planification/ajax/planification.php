<table class="dataTable" id="tablePlanification">
    <thead><tr><th></th><th>Mati&egrave;res</th><th>Enseignant</th><th>S&eacute;quence</th>
            <th>Nb.H</th><th></th></tr></thead>
    <tbody>
        <?php
        $total = 0;
        $i = 1;
        foreach ($planifications as $plan) {
            echo "<tr><td>$i</td><td>" . $plan['MATIERELIBELLE'] . "</td><td>" . $plan['NOM'] . "</td><td>" .
            $plan["LIBELLEHTML"] . "</td><td align='right'>" . $plan['NBHEURE'] . "</td>";
            echo "<td align='center'>";
            echo "<img style='cursor:pointer' src='" . img_delete() . "' "
            . "onclick='supprimerPlanification(" . $plan['IDPLANIFICATION'] . ")' />";
            echo "</td></tr>";
            $i++;
            $total += $plan['NBHEURE'];
        }
        ?>
        <tr><td></td><td>TOTAL</td><td></td><td></td><td align="right"><?php echo $total; ?></td><td></td></tr>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tablePlanification")) {
            $("#tablePlanification").DataTable({
                bInfo: false,
                paging: false,
                columns: [
                    {"width": "5%"},
                    null,
                    null,
                    {"width": "15%"},
                    {"width": "5%"},
                    {"width": "5%"}
                ]
            });
        }
    });
</script>