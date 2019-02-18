<?php

//$pdf->SetFont('helvetica', '', 10);

$y = PDF_Y;
$x = PDF_X - 5;
$pdf->bCertify = false;
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->SetPrintHeader(false);

if ($codeperiode === "T") {
    define("NBHEURE_TOTAL", 456);
    $lbl = $trimestre['LIBELLE'];
} else {
    define("NBHEURE_TOTAL", 228);
    $lbl = $sequence['LIBELLEHTML'];
}
$pdf->SetFont("Times", '', 8);
$pdf->WriteHTMLCell(0, 0, $x, $y + 5, '<b>DATE :</b>');
$pdf->WriteHTMLCell(100, 0, $x + 140, $y + 5, '<b>Annee scolaire :</b>' . $_SESSION['anneeacademique']);
$pdf->SetFont("Times", '', 10);
$titre = '<p style="text-align:center"><b>BILAN GLOBAL DES RESULTATS</b><br>' . $lbl . '</p>';
$pdf->WriteHTMLCell(0, 0, $x + 5, $y, $titre);
$pdf->SetFont("Times", '', 6);

$cols = [3, 4.3, 5, 5, 8.6];
$corps = '<table style="text-align:center" cellpadding="2" border="1"><thead>
    <tr  border ="1"   style="font-weight:bold"  >
        <td border="1"  width ="' . $cols[0] . '%"   rowspan="3" >N°</td>
        <td border="1"  width ="' . $cols[2] . '%" rowspan="3" >Classe </td>
        <td border="1"  width ="' . $cols[1] . '%"  rowspan="3">&eacute;leves  <br>class&eacute;s</td>
        <td border="1"  width ="' . $cols[1] . '%" rowspan="3">Moy  <br>Classe</td>
        <td border="1"  width ="' . $cols[1] . '%" rowspan="3">Faible <br> moy</td>
        <td border="1"  width ="' . $cols[1] . '%" rowspan="3">Forte<br>moy</td>
        <td border="1" colspan="2" width ="' . $cols[4] . '%" >Moy &lt; 7,5 </td>
        <td border="1" colspan="2" width ="' . $cols[4] . '%">Moy &lt;  10</td>
        <td border="1" colspan="2" width ="' . $cols[4] . '%">Moy &gt;=10</td>
        <td border="1" colspan="2" width ="' . $cols[4] . '%">Moy &gt;= 12</td>
        <td border="1" colspan="8" width ="' . ($cols[1] * 8) . '%">Discipline</td>
        <td border="1" width ="' . $cols[1] . '%">D&eacute;m</td>
        <td border="1"  width ="' . $cols[3] . '%" rowspan="3" align="center" >Effectif<br>r&eacute;el</td>
      </tr>';
$corps .= '<tr>';
for ($i = 1; $i <= 4; $i++) {
    $corps .= '<td border="1" rowspan="2" width ="' . $cols[1] . '%">Nbre</td>'
            . '<td border="1" rowspan="2" width ="' . $cols[1] . '%">%</td>';
}

$corps .= '<td border="1" colspan="3" width ="' . ($cols[1] + $cols[1] + $cols[1]) . '%">Absences</td>
            <td border="1" rowspan="2" width ="' . $cols[1] . '%">Cons</td>
            <td border="1" rowspan="2" width ="' . $cols[1] . '%">AvtC</td>
            <td border="1" rowspan="2" width ="' . $cols[1] . '%">BlmC</td>
            <td border="1" rowspan="2" width ="' . $cols[1] . '%">Ex.T</td>
            <td border="1" rowspan="2" width ="' . $cols[1] . '%">Ex.D</td>
            <td border="1" rowspan="2" width ="' . $cols[1] . '%">Nbre</td>
          </tr>';
$corps .= '<tr>
              <td border="1" width ="' . $cols[1] . '%">Nbre</td>
              <td border="1" width ="' . $cols[1] . '%">%Ass.</td>
              <td border="1" width ="' . $cols[1] . '%" style="font-size:5px">TauxAbs</td>
            </tr>';
$corps .= '</thead><tbody>';
$i = 1;
$total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$totaux = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$totalcycle = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

