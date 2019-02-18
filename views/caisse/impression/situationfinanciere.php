<?php

$y = PDF_Y;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
if($type === "credit"){
    $txtadd = 'CREDITEURS';
}else{
    $txtadd = 'DEBITEURS';
}
$pdf->WriteHTMLCell(0, 30, 70, $y - 10, '<p>SITUATION DES ELEVES '.$txtadd.'</p>');
$d = new DateFR();
$pdf->WriteHTMLCell(0, 30, 85, $y, '<b>Situation du : ' . $d->getDate() . "-" . $d->getMois(3) . "-" . $d->getYear() . "</b>");
$cols = [5, 10, 45, 10, 10, 10];
//Corps du PDF
$corps = '<table border = "1" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width="' . $cols[0] . '%">N°</th><th width ="' . $cols[1] . '%">Mle</th>'
        . '<th width ="' . $cols[2] . '%">Noms & Pr&eacute;noms</th>
        <th width ="' . $cols[3] . '%">Classes.</th>'
        . '  <th width ="' . $cols[3] . '%">Total Frais</th>'
        . '<th width ="' . $cols[4] . '%">Total pay&eacute;</th>
            <th  width ="' . $cols[5] . '%" align="center">Reste</th></tr></thead><tbody>';
$i = 1;
$applicables = getMontantFraisApplicable($montantfraisapplicable);

foreach ($soldes as $scol) {
    $condition = ($scol['MONTANTPAYE'] < $applicables[$scol['IDCLASSE']]);
    if ($type === "credit") {
        $condition = (!$condition);
    }
    if ($condition) {
        $corps .= '<tr><td width="' . $cols[0] . '%">' . $i . '</td>'
                . '<td width ="' . $cols[1] . '%" >' . $scol['MATRICULE'] . '</td>'
                . '<td width ="' . $cols[2] . '%" >' . $scol['NOM'] . ' ' . $scol['PRENOM'] . '</td>'
                . '<td width ="' . $cols[3] . '%" >' . $scol['NIVEAUHTML'] . '</td>'
                . '<td width ="' . $cols[3] . '%" align="right" >' . moneyString($applicables[$scol['IDCLASSE']]) . '</td>'
                . '<td width ="' . $cols[4] . '%" align="right" >' . moneyString($scol['MONTANTPAYE']) . '</td>';

        $corps .= '<td width ="' . $cols[5] . '%" align="right">' .
                moneyString($scol['MONTANTPAYE'] - $applicables[$scol['IDCLASSE']]) . '</td>';
        $corps .= '</tr>';
        $i++;
    }
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 8);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '  ');

$pdf->WriteHTMLCell(0, 5, 20, $y + 10, $corps);

$pdf->Output();

function getMontantFraisApplicable($montantfraisapplicable) {
    $applicable = array();
    foreach ($montantfraisapplicable as $montant) {
        $applicable[$montant['CLASSE']] = $montant['MONTANTAPPLICABLE'];
    }
    return $applicable;
}
