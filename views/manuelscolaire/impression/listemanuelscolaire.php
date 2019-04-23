<?php
$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);


$titre = '<p style="text-decoration:underline"><b>LISTE DES MANUELS SCOLAIRES</b></p>';
$pdf->WriteHTMLCell(0, 5, 75, $y, $titre);
$pdf->WriteHTMLCell(0, 5, 10, $y + 10, '<b>ANNEE: ' . $_SESSION['anneeacademique'] . '</b>');

$corps = '<table border="0.5" cellpadding="5">'
        . '<thead><tr style="font-weight:bold">'
        . '<th width="40%">Titre du Manuel</th><th width="25%">Editeurs</th>'
        . '<th width="25%">Auteurs</th><th width="12%">Prix</th></tr></thead><tbody>';

foreach ($manuels as $m) {
    $corps .= '<tr><td width="40%">' . $m['TITRE'] . '</td>'
            . '<td width="25%">' . $m['EDITEURS'] . '</td>'
            . '<td width="25%">'.$m['AUTEURS'].'</td>'
            . '<td width="12%" align="right">'. $m['PRIX'].'</td></tr>';
}
$corps .= '</tbody></table>';

$pdf->setFont("Times", "", 10);
$pdf->WriteHTMLCell(0, 5, 10, $y + 20, $corps);
$pdf->Output();

