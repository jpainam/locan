<?php

$pdf->AddPage();
$pdf->SetPrintHeader(false);
$x = PDF_X;
$y = PDF_Y;
$middle = PDF_MIDDLE;

$pdf->WriteHTMLCell(0, 5, $middle - 60, $y + 5, '<h4 style="text-decoration:underline">RECAPITULATIF D\'ASBENCE DU PERSONNEL ENSEIGNANT</h4>');
$pdf->SetFont("Times", "", 12);

if (empty($datefin)) {
    $datefin = "2035-01-01";
}
$d = new DateFR($datedebut);
$d2 = new DateFR($datefin);
$infodate = "Date : <b>" . $d->getDate()." ".$d->getMois(3)." ".$d->getYear()."</b> au <b>"
        . $d2->getDate()." ".$d2->getMois(3)." ".$d2->getYear()."</b>";
$pdf->WriteHTMLCell(0, 5, $x, $y + 15, $infodate);
$w = [5, 65, 15, 15];
$i = 1;

$corps = '<table cellpadding="3"><thead><tr align="center" style="font-weight:bold"><th border="0.5" width="'.$w[0].'%">N°</th>'
        . '<th border="0.5" width="'.$w[1].'%">Noms et Pr&eacute;noms</th><th border="0.5" width="'.$w[2].'%">Retards</th>'
        . '<th border="0.5" width="'.$w[3].'%">Absences</th></tr></thead><tbody>';

foreach($absences as $abs){
    $corps .= '<tr><td border="0.5" width="'.$w[0].'%">'.$i.'</td>'
            . '<td border="0.5" width="'.$w[1].'%">'.$abs['NOM'].' '.$abs['PRENOM'].'</td>'
            . '<td align="right" border="0.5" width="'.$w[2].'%">'.$abs['SUMRETARD'].'</td>'
            . '<td border="0.5" align="right" width="'.$w[3].'%">'.$abs['SUMABSENCE'].' Hrs</td></tr>';
    $i++;
}
$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, $x, $y + 25, $corps);
$pdf->Output();