<?php

$x = PDF_X;
$y = PDF_Y;
$middle = PDF_MIDDLE;
$pdf->AddPage();
$pdf->WriteHTMLCell(0, 5, $middle - 40, $y, '<h3 style="text-decoration:underline">RECAPITULATIF DES ABSENCES</h3>');
$pdf->WriteHTMLCell(0, 5, $x, $y + 10, 'Enseignant : <b>' . $enseignant['NOM'] . ' ' . $enseignant['PRENOM'] . "</b>");

$pdf->setFont("Times", "", 12);
$d = new DateFR($datedebut);
if (empty($datefin)) {
    $datefin = "2035-01-01";
}
$dd = new DateFR($datefin);
$pdf->WriteHTMLCell(100, 5, $x + 120, $y + 10, 'P&eacute;riode : <b>' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " au "
        . $dd->getDate() . " " . $dd->getMois(3) . " " . $dd->getYear() . "</b>");

$pdf->setFont("Times", "", 12);
$w = [5, 13, 13, 13, 13, 30, 15];
$corps = '<table cellpadding="3"><thead><tr align="center" style="font-weight:bold">'
        . '<th border="0.5" width="' . $w[0] . '%">N°</th><th border="0.5" width="' . $w[6] . '%">Dates</th>'
        . '<th border="0.5" width="' . $w[1] . '%">Classes</th>'
        . '<th border="0.5" width="' . $w[2] . '%">Mati&egrave;re</th>'
        . '<th border="0.5" width="' . $w[3] . '%">Retards</th>'
        . '<th border="0.5" width="' . $w[4] . '%">Absences</th>'
        . '<th border="0.5" width="' . $w[5] . '%">Autres</th></tr></thead><tbody>';

$i = 1;

foreach ($absences as $abs) {
    $d->setSource($abs['DATEJOUR']);

    $corps .= '<tr><td border="0.5" width="' . $w[0] . '%">' . $i . '</td>'
            . '<td border="0.5" width="' . $w[6] . '%">' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . '</td>'
            . '<td border="0.5" width="' . $w[1] . '%">' . $abs['NIVEAUHTML'] . '</td>'
            . '<td border="0.5" width="' . $w[2] . '%">' . $abs['CODE'] . '</td>';
    if ($abs['ETAT'] == "R") {
        $corps .= '<td border="0.5" width="' . $w[3] . '%" align="right">' . $abs['RETARD'] . '</td>';
    } else {
        $corps .= '<td border="0.5" width="' . $w[3] . '%"></td>';
    }
    if ($abs['ETAT'] == "A") {
        $corps .= '<td border="0.5" width="' . $w[4] . '%" align="right">' . $abs['NBHEURE'] . ' Hrs</td>';
    } else {
        $corps .= '<td border="0.5" width="' . $w[4] . '%" align="right"></td>';
    }
    $corps .= '<td border="0.5" width="' . $w[5] . '%">' . $abs['OBSERVATION'] . '</td></tr>';
    $i++;
}
$corps .= '<tr style="font-weight:bold">'
        . '<td border="0.5" colspan="4" align="center" width="' . ($w[0] + $w[6] + $w[1] + $w[1]) . '%">Total</td>'
        . '<td border="0.5" width="' . $w[3] . '%" align="right">' . $recapitulatif['SUMRETARD'] . '</td>'
        . '<td border="0.5" width="' . $w[4] . '%" align="right">' . $recapitulatif['SUMABSENCE'] . ' Hrs</td>'
        . '<td border="0.5" width="' . $w[5] . '%"></td></tr>';
$corps .= '</tbody></table>';

$pdf->WriteHTMLCell(0, 5, $x, $y + 20, $corps);
$pdf->Output();
