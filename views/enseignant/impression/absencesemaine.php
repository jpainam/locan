<?php


/* classification par ordre horaire  */
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$annee = '2014/2015';
$trimestre = 1;
$y = FIRST_TITLE;
$x = 5;
$titre = '<h4 style = "text-align:center">  ENSEIGNANTS ABSENT<br>semaine  </h4>';
$pdf->WriteHTMLCell(0, 0, $x, $y , $titre);
$pdf->SetFont("Times", '', 7);
$dd = new DateFR($datedebut);
$df = new DateFR($datefin);
$titre = '<p><b>SEMAINE DU:</b>' . $dd->getDate() . ' ' . $dd->getMois(3) . ' ' . $dd->getYear() . ' <b> au </b>' . $df->getDate() . ' ' . $df->getMois(3) . ' ' . $df->getYear() . '</p>';
$titre .='<br><p><b>SQUENCE N°:</b>' . $sequence['SEQUENCEORDRE'] . '</p>';
$pdf->WriteHTMLCell(0, 0, $x + 5, $y + 5, $titre);
$col[0] = 10;
$col[1] = 16;
$col[2] = 16;
$col[3] = 16;
$col[4] = 16;
$col[5] = 16;
$col[6] = 16;
$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			       <th border="0.5"  width ="' . $col[0] . '%">DATES</th>
			        <th border="0.5" width ="' . $col[1] . '%">LUNDI</th>
				<th border="0.5"  width ="' . $col[2] . '%">MARDI</th>
				<th border="0.5"  width ="' . $col[3] . '%">MERCREDI</th>
				<th border="0.5"  width ="' . $col[4] . '%">JEUDI</th>
				<th border="0.5" width ="' . $col[5] . '%">VENDREDI</th>
				<th border="0.5"  width ="' . $col[6] . '%">SAMEDI</th>
             </tr>';
$date = $datedebut;
$d = new DateFR();
while ($date <= $datefin) {
    $d->setSource($date);
    $corps .= '<tr><td border="0.5">' . $d->getDate() . ' ' . $d->getMois(3) . ' ' . $d->getYear() . '</td>';
    $semaine = jourSemaine();
    for ($i = 1; $i < 7; $i++) {
        $absents = enseignantAbsentByPeriode($date, $absences);
        $corps .= '<td border="0.5">';
        foreach ($absents as $abs) {
            $corps .= substr($abs['NOM'], 0, 10) . "<br/>";
        }
        $corps .= "</td>";

        # Passer au jour suivant
        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
        $d->setSource($date);
    }
    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
    $d->setSource($date + 1);
    $corps .= '</tr>';
}
$corps .= '</table>';
$pdf->WriteHTMLCell(0, 0, $x, $y + 20, $corps);
$pdf->lastPage();
$pdf->Output();
