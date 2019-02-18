<?php

$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

//$pdf->SetPrintFooter(false);
//Titre du PDF
$titre = '<p>SITUATION FINANCIERE</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

$pdf->WriteHTMLCell(0, 5, 10, $y + 10, 'Classe : <b>' . $classe['NIVEAUHTML'] . ' ' . $classe['LIBELLE'] . '</b>');
$pdf->WriteHTMLCell(0, 5, 10, $y + 15, 'Effectif : <b>' . $effectif . '</b>');

$corps = "Total des frais &agrave; payer : <i>" . moneyString($montanttotal) . ' fcfa</i>';

$pdf->WriteHTMLCell(0, 5, 10, $y + 25, $corps);

//Corps du PDF
$corps = <<<EOD
        <table border = "0" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width="5%">N°</th><th width ="10%">Mle</th><th width ="35%">Noms & Pr&eacute;noms</th>
        <th width ="15%">Redoublant.</th><th align="center" width ="15%">Total vers&eacute;</th>
            <th  width ="15%" align="center">Solde</th>
            <th  width ="7%"></th></tr></thead><tbody>
EOD;
if (!is_array($array_of_redoublants)) {
    $array_of_redoublants = array();
}
$i = 1;
foreach ($soldes as $scol) {
    if (in_array($scol['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }
    $corps .= '<tr><td width="5%">' . $i . '</td><td width ="10%" style = "border-bottom:1px solid #000">' . $scol['MATRICULE'] . '</td>'
            . '<td width ="40%" style = "border-bottom:1px solid #000">' . $scol['NOM'] . ' ' . $scol['PRENOM'] . '</td>'
            . '<td align="center" width ="10%"  style = "border-bottom:1px solid #000">' . $redoublant . '</td>'
            . '<td align="right" width ="15%"  style = "border-bottom:1px solid #000">' .
            moneyString($scol['MONTANTPAYE']). '</td>';

    $corps .= '<td align="right" width ="15%"  style = "border-bottom:1px solid #000">' .
             moneyString($scol['MONTANTPAYE'] - $montanfraisapplicable) . '</td>';

    if ($scol['MONTANTPAYE'] >= $montanfraisapplicable) {
        $corps .= '<td width ="7%" style="background-color:#99ff99;text-align:center;border-bottom:1px solid #000">#C#</td>';
    } else {
        $corps .= '<td width ="7%" style="background-color:#ff9999;text-align:center;border-bottom:1px solid #000">#D#</td>';
    }
    $corps .= '</tr>';
    $i++;
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 9);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '  ');

$pdf->WriteHTMLCell(0, 5, 10, $y + 35, $corps);

$pdf->Output();
