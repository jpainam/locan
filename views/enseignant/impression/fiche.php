<?php
$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF
$titre = '<p style = "text-decoration:underline">FICHE DE L\'ENSEIGNANT</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

$pdf->SetFont("helvetica", "B", 12);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 10);
$pdf->Cell(60, 4, "I-IDENTITE", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 8);

$d = new DateFR($personnel['DATENAISS']);
$corps = '<table border = "0" cellpadding = "5" style = "width:400px;line-height: 8px">';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Civilite : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['CIVILITE'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Matricule : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['MATRICULE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Nom : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['NOM'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Pr&eacute;noms : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['PRENOM'] . ' ' . $personnel['AUTRENOM'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Fonction : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['FK_FONCTION'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Grade</td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['GRADE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Sexe</td>';
if ($personnel['SEXE'] == "M") {
    $sexe = "Masculin";
} else {
    $sexe = "F&eacute;minin";
}
$corps .= '<td style = "border-bottom:1px solid #000000">' . $sexe . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Date de Naiss.</td>';
$d = new DateFR($personnel['DATENAISS']);
$datenaiss = "";
if (!empty($personnel['DATENAISS']) && $personnel['DATENAISS'] !== '0000-00-00') {
    $datenaiss = $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear();
}
$corps .= '<td style = "border-bottom:1px solid #000000">' . $datenaiss . '</td></tr>';

$corps .= '<tr><td style = "border-bottom:1px solid #000000">Portable : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['PORTABLE'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">T&eacute;l&eacute;phone : </td>'
        . '<td  style = "border-bottom:1px solid #000000">' . $personnel['TELEPHONE'] . "</td></tr>";

$corps .= '<tr><td style = "border-bottom:1px solid #000000">Email : </td>'
        . '<td  style = "border-bottom:1px solid #000000">' . $personnel['EMAIL'] . '</td>
            <td style = "border-bottom:1px solid #000000">Dipl&ocirc;me : </td>
            <td style = "border-bottom:1px solid #000000">' . $personnel['FK_DIPLOME'] . '</td></tr>';
$corps .= '</table>';
//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 10, $y + 15, $corps);
//Matricule
$pdf->WriteHTMLCell(50, 10, 159, $y + 10, '<b>Matricule : ' . $personnel['MATRICULE'] . '</b>', 0, 2);
if (!empty($personnel['PHOTO'])) {
    $photo = SITE_ROOT . "public/photos/personnels/" . $personnel['PHOTO'];
    $pdf->Image($photo, 160, 62, 40, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
} else {
    $pdf->WriteHTMLCell(30, 25, 160, $y + 22, '<br/><br/><br/>PHOTO', 1, 2, false, true, 'C');
}
$pdf->SetFont("helvetica", "B", 10);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 57);
$pdf->Cell(60, 4, "II-AUTRES INFORMATIONS", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 8);

$corps = '<table border = "0" cellpadding = "3" style = "line-height: 8px">';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Si&egrave;ge: </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['SIEGE'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000"></td>'
        . '<td style = "border-bottom:1px solid #000000"></td></tr>';

$corps .= '<tr><td style = "border-bottom:1px solid #000000">Cat&eacute;gorie : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['FK_CATEGORIE'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Sit. Indemnitaire : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['INDEMNITAIRE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Ind. Solde : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['SOLDE'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Ind. Carri&egrave;re : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['CARRIERE'] . '</td></tr>';

$corps .= '<tr><td style = "border-bottom:1px solid #000000">Texte Nominatif : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['NOMINATIF'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">Echelon : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['ECHELON'] . '</td></tr>';

$corps .= '<tr><td style = "border-bottom:1px solid #000000">Statut : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['FK_STATUT'] . '</td>'
        . '<td style = "border-bottom:1px solid #000000">DMR/AMR : </td>'
        . '<td style = "border-bottom:1px solid #000000">' . $personnel['DMR'] . '</td></tr>';
$d->setSource($personnel['AVANCEMENT']);
$avancement = "";
if(!empty($personnel['AVANCEMENT']) && $personnel['AVANCEMENT'] !== '0000-00-00'){
    $avancement = $d->getDate()." ".$d->getMois(3)." ".$d->getYear();
}
$corps .= '<tr><td colspan="2" style = "border-bottom:1px solid #000000">Date dernier avancement : </td>'
        . '<td style = "border-bottom:1px solid #000000">'.$avancement.'</td>'
        . '<td style = "border-bottom:1px solid #000000"></td></tr>';

$corps .= '<tr><td colspan="4" style = "border-bottom:1px solid #000000">Structure : '. $personnel['FK_STRUCTURE'] . '</td></tr>';

$corps .= '<tr><td colspan="4" style = "border-bottom:1px solid #000000">'
        . 'R&eacute;gion : ' . $personnel['FK_REGION']
        . '/ D&eacute;partement : '.$personnel['FK_DEPARTEMENT']
        . '/ Arrondissement : '.$personnel['FK_ARRONDISSEMENT'].'</td></tr>';
$corps .= '</table>';

//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 10, $y + 62, $corps);

$pdf->SetFont("helvetica", "B", 10);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 105);
$pdf->Cell(60, 4, "III-MATIERES ENSEIGNEES", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 8);

$corps = '<table border = "0.5" cellpadding = "3" style = "line-height: 8px">'
        . '<thead><tr style="font-weight:bold">'
        . '<th width="15%">Classes</th><th width="75%">Mati&egrave;res</th><th width="10%">Coeff.</th></tr></thead><tbody>';
foreach ($enseignements as $ens) {
    $corps .= '<tr><td width="15%">' . $ens['NIVEAUHTML'] . '</td><td width="75%">' . $ens['MATIERELIBELLE'] . '</td>'
            . '<td width="10%" align="right">' . $ens['COEFF'] . '</td></tr>';
}

$corps .= '</tbody></table>';

$pdf->WriteHTMLCell(0, 5, 10, $y + 115, $corps);
$pdf->Output();
