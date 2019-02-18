<?php

$pdf->setPageOrientation('L');
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$y = PDF_Y;
$x = PDF_X;
$middle = PDF_MIDDLE;
$pdf->WriteHTMLCell(0, 5, $middle + 10, $y - 5, '<h3 style="text-decoration:underline">Conseill&acirc;t &agrave; l\'&eacute;ducation</h3>');
$pdf->WriteHTMLCell(0, 5, $middle - 30, $y + 5, '<h4 style="text-decoration:underline">FICHE DE SUIVI DISCIPLINAIRE DU PERSONNEL ENSEIGNANT</h4>');

$pdf->setFont("Times", "", 12);
$pdf->WriteHTMLCell(0, 5, $x, $y + 12, 'Secteur de discipline N° : ....................');
$pdf->WriteHTMLCell(0, 5, $x + 120, $y + 12, 'Trimestre  N° : '.$sequence['TRIMESTREORDRE']);
$pdf->WriteHTMLCell(0, 5, $x + 200, $y + 12, 'S&eacute;quence  N° : '.$sequence['SEQUENCEORDRE']);
if (empty($datefin)) {
    $datefin = date("Y-m-d", strtotime("+7 day", strtotime($datedebut)));
}
$d = new DateFR($datedebut);
$d2 = new DateFR($datefin);
$pdf->WriteHTMLCell(0, 5, $middle, $y + 20, 'Semaine du <b>' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() .
        '</b> au <b>' . $d2->getDate() . " " . $d2->getMois(3) . " " . $d2->getYear() . '</b>');

$w = [10, 35, 8, 8, 8, 8, 25];
$corps = '<table cellpadding="3"><thead><tr align="center" style="font-weight:bold"><th width="' . $w[0] . '%" border="0.5">Dates</th>'
        . '<th width="' . $w[1] . '%" border="0.5">Nom et Pr&eacute;nom</th>'
        . '<th width="' . $w[2] . '%" border="0.5">Mati&egrave;re</th>'
        . '<th width="' . $w[3] . '%" border="0.5">Classe</th>'
        . '<th width="' . $w[4] . '%" border="0.5">Retard</th>'
        . '<th width="' . $w[5] . '%" border="0.5">Absence</th>'
        . '<th width="' . $w[6] . '%" border="0.5">Autres</th></tr></thead>'
        . '<tbody>';
foreach ($absences as $abs) {
    $d->setSource($abs['DATEJOUR']);

    $corps .= '<tr><td width="' . $w[0] . '%" border="0.5">' . $d->getDate() . ' ' . $d->getMois(3) . ' ' . $d->getYear() . '</td>'
            . '<td width="' . $w[1] . '%" border="0.5">' . $abs['NOM'] . ' ' . $abs['PRENOM'] . '</td>'
            . '<td width="' . $w[2] . '%" border="0.5">' . $abs['CODE'] . '</td>'
            . '<td width="' . $w[3] . '%" border="0.5">' . $abs['NIVEAUHTML'] . '</td>';
    if ($abs['ETAT'] == "R") {
        $corps .= '<td width="' . $w[4] . '%" border="0.5">' . substr($abs['RETARD'], 0, 5) . '</td>';
    } else {
        $corps .= '<td width="' . $w[4] . '%" border="0.5"></td>';
    }
    if ($abs['ETAT'] == "A") {
        $corps .= '<td width="' . $w[5] . '%" border="0.5">' . $abs['NBHEURE'] . '</td>';
    } else {
        $corps .= '<td width="' . $w[5] . '%" border="0.5"></td>';
    }

    $corps .= '<td width="' . $w[6] . '%" border="0.5">' . $abs['OBSERVATION'] . '</td></tr>';
}
$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, $x, $y + 30, $corps);

$pdf->WriteHTMLCell(0, 5, $x + 200, $y + 130, '<span style="text-decoration:underline">Le Conseiller &agrave; l\'&eacute;ducation</span>');
$pdf->Output();
