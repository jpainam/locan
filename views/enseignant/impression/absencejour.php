<?php

/* classification par ordre horaire  */
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$y = FIRST_TITLE;
$x = 5;
$d = new DateFR($datejour);
$titre = '<h4 style = "text-align:center"> ENSEIGNANTS ABSENT<br>JOUR</h4>';
$pdf->WriteHTMLCell(0, 0, $x, $y, $titre);
$pdf->SetFont("Times", '', 13);
$titre = '<p><b>JOURNEE DU : </b>' . $d->getJour(3) . ' ' . $d->getDate() . ' ' .
        $d->getMois(3) . ' ' . $d->getYear();
$pdf->WriteHTMLCell(0, 0, $x + 5, $y + 13, $titre);
$pdf->SetFont("Times", '', 7);
$titre = '<br/>SEQUENCE N° :<b>' . $sequence['SEQUENCEORDRE'] . '</b></p>';
$pdf->WriteHTMLCell(0, 0, $x + 5, $y + 20, $titre);
$col[0] = 8;
$col[1] = 12;
$col[2] = 12;
$col[3] = 12;
$col[4] = 12;
$col[5] = 12;
$col[6] = 12;
$col[7] = 12;
$col[8] = 12;
$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			    <th border="0.5"  width ="' . $col[0] . '%">CLASSES</th>
			    <th border="0.5"  width ="' . $col[1] . '%">1<sup>ere</sup>Heure</th>
				<th border="0.5"  width ="' . $col[2] . '%">2<sup>eme</sup>Heure</th>
				<th border="0.5"  width ="' . $col[3] . '%">3<sup>eme</sup>Heure</th>
				<th border="0.5" width ="' . $col[4] . '%">4<sup>eme</sup>Heure</th>
				<th border="0.5" width ="' . $col[5] . '%">5<sup>eme</sup>Heure</th>
				<th border="0.5"  width ="' . $col[6] . '%">6<sup>eme</sup>Heure</th>
				<th border="0.5"  width ="' . $col[7] . '%">7<sup>eme</sup>Heure</th>
				<th border="0.5"  width ="' . $col[8] . '%">8<sup>eme</sup>Heure</th>
				
             </tr>';
foreach ($classes as $cl) {
    $trouver = false;
    $str = '<tr><td  border="0.5">' . $cl['NIVEAUHTML'] . "</td>";
    for ($h = 1; $h <= HEURE_TRAVAIL; $h++) {
        $absents = enseignantAbsentByPeriode($datejour, $absences, $cl['IDCLASSE'], $h);
        $str .= '<td border="0.5">';
        if (!empty($absents)) {
            $trouver = true;
            foreach ($absents as $abs) {
                $str .= substr($abs["NOM"], 0, 10);
                if($abs['ETAT'] == "R"){
                    $str .= " (R ".  substr($abs['RETARD'], 0, 5).")";
                }
                $str .= "<br/>";
            }
        }
        $str .= "</td>";
    }
    $str .= "</tr>";
    if ($trouver) {
        $corps .= $str;
    }
}
$corps .= '</table>';
$pdf->SetFont("Times", '', 7);
$pdf->WriteHTMLCell(0, 0, $x, $y + 25, $corps);
$pdf->Output();
