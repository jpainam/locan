<?php
$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

//$pdf->SetPrintFooter(false);

//Titre du PDF
$titre = '<p style = "text-decoration:underline">LISTE DU PERSONNELS DE L\'ETABLISSEMENT</p>';
$pdf->WriteHTMLCell(0, 50, 65, $y, $titre);

//Corps du PDF
$corps = <<<EOD
        <table border = "0" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th width ="10%">Civ.</th><th width ="50%">Noms & Pr&eacute;noms</th>
        <th width ="20%">Fonction</th><th width ="20%">T&eacute;l&eacute;phone</th></tr></thead><tbody>
EOD;
foreach ($personnels as $p) {
    $corps .= '<tr><td width ="10%" style = "border-bottom:1px solid #000">' . $p['CIVILITE'] . '</td>'
            . '<td width ="50%" style = "border-bottom:1px solid #000">' . $p['NOM'] . ' ' . $p['PRENOM'] . '</td>'
            . '<td width ="20%"  style = "border-bottom:1px solid #000">' . $p['LIBELLE']. '</td>'
            . '<td width ="20%"  style = "border-bottom:1px solid #000">' . $p['PORTABLE'] . '</td></tr>';
}
$corps .= "</tbody></table>";
$pdf->SetFont("Times", '', 13);

//Impression du tableau
//$pdf->writeHTML($corps, true, false, false, false, '');

$pdf->WriteHTMLCell(0, 5, 10, $y + 15, $corps);

$pdf->Output();