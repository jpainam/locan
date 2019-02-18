<?php
$y = FIRST_TITLE;
#$pdf->bCertify = true;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

//$pdf->SetPrintFooter(false);

//Titre du PDF
$titre = '<p style = "text-decoration:underline">REPERTOIRE TELEPHONIQUE ENSEIGNANTS</p>';
$pdf->WriteHTMLCell(0, 50, 65, $y, $titre);

//Corps du PDF
$corps = <<<EOD
        <table border = "0" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width ="5%">N°</th>
        <th width ="15%">M<sup>le</sup></th><th width ="40%">Noms & Pr&eacute;noms</th>
        <th width ="13%">Grade</th><th width ="13%">Portable.</th>
            <th width ="13%">Tel.</th></tr></thead><tbody>
EOD;
$i = 1;
foreach ($enseignants as $en) {
    $corps .= '<tr><td width ="5%" border="1">' . $i . '</td>'
            . '<td width ="15%" border="1">' . $en['MATRICULE'] . '</td>'
            . '<td width ="40%" border="1">' . $en['NOM'] . ' ' . $en['PRENOM'] . '</td>'
            . '<td width ="13%"  border="1">' . $en['GRADE']. '</td>'
            . '<td width ="13%"  border="1">' . $en['PORTABLE']. '</td>'
            . '<td width ="13%"  border="1">' . $en['TELEPHONE']. '</td></tr>';
   $i++;
    
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 9);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '');

$pdf->WriteHTMLCell(0, 5, 10, $y + 10, $corps);

//$pdf->signature();
$pdf->Output();