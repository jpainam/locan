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

$titre = '<p style="text-align:center"><b>FICHE DE DEMANDE D\'INSCRIPTION<br/>Ann&eacute;e scolaire ' . $anneescolaire . "</b></p>";
$pdf->WriteHTMLCell(0, 5, 30, $y, $titre);
$pdf->WriteHTMLCell(0, 5, 11, $y + 20, '<b style="text-decoration:underline">Informations de l\'&eacute;l&egrave;ve</b>');
if(isset($classe['LIBELLE'])){
    $pdf->WriteHTMLCell(0, 5, 85, 60, '<b>Classe: ' .  $classe['NIVEAUHTML']. ' '. $classe['LIBELLE'] . '</b>');
}else{
    $pdf->WriteHTMLCell(0, 5, 85, 60, '<b>Classe: </b>');
}

$d = new DateFR($eleve['DATENAISS']);
$corps = '<table cellpadding="2">';
$corps .= '<tr><td width="' . $col[1] . '%">Nom de l\'&eacute;l&egrave;ve </td><td>: ' . $eleve['NOM'] . '</td></tr>'
        . '<tr><td width="' . $col[1] . '%">Pr&eacute;nom (s) de l\'&eacute;l&egrave;ve </td><td>: ' . $eleve['PRENOM'] . '</td></tr>'
        . '<tr><td width="' . $col[1] . '%">Date et lieu de naissance </td>'
        . '<td>: ' . $d->getJour(3) . ' ' . $d->getDate() . " " . $d->getMois() . " " . $d->getYear() . ' ' . $eleve['LIEUNAISS'] . '</td></tr>'
        . '<tr><td width="' . $col[1] . '%">Sexe </td><td>: ' . ($eleve['SEXE'] == "M" ? "Masculin" : "F&eacute;min") . '</td></tr>'
        . '<tr><td width="' . $col[1] . '%">Etablissement de l\'ann&eacute;e pr&eacute;c&eacute;dente </td>'
        . '<td>: ' . $eleve['FK_PROVENANCE'] . '</td></tr>';
$corps .= "</table>";
$pdf->WriteHTMLCell(0, 5, 10, $y + 25, $corps);

# Parents;
$pdf->WriteHTMLCell(0, 5, 11, $y + 65, '<b style="text-decoration:underline">Informations des parents</b>');
$corps = '<table cellpadding="2">';
foreach ($responsables as $resp) {
    $corps .= '<tr><td width="' . $col[1] . '%">Nom(s) et pr&eacute;nom</td><td>: ' . $resp['NOM'] . ' ' . $resp['PRENOM'] . '</td></tr>'
            . '<tr><td width="' . $col[1] . '%">Parent&eacute; </td><td>: ' . $resp['PARENTE'] . '</td></tr>'
            . '<tr><td width="' . $col[1] . '%">Profession </td><td>: ' . $resp['PROFESSION'] . '</td></tr>'
            . '<tr><td width="' . $col[1] . '%">Adresse </td><td>: ' . $resp['ADRESSE'] . '</td></tr>'
            . '<tr><td width="' . $col[1] . '%">Email </td><td>: ' . $resp['EMAIL'] . '</td></tr>'
            . '<tr><td colspan="2"></td></tr>';
}
$corps .= "</table>";
$pdf->WriteHTMLCell(0, 5, 10, $y + 70, $corps);

# Autres informations
$pdf->WriteHTMLCell(0, 5, 11, $y + 150, '<b style="text-decoration:underline">Autres Informations</b>');
$corps = '<table cellpadding="2">'
        . '<tr><td>Lieu de r&eacute;sidence : </td><td>'.$eleve['RESIDENCE'].'</td></tr>'
        . '<tr><td>Fr&egrave;res et s&oelig;urs &agrave; IPW : </td><td>'.$eleve['FRERESOEUR'].'</td></tr>';
$corps .= '</table>';
$pdf->WriteHTMLCell(0, 5, 11, $y + 155, $corps);


if($eleve['PROVENANCE'] == ETS_ORIGINE){
    $pdf->WriteHTMLCell(0, 5, 11, $y + 175, '<b>Ancien &agrave; l\'IPW</b>');
}else{
    $pdf->WriteHTMLCell(0, 5, 11, $y + 175, '<b>Nouveau &agrave; l\'IPW</b>');
}
$pdf->WriteHTMLCell(0, 5, 130, $y + 190, 'Yaound&eacute; le : '.$d->getDate()." ".$d->getMois(3)." ".$d->getYear());
$pdf->WriteHTMLCell(0, 5, 130, $y + 210, '<b>Visa de la Directrice</b>');
$pdf->WriteHTMLCell(0, 5, 11, $y + 210, '<b>Signature du bureau des inscriptions</b>');
$d->setSource(date("Y-m-d", time()));

$pdf->Output();
