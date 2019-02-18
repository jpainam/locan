<?php
$horaire = getNbHoraire($classe['GROUPE']);
?>
<style>
    .tableAbsences .foncee{
        border-right: 3px solid #000;
    }
</style>
<table class="tableAbsences" id="tableAbsences" style="width: 100%">
    <thead>
        <tr><th>N°</th><th>Noms & Pr&eacute;noms</th><th class="foncee" colspan="<?php echo $horaire; ?>">Lundi</th>
            <th class="foncee" colspan="<?php echo $horaire; ?>">Mardi</th>
            <th class="foncee" colspan="<?php echo $horaire; ?>">Mercredi</th>
            <th class="foncee" colspan="<?php echo $horaire; ?>">Jeudi</th>
            <th class="foncee" colspan="<?php echo $horaire; ?>">Vendredi</th><th>Total</th></tr>
    </thead>
    <tbody>
        <tr><td colspan="2" style="text-align: center !important;font-weight: bold">HEURES</td>
            <?php
            for ($j = 1; $j <= $horaire * 5; $j++) {
                if ($j % $horaire === 0) {
                    echo "<td class='foncee'></td>";
                } else {
                    echo "<td>&nbsp;</td>";
                }
            }
            echo "<td></td></tr>";
            $i = 1;
            foreach ($eleves as $el) {
                echo "<tr>";
                if ($i < 10) {
                    echo "<td>0" . $i . "</td>";
                } else {
                    echo "<td>" . $i . "</td>";
                }
                $total = 0;
                echo "<td style='text-align:left !important'>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
                for ($j = 1; $j <= $horaire * 5; $j++) {
                    if($j % $horaire === 0){
                        $class = 'foncee';
                    }else{
                        $class = "";
                    }
                    $abs = estAbsent($el['IDELEVE'], $absences, $j);
                    if (is_null($abs)) {
                        echo "<td class = 'present $class'>&nbsp;&nbsp;&nbsp;</td>";
                    } elseif (!empty($abs['JUSTIFIER'])) {
                        echo "<td class='justifier $class'>&nbsp;&nbsp;&nbsp;</td>";
                    } elseif (!is_null($abs) && $abs['ETAT'] === "A") {
                        echo "<td class='absent $class'>&nbsp;&nbsp;&nbsp;</td>";
                        $total++;
                    } elseif (!is_null($abs) && $abs['ETAT'] === "R") {
                        echo "<td class='retard $class'>&nbsp;&nbsp;&nbsp;</td>";
                    } elseif (!is_null($abs) && $abs['ETAT'] === "E") {
                        echo "<td class='exclu $class'>&nbsp;&nbsp;&nbsp;</td>";
                    } else {
                        echo "<td>&nbsp;</td>"; # Peut jamais arriver la
                    }
                }
                echo "<td>$total&nbsp;hrs</td></tr>";
                $i++;
            }
            ?>
    </tbody>
</table>

<script>
    /*$(document).ready(function () {
     if(!$.fn.DataTable.isDataTable("#tableAbsences")){
     $("#tableAbsences").DataTable({
     "bInfo": false,
     "searching": false,
     "paging": false
     });
     }
     });*/
</script>