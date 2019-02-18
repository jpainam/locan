<?php
$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

$titre = '<p style="text-decoration:underline">LISTE DES MATIERES ENSEIGNEES</p>';
$pdf->WriteHTMLCell(0, 5, 70, $y, $titre);

$pdf->setFont('Times', '', 13);
$corps = '<table border="0.5" cellpadding="5"><thead><tr style="font-weight:bold">'
        . '<th width="20%">Code</th><th width="80%">Libell&eacute;</th></tr></thead><tbody>';

foreach ($matieres as $mat) {
    $corps .= '<tr><td width="20%">' . $mat['CODE'] . '</td><td width="80%">' . $mat['LIBELLE'] . '</td></tr>';
}
$corps .= '</tbody></table>';

$pdf->WriteHTMLCell(0, 5, 10, $y + 15, $corps);
$pdf->Output();
