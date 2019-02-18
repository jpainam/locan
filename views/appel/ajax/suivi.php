<table class="dataTable" id="tableSuivi">
    <thead><tr><th>Jour/Date</th>
            <?php
            for ($i = 1; $i <= MAX_HORAIRE + 1; $i++) {
                if ($i === 1) {
                    echo "<th>1<sup>&egrave;re</sup>H</th>";
                } else {
                    echo "<th>" . $i . "<sup>&egrave;me</sup>H</th>";
                }
            }
            ?><th>Total</th></tr></thead>

    <tbody>
        <?php
        $d = new DateFR($datedebut);
        $date = $datedebut;
        $totaux = 0;
        $t1 = $t2 = $t3 = $t4 = $t5 = $t6 = $t7 = $t8 = 0;
        while ($date <= $datefin) {

            if ((array_key_exists($date, $calendrier) && $calendrier[$date] != "V") || (!array_key_exists($date, $calendrier))) {
                $total = 0;
                echo "<tr><td>" . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>";
                for ($i = 1; $i <= MAX_HORAIRE + 1; $i++) {
                    $abs = estAbsent($ideleve, $absences, $i, $date);
                    if (array_key_exists($date, $calendrier)) {
                        echo "<td class='freedays'></td>";
                    } elseif (is_null($abs)) {
                        echo "<td class ='present'></td>";
                    } else {
                        if (!empty($abs['JUSTIFIER'])) {
                            echo "<td class ='justifier'></td>";
                        } elseif ($abs['ETAT'] === "A") {
                            echo "<td class='absent'></td>";
                            $total++;
                            if ($i == 1)
                                $t1++;
                            if ($i == 2)
                                $t2++;
                            if ($i == 3)
                                $t3++;
                            if ($i == 4)
                                $t4++;
                            if ($i == 5)
                                $t5++;
                            if ($i == 6)
                                $t6++;
                            if ($i == 7)
                                $t7++;
                            if ($i == 8)
                                $t8++;
                        } elseif ($abs['ETAT'] === "R") {
                            echo "<td class='retard'></td>";
                        } elseif ($abs['ETAT'] === "E") {
                            echo "<td class='exclu'></td>";
                        } else {
                            echo "<td></td>"; //Ne dois jamais arriver la;
                        }
                    }
                }
                $totaux += $total;
                echo "<td style='text-align:center !important'>$total hrs</td></tr>";
            }
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $d->setSource($date);
        }
        ?>
        <tr><td style="font-weight: bold;">TOTAUX</td>
            <?php
            echo "<td>$t1 hrs</td><td>$t2 hrs</td><td>$t3 hrs</td><td>$t4 hrs</td><td>$t5 hrs</td>";
            echo "<td>$t6 hrs</td><td>$t7 hrs</td><td>$t8 hrs</td><td style='text-align:center !important'>$totaux HRS</td>";
            ?>
        </tr>
    </tbody>
</table>
<script>
    $("#tableSuivi").DataTable({
        bInfo: false,
        "paging": false
    });
</script>