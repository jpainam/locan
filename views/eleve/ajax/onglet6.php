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
            $abs = estAbsent($ideleve, $absences, 0, $date);
            if (!is_null($abs)) {
                $total = 0;
                $d->setSource($date);
                echo '<tr><td width="20%">' . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>";
                for ($i = 1; $i <= MAX_HORAIRE + 1; $i++) {
                    $abs = estAbsent($ideleve, $absences, $i, $date);
                    if (!empty($abs['JUSTIFIER'])) {
                         echo '<td style="background-color:#ffff66;text-align:center" width="7%">J</td>';
                    } elseif ($abs['ETAT'] === "A") {
                        echo '<td style="background-color:#ff9999;text-align:center" width="7%">A</td>';
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
                    }elseif ($abs['ETAT'] === "R") {
                         echo  '<td style="background-color:#99ffff;text-align:center" width="7%">R</td>';
                    } elseif ($abs['ETAT'] === "E") {
                        echo '<td style="background-color:#ccccff;text-align:center" width="7%">E</td>';
                    } else {
                        echo '<td width="7%"></td>';
                    }
                }
                echo '<td width="10%" style="text-align:center">' . $total . ' hrs</td></tr>';
                $totaux += $total;
            }
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
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
        paging: false,
        searching: false,
        scrollY : $(".page").height() - 150
    });
</script>