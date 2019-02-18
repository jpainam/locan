<table class="dataTable" id="tableAbsences">
    <thead><tr><th></th><th>Noms & Pr&eacute;noms</th><th>Classes</th>
            <?php
            echo "<th>1<sup>&egrave;re</sup>H</th>";
            for ($i = 2; $i < HEURE_TRAVAIL; $i++) {
                echo "<th>" . $i . "<sup>&eacute;me</sup>H</th>";
            }
            ?>
        </tr></thead>
    <tbody>
        <?php
        $i = 1;
     
        $array_of_absences = array();
        $array_of_classes = array();
        foreach ($absences as $absence) {
            if (!(in_array($absence['IDPERSONNEL'], $array_of_absences) && in_array($absence['CLASSE'], $array_of_classes))) {
                $array_of_absences[$i - 1] = $absence['IDPERSONNEL'];
                $array_of_classes[$i - 1] = $absence['CLASSE'];

                echo "<tr><td>$i</td><td>" . $absence['NOM'] . "</td><td>" . $absence['NIVEAUHTML'] . "</td>";
                for ($h = 1; $h < HEURE_TRAVAIL; $h++) {
                    $abs = enseignantAbsent($absence['IDPERSONNEL'], $absences, $h);
                    if ($abs['CLASSE'] == $absence['CLASSE']) {
                        if (is_null($abs) || empty($abs)) {
                            echo "<td class='present'></td>";
                        } elseif ($abs['ETAT'] == "A") {
                            echo "<td class='absent'></td>";
                        } elseif ($abs['ETAT'] == "R") {
                            echo "<td class='retard' align='center'>" . substr($abs['RETARD'], 0, 5) . "</td>";
                        }
                    } else {
                        echo "<td class='present'></td>";
                    }
                    $i++;
                }
            }
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
