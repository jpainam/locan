<style>
    .tableAbsences{
        border-collapse: collapse;
        border: 1px solid #000;
        margin: auto;
    }
    .tableAbsences td, th{
        border:1px solid #000;
        padding: 0 5px 0 5px;
    }
    .tableAbsences tbody tr:nth-child(2n){
        background-color: rgb(225, 196, 196); //#E1C4C4
    }
    .tableAbsences tbody tr:nth-child(2n +1){
        background-color: #FFF;
    }
    .tableAbsences tbody tr:hover{
        background-color: rgb(207,160,160);
    }
    .tableAbsences .present {
        width: 30px;
        background-color: #99ff99;
    }
    .tableAbsences .absent{
        width: 30px;
        background-color: #ff9999;
        text-align: center;
    }
    .tableAbsences .total{
        background-color: #F7F7F7;
    }
    .tableAbsences .justifier{
        background-color: #ffff66;
    }
    .tableAbsences .retard, .tableAbsences .exclu{
        background-color: #FFF;
        text-align: center;
    }
</style>
<?php
if (isset($deja)) {
    echo '<p style="color: #ff9999;text-align: center;margin:auto;width:100%;">Appel d&eacute;j&agrave; r&eacute;alis&eacute;<br/>';
    if (isAuth(320)) {
        echo "Proc&eacute;dez &agrave; <a href='" . Router::url("appel", "edit", $appel['IDAPPEL']) . "'>l'&eacute;dition ici</a>";
    } else {
        echo "Vous n'&ecirc;tes pas autoris&eacute;s &agrave effectuer une modification";
    }
    echo "</p>";
}
?>
<table class="tableAbsences">
    <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th><th colspan="8"><?php
                $d = new DateFR($appel['DATEJOUR']);
                echo $d->getJour(3) . " " . $d->getDate() . "-" . $d->getMois(3) . "-" . $d->getYear();
                ?></th><th>Total</th></tr></thead>
    <tbody>
        <tr><td colspan="2" style="text-align: center;">HEURES</td><?php
            $horaires = getHoraires($appel['HEUREDEBUT'], $appel['HEUREFIN']);

            foreach ($horaires as $h) {
                if ($h === 1) {
                    echo "<td>1<sup>&egrave;re</sup>Heure</td>";
                } else {
                    echo "<td>" . $h . "<sup>&egrave;me</sup>Heure</td>";
                }
            }
            # Ferme le tr de la ligne HEURES
            echo "<td></td></tr>";
            $i = 1;
            foreach ($absences as $abs) {
                echo "<tr>";
                if ($i < 10) {
                    echo "<td>0" . $i . "</td>";
                } else {
                    echo "<td>" . $i . "</td>";
                }
                echo "<td>" . $abs['NOM'] . " " . $abs['PRENOM'] . "</td>";
                $total = 0;
                $etats = null;
                foreach ($horaires as $h) {
                    if (!is_null($abs['IDABSENCE']) && is_null($etats)) {
                        $etats = json_decode($abs['ETAT'], true);
                    } elseif(is_null($etats)) {
                        echo "<td class='present'>&nbsp;</td>";
                    }

                    if (!is_null($etats)) {
                        $first_key = key($etats);
                        
                        if($first_key === $h){
                            echo "<td class='present'>&nbsp;</td>";
                        }
                        if ($array['etat'] === "A" && !empty($abs['JUSTIFIER'])) {
                                echo "<td class='justifier' align='center'>A</td>";
                                //$total++;
                            } elseif ($array['etat'] === "A") {
                                $total++;
                                echo "<td class='absent'>A</td>";
                            } elseif ($array['etat'] === "R") {
                                echo "<td class='retard'>R</td>";
                            } elseif ($array['etat'] === "E") {
                                echo "<td class='exclu'>E</td>";
                            } else {
                                echo "<td class ='present'>&nbsp;</td>";
                            }
                        }


                        end($etats);
                        $last_key = key($etats);
                        for ($j = intval($last_key) + 1; $j < $colonnes; $j++) {
                            echo "<td class='present'>&nbsp;</td>";
                        }
                    }
                
                echo "<td align='center' class = 'total'>" . $total . " h</td>";
                echo "</tr>";
                $i++;
            }
            ?>
    </tbody>
</table>