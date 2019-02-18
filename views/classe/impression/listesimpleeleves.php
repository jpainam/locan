<?php

$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

//$pdf->SetPrintFooter(false);
//Titre du PDF
$titre = '<p>LISTE DES ELEVES DE ' . $classe['NIVEAUHTML'] . ' ' . $classe['LIBELLE'] . '</p>';
$pdf->WriteHTMLCell(0, 50, 65, $y, $titre);

//Corps du PDF
$corps = <<<EOD
        <table border = "0" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width="5%">N°</th><th width ="10%">Mle</th><th width ="55%">Noms & Pr&eacute;noms</th>
        <th width ="15%">Date Naiss.</th><th align="center" width ="15%">Redoublant</th></tr></thead><tbody>
EOD;
if (!is_array($array_of_redoublants)) {
    $array_of_redoublants = array();
}
$i = 1;
foreach ($eleves as $el) {
    if (in_array($el['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }
    $d = new DateFR($el['DATENAISS']);
	$corps .= '<tr><td width ="5%" border="1">' . $i . '</td>'
            . '<td width ="10%" border="1">' . $el['MATRICULE'] . '</td>'
            . '<td width ="55%" border="1">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>'
            . '<td width ="15%"  border="1">' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . '</td>'
            . '<td width ="20%"  border="1">' . $redoublant. '</td></tr>';
    $i++;
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 10);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '');

$pdf->WriteHTMLCell(0, 5, 10, $y + 10, $corps);

$pdf->Output();
