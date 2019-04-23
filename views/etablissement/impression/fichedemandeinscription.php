<?php

$pdf->bCertify = false;
$pdf->SetPrintFooter(false);
$y = FIRST_TITLE;
$pdf->AddPage();
$col = array();
$col[0] = 0;
$col[1] = 40;
$col[2] = 60;
$pdf->setFont("Times", '', 13);

$titre = '<p style="text-align:center"><b>FICHE DE DEMANDE D\'INSCRIPTION<br/>Ann&eacute;e scolaire ' . 
        $anneescolaire . "</b></p>";
$pdf->WriteHTMLCell(0, 5, 30, $y, $titre);
$pdf->WriteHTMLCell(0, 5, 11, $y + 20, '<b style="text-decoration:underline">Informations de l\'&eacute;l&egrave;ve</b>');
$pdf->WriteHTMLCell(0, 5, 85, 60, '<b>Classe: </b>');

$corps = '<table cellpadding="2">';
$corps .= '<tr><td width="' . $col[1] . '%">Nom de l\'&eacute;l&egrave;ve </td><td>: </td></tr>'
        . '<tr><td width="' . $col[1] . '%">Pr&eacute;nom (s) de l\'&eacute;l&egrave;ve </td><td>:</td></tr>'
        . '<tr><td width="' . $col[1] . '%">Date et lieu de naissance </td>'
        . '<td>: </td></tr>'
        . '<tr><td width="' . $col[1] . '%">Sexe </td><td>: </td></tr>'
        . '<tr><td width="' . $col[1] . '%">Etablissement de l\'ann&eacute;e pr&eacute;c&eacute;dente '
        . '</td><td>:</td></tr>';
$corps .= "</table>";
$pdf->WriteHTMLCell(0, 5, 10, $y + 25, $corps);

# Parents;
$pdf->WriteHTMLCell(0, 5, 11, $y + 65, '<b style="text-decoration:underline">'
        . 'Informations des parents</b>');
$corps = '<table cellpadding="2">';
for ($i = 0; $i < 2; $i++) {
    $corps .= '<tr><td width="' . $col[1] . '%">Nom(s) et pr&eacute;nom</td><td>:</td></tr>'
            . '<tr><td width="' . $col[1] . '%">Parent&eacute; </td><td>: </td></tr>'
            . '<tr><td width="' . $col[1] . '%">Profession </td><td>: </td></tr>'
            . '<tr><td width="' . $col[1] . '%">Adresse </td><td>: </td></tr>'
            . '<tr><td width="' . $col[1] . '%">Email </td><td>:</td></tr>'
            . '<tr><td colspan="2"></td></tr>';
}
$corps .= "</table>";
$pdf->WriteHTMLCell(0, 5, 10, $y + 70, $corps);

# Autres informations
$pdf->WriteHTMLCell(0, 5, 11, $y + 150, '<b style="text-decoration:underline">Autres Informations</b>');
$corps = '<table cellpadding="2">'
        . '<tr><td>Lieu de r&eacute;sidence : </td><td></td></tr>'
        . '<tr><td>Fr&egrave;res et s&oelig;urs &agrave; ici inscrits : </td><td></td></tr>';
$corps .= '</table>';
$pdf->WriteHTMLCell(0, 5, 11, $y + 155, $corps);

$pdf->WriteHTMLCell(0, 5, 11, $y + 175, '<b>Ancien: </b>');
$pdf->WriteHTMLCell(0, 5, 11, $y + 180, '<b>Nouveau: </b>');
$pdf->WriteHTMLCell(0, 5, 130, $y + 190, 'Douala; le : ');
$pdf->WriteHTMLCell(0, 5, 130, $y + 210, '<b>Visa de la Directrice</b>');
$pdf->WriteHTMLCell(0, 5, 11, $y + 210, '<b>Signature du bureau des inscriptions</b>');

$pdf->Output();