$niveau = $classes[0]["GROUPE"];
$cycle = $classes[0]['CYCLE'];
$lblcycle = $classes[0]['CYCLEHTML'];
foreach ($classes as $cl) {
    if ($niveau !== $cl['GROUPE']) {
        $corps .= printRecapitulatifGlobal($total, $cols);
        /* for ($i = 4; $i <= 7; $i++) {
          $str .= '<td width ="' . $cols[1] . '%">' . $total[$i] . '</td>';
          $str .= '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $total[$i] / $total[0] * 100) . '</td>';
          } */

        $totalcycle = array_map(function () {
            return array_sum(func_get_args());
        }, $totalcycle, $total);

        $total = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }
    if ($cycle !== $cl['CYCLE']) {
        $totalcycle[18] = 4;
        $corps .= printRecapitulatifGlobal($totalcycle, $cols, $lblcycle);
        $totaux = array_map(function () {
            return array_sum(func_get_args());
        }, $totaux, $totalcycle);

        $totalcycle = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $lblcycle = $cl['CYCLEHTML'];
    }
    $classe = $array_of_classes[$cl['IDCLASSE']];
    $rang = $classe['rangs'];
    $travail = $classe['travail'];
    $info = getInfoGlobal($rang);
    $inscr = getNBInscrits($inscrits, $cl['IDCLASSE']);
    $info[7] = $inscr['NBINSCRITS'];

    $corps .= '<tr><td width ="' . $cols[0] . '%">' . $i . '</td>'
            . '<td width ="' . $cols[2] . '%">' . $cl['NIVEAUHTML'] . '</td>'
            . '<td width ="' . $cols[1] . '%">' . $info[3] . '</td>'; # eleve classe
    $total[0] += $info[3];
    $corps .= '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $travail['MOYCLASSE']) . '</td>' # Moy Classe
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $info[0]) . '</td>' # Faible moyenne
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $info[1]) . '</td>'; # Forte moyenne
    $total[1] += sprintf("%.2f", $travail['MOYCLASSE']);
    $total[2] += sprintf("%.2f", $info[0]);
    $total[3] += sprintf("%.2f", $info[1]);
    $corps .= '<td width ="' . $cols[1] . '%">' . $info[2] . '</td>' # Nbre de moy < 7.5
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $info[2] / $info[3] * 100) . '</td>' # Pourcentage < 7.5
            . '<td width ="' . $cols[1] . '%">' . $info[4] . '</td>' # Nbre de moy < 10
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $info[4] / $info[3] * 100) . '</td>' # Pourcentage < 10
            . '<td width ="' . $cols[1] . '%">' . $info[5] . '</td>' # Nbre de moy >= 10
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $info[5] / $info[3] * 100) . '</td>' # Pourcentage >= 10
            . '<td width ="' . $cols[1] . '%">' . $info[6] . '</td>' # Nbre de moy >= 12
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $info[6] / $info[3] * 100) . '</td>'; # Pourcentage >= 12
    $total[4] += $info[2];
    $total[5] += $info[4];
    $total[6] += $info[5];
    $total[7] += $info[6];

    $absence = getInfoAbsence($absences, $cl['IDCLASSE']);
    $ass = (1 - ($absence[0] / (NBHEURE_TOTAL * $info[3]))) * 100;
    $tauxabs = ($absence[0] / (NBHEURE_TOTAL * $info[3])) * 100;
    $corps .= '<td width ="' . $cols[1] . '%">' . $absence[0] . '</td>'
            # % ASS
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $ass) . '</td>'
            # Taux Absence
            . '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $tauxabs) . '</td>'
            . '<td width ="' . $cols[1] . '%">' . $absence[2] . '</td>'
            . '<td width ="' . $cols[1] . '%">' . $absence[3] . '</td>'
            . '<td width ="' . $cols[1] . '%">' . $absence[4] . '</td>'
            . '<td width ="' . $cols[1] . '%">' . $absence[5] . '</td>'
            . '<td width ="' . $cols[1] . '%">0</td><td width ="' . $cols[1] . '%">0</td>'
            . '<td width ="' . $cols[3] . '%">' . $info[7] . '</td>'
            . '</tr>';
    $total[8] += $absence[0];
    //$total[9] += sprintf("%.2f", $ass);
    for ($j = 11; $j <= 16; $j++) {
        $total[$j] += $absence[$j - 9];
    }
    $total[17] += $info[7];
    $total[18] += 1;
    $i++;
    $niveau = $cl['GROUPE'];
    $cycle = $cl['CYCLE'];
}

