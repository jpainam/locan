<?php
$y = FIRST_TITLE;
$pdf->AddPage();
//Titre du PDF
$titre = '<p style = "text-decoration:underline">FICHE DU PERSONNEL</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

$pdf->SetFont("helvetica", "B", 12);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 10);
$pdf->Cell(60, 4, "I-IDENTITE", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 12);

$d = new DateFR($personnel['DATENAISS']);
$corps = '<table border = "0" cellpadding = "5" style = "width:350px">';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Civilite</td><td style = "border-bottom:1px solid #000000">' . $personnel['CIVILITE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Nom </td><td style = "border-bottom:1px solid #000000">' . $personnel['NOM'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Pr&eacute;nom</td><td style = "border-bottom:1px solid #000000">' . $personnel['PRENOM'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Autre Noms</td><td  style = "border-bottom:1px solid #000000">' . $personnel['AUTRENOM'] . "</td></tr>";
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Date de naissance</td><td  style = "border-bottom:1px solid #000000">' . $d->getDate() . " " . $d->getMois(0) . " " . $d->getYear() . "</td></tr>";
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Grade</td><td  style = "border-bottom:1px solid #000000">' . $personnel['GRADE'] . "</td></tr>";
$corps .= '</table>';
//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 20, $y + 15, $corps);
//Matricule
$pdf->WriteHTMLCell(50, 10, 159, $y + 10, '<b>Matricule : ' . $personnel['MATRICULE'] . '</b>', 0, 2);
if (!empty($personnel['PHOTO'])) {
    $photo = SITE_ROOT . "public/photos/personnels/" . $personnel['PHOTO'];
    $pdf->Image($photo, 160, 62, 40, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
} else {
    $pdf->WriteHTMLCell(30, 25, 160, $y + 22, '<br/><br/><br/>PHOTO', 1, 2, false, true, 'C');
}
$pdf->SetFont("helvetica", "B", 12);
$pdf->SetFillColor(225, 196, 196);
$pdf->SetXY(10, $y + 70);
$pdf->Cell(60, 4, "II-ADRESSES", 0, 2, 'L', 1);
$pdf->Ln(2);
$pdf->SetFont("Times", '', 13);

$corps = '<table border = "0" cellpadding = "5">';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Portable </td><td style = "border-bottom:1px solid #000000">' . 
        $personnel['PORTABLE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">T&eacute;l&eacute;phone</td><td style = "border-bottom:1px solid #000000">' . 
        $personnel['TELEPHONE'] . '</td></tr>';
$corps .= '<tr><td style = "border-bottom:1px solid #000000">Email </td><td style = "border-bottom:1px solid #000000">' . 
        $personnel['EMAIL'] . '</td></tr>';
$corps .= '</table>';

//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 20, $y + 75, $corps);

$pdf->Output();
