<?php
$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF

$titre = '<p style = "text-decoration:underline"><b>SUIVI D\'ABSENCE DE L\'ANNEE SCOLAIRE ' . $anneescolaire . '</b></p>';
$pdf->WriteHTMLCell(0, 50, 60, $y, $titre);

$pdf->SetFont("helvetica", "", 9);
$titre = '<span style = "text-decoration:underline"><b>ELEVE</b></span><b> : ' . $eleve['NOM'] . ' '
        . $eleve['PRENOM'] . ' ' . $eleve['AUTRENOM'] . '</b>';
$pdf->WriteHTMLCell(0, 50, 10, 10 + $y, $titre);
$pdf->SetFont("helveticaI", "B", 9);
$pdf->WriteHTMLCell(0, 5, 10, 15 + $y, $libelle);

$pdf->SetFont("helvetica", "I", 9);
$d = new DateFR($datedebut);
$d2 = new DateFR($datefin);
$semaine = '<span>P&eacute;riode du <b style="text-decoration:underline">' . $d->getDate() . " " . $d->getMois() . " " . $d->getYear()
        . '</b> au <b style="text-decoration:underline">'
        . $d2->getDate() . " " . $d2->getMois() . " " . $d2->getYear() . '</b></span>';
$pdf->WriteHTMLCell(0, 50, 70, 20 + $y, $semaine);

$pdf->SetFont("Times", '', 11);

$corps = '<table cellpadding="2" border = "0.5">
    <thead><tr border ="0.5" style = "font-weight:bold"><th border ="0.5" width="20%">Jour/Date</th>';
for ($i = 1; $i <= MAX_HORAIRE + 1; $i++) {
    if ($i === 1) {
        $corps .= '<th border ="0.5" align="center" width="7%">1<sup>&egrave;re</sup>H</th>';
    } else {
        $corps .= '<th border ="0.5" align="center" width="7%">' . $i . '<sup>&egrave;me</sup>H</th>';
    }
}
$corps .= '<th border="0.2" width="10%">Total</th></tr></thead><tbody>';

$date = $datedebut;
$totaux = 0;
$t1 = $t2 = $t3 = $t4 = $t5 = $t6 = $t7 = $t8 = 0;
while ($date <= $datefin) {
    $abs = estAbsent($eleve['IDELEVE'], $absences, 0, $date);
    if (!is_null($abs)) {
        $total = 0;
        $d->setSource($date);
        $corps .= '<tr><td width="20%">' . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>";
        for ($i = 1; $i <= MAX_HORAIRE + 1; $i++) {
            $abs = estAbsent($eleve['IDELEVE'], $absences, $i, $date);
            if (!empty($abs['JUSTIFIER'])) {
                $corps .= '<td style="background-color:#ffff66;text-align:center" width="7%">J</td>';
            } elseif ($abs['ETAT'] === "A") {
                $corps .= '<td style="background-color:#ff9999;text-align:center" width="7%">A</td>';
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
                $corps .= '<td style="background-color:#99ffff;text-align:center" width="7%">R</td>';
            } elseif ($abs['ETAT'] === "E") {
                $corps .= '<td style="background-color:#ccccff;text-align:center" width="7%">E</td>';
            } else {
                $corps .= '<td width="7%"></td>';
            }
        }
        $corps .= '<td width="10%" style="text-align:center">' . $total . ' hrs</td></tr>';
        $totaux += $total;
    }
    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
}

$corps .= '<tr border ="0.5"><td style="font-weight: bold;" width="20%">TOTAUX</td>';

$corps .= '<td width="7%">' . $t1 . ' hrs</td><td width="7%">' . $t2 . ' hrs</td><td width="7%">' . $t3 . ' hrs</td>';
$corps .= '<td width="7%">' . $t4 . ' hrs</td><td width="7%">' . $t5 . ' hrs</td>';
$corps .= '<td width="7%">' . $t6 . ' hrs</td><td width="7%">' . $t7 . ' hrs</td><td width="7%">' . $t8 . ' hrs</td>';
$corps .= '<td style="text-align:center;font-weight: bold;" width="10%">' . $totaux . ' HRS</td>';

$corps .= "</tr></tbody></table>";
$pdf->WriteHTMLCell(0, 5, 30, 30 + $y, $corps);


$pdf->output();
