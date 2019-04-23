<?php

$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

//$pdf->SetPrintFooter(false);
//Titre du PDF
$titre = '<p>LISTE DES MATIERES</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

$pdf->WriteHTMLCell(0, 5, 10, $y + 10, 'Classe : <b>' . $classe['NIVEAUHTML'] . ' ' . $classe['LIBELLE'] . '</b>');

//Corps du PDF
$corps = <<<EOD
        <table border = "0" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width="5%">N°</th><th width ="33%">Mati&egrave;res</th><th width ="37%">Enseignants</th>
        <th width ="15%">Groupe</th><th align="center" width ="15%">Coeff.</th>
            </tr></thead><tbody>
EOD;

$i = 1;
foreach ($enseignements as $scol) {

    $corps .= '<tr><td width="5%">' . $i . '</td>'
            . '<td width ="33%" style = "border-bottom:1px solid #000">' . $scol['MATIERELIBELLE'] . '</td>'
            . '<td width ="37%" style = "border-bottom:1px solid #000">' . $scol['CIVILITE'] . ' ' .
            $scol['NOM']. ' ' .$scol['PRENOM'] . '</td>'
            . '<td align="center" width ="10%"  style = "border-bottom:1px solid #000">' . 
            $scol['DESCRIPTION']. '</td>'
            . '<td align="right" width ="15%"  style = "border-bottom:1px solid #000">' .
            $scol['COEFF'] . '</td>';
    $corps .= '</tr>';
    $i++;
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 9);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '  ');

$pdf->WriteHTMLCell(0, 5, 10, $y + 35, $corps);

$pdf->Output();
