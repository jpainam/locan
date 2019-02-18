<table class="dataTable" id="tableAbsences">
    <thead><tr><th>Dates</th>
            <?php
            $semaine = jourSemaine();
            for($i = 0; $i < 6; $i++) {
                echo "<th>" . $semaine[$i]. "</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $d = new DateFR($datedebut);
        $date = $datedebut;
        while ($date <= $datefin) {
            echo "<tr><td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>";
            $dayofweek = date("w", strtotime($date));
            for($j = 1; $j < $dayofweek; $j++){
                echo "<td></td>";
            }
            # Parcourir les jours de la semaine
        for ($i = $j; $i < 7; $i++) {
                $absents = enseignantAbsentByPeriode($date, $absences);
                echo "<td>";
                foreach ($absents as $abs) {
                    echo substr($abs['NOM'], 0, 10) . "<br/>";
                }
                echo "</td>";
                
                # Passer au jour suivant
                $date = date("Y-m-d", strtotime("+1"
                        . " day", strtotime($date)));
                $d->setSource($date);
            }
           
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $d->setSource($date);
        }
        ?>
    </tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#tableAbsences")) {
        $("#tableAbsences").DataTable({
            bInfo: false,
            paging: false,
            searching: false
        });
    }
</script>