$corps .= printRecapitulatifGlobal($total, $cols);
$totalcycle = array_map(function () {
    return array_sum(func_get_args());
}, $totalcycle, $total);
$totalcycle[18] = 3;

$corps .= printRecapitulatifGlobal($totalcycle, $cols, $lblcycle);

$totaux = array_map(function () {
    return array_sum(func_get_args());
}, $totaux, $totalcycle);
$totaux[18] = 2;
$corps .= printRecapitulatifGlobal($totaux, $cols, "Globales");
$corps .= '</tbody></table>';

$pdf->WriteHTMLCell(0, 0, $x, $y + 10, $corps);
$pdf->Output();

function getInfoGlobal($rang) {
    $min = 1000000;
    $max = 0;
    $tab = [0, 0, 0, 0, 0, 0, 0, 0, 0];
    $i = 0;
    foreach ($rang as $r) {
        if ($r['MOYGENERALE'] > 0) {
            if ($max < $r['MOYGENERALE']) {
                $max = $r['MOYGENERALE'];
            }
            if ($min > $r['MOYGENERALE']) {
                $min = $r['MOYGENERALE'];
            }
            if ($r['MOYGENERALE'] < 7.5) {
                $tab[2] += 1;
            }
            if ($r['MOYGENERALE'] < 10) {
                $tab[4] += 1;
            }
            if ($r['MOYGENERALE'] >= 10) {
                $tab[5] += 1;
            }
            if ($r['MOYGENERALE'] >= 12) {
                $tab[6] += 1;
            }
            $i++;
        }
    }
    $tab[0] = $min;
    $tab[1] = $max;
    $tab[3] = 1;
    return $tab;
}

function printRecapitulatifGlobal(&$total, $cols, $lbl = "Partielles") {
    $total[9] = sprintf("%.2f", (1 - ($total[8] / (NBHEURE_TOTAL * $total[0]))) * 100);
    $total[10] = sprintf("%.2f", ($total[8] / (NBHEURE_TOTAL * $total[0])) * 100);

    $str = '<tr style="background-color:#CCC;font-weight:bold">'
            . '<td width ="' . ($cols[0] + $cols[2]) . '%" colspan="2">' . $lbl . '</td>'
            . '<td width ="' . $cols[1] . '%">' . $total[0] . '</td>';

    for ($i = 1; $i <= 3; $i++) {
        $total[$i] = sprintf("%.2f", $total[$i] / $total[18]) . '</td>';
        $str .= '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $total[$i]) . '</td>';
    }
    for ($i = 4; $i <= 7; $i++) {
        $str .= '<td width ="' . $cols[1] . '%">' . $total[$i] . '</td>';
        $str .= '<td width ="' . $cols[1] . '%">' . sprintf("%.2f", $total[$i] / $total[0] * 100) . '</td>';
    }
    for ($i = 8; $i < 17; $i++) {
        $str .= '<td width ="' . $cols[1] . '%">' . $total[$i] . '</td>';
    }
    $str .= '<td width ="' . $cols[3] . '%">' . $total[$i] . '</td></tr>';

    $str .= '<tr><td colspan="23" border="0"></td></tr>';
    return $str;
}

function getInfoAbsence($absences, $idclasse) {
    $tab = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    foreach ($absences as $abs) {
        if ($abs['CLASSE'] === $idclasse) {
            $tab[0] += ($abs['ABSENCE'] - $abs['JUSTIFIER']);
            $tab[1] += $abs['JUSTIFIER'];
            $tab[2] += $abs['CONSIGNE'];
            $abstmp = $abs['ABSENCE'] - $abs['JUSTIFIER'];

            if ($abstmp >= 6 && $abstmp <= 10) {
                $tab[3] += 1;
            } elseif ($abstmp >= 11 && $abstmp <= 15) {
                $tab[4] += 1;
            } elseif ($abstmp >= 16) {
                $tab[5] += 1;
            }
        }
    }
    return $tab;
}

function getNBInscrits($inscrits, $idclasse) {
    foreach ($inscrits as $insc) {
        if ($insc['IDCLASSE'] === $idclasse) {
            return $insc;
        }
    }
    return null;
}
