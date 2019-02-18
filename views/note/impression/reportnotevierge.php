<?php
#Fiche de report de note vierge
# accessible grace a note/saisie
# code d'impression 0001
$y = FIRST_TITLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF

$titre = '<p style = "text-decoration:underline">FICHE DE REPORT DE NOTES ' . $anneescolaire . '</p>';
$pdf->WriteHTMLCell(0, 50, 60, $y, $titre);


$pdf->SetFont("Times", "", 10);
$titre = '<p>CLASSE  : <i>' . $classe['NIVEAUHTML'].' '.$classe['LIBELLE']."</i></p>";
$pdf->WriteHTMLCell(0, 5, 15, $y + 15, $titre);

$enseignant = '<p>Enseignant  : <i>'.$enseignement['NOM'].' '.$enseignement['PRENOM']."</i></p>";
$pdf->WriteHTMLCell(0, 5, 120, $y + 15, $enseignant);

$pdf->WriteHTMLCell(0, 5, 15, $y + 20, '<p>Date : .....</p>');

$matiere = '<p>Mati&egrave;re : <i>'.$enseignement['MATIERELIBELLE'].'</i></p>';
$pdf->WriteHTMLCell(0, 5, 120, $y + 20, $matiere);

$libelle = '<p>Libell&eacute; du devoir : .....</p>';
$pdf->WriteHTMLCell(0, 5, 15, $y + 25, $libelle);

$pdf->WriteHTMLCell(0, 5, 120, $y + 25, '<p>Coefficient : <i>'.$enseignement['COEFF'].'</i></p>');

$pdf->WriteHTMLCell(0, 5, 15, $y + 30, '<p>Note sur : .....</p>');

$pdf->WriteHTMLCell(0, 5, 120, $y + 30, '<p>P&eacute;riode : .....</p>');

$pdf->SetFont("Times", '', 10);

$corps = '<table cellpadding = "2"><thead ><tr border="0.5" style="font-weight:bold"><th width="5%" border="0.5">N°</th>'
        . '<th border="0.5"width="50%">Noms et Pr&eacute;noms</th>';
$corps .= '<th width="10%" border="0.5">Note</th><th width="10%" border="0.5">Absent</th>'
        . '<th width="25%" border="0.5">Observations</th></tr></thead><tbody>';
$i = 1;
foreach($eleves as $el){
    $corps .= '<tr><td width="5%" border="0.5">'.$i.'</td>'
            . '<td width="50%" border="0.5">'.$el['NOM'].' '.$el['PRENOM'].'</td>'
            . '<td width="10%" border="0.5"></td><td width="10%" border="0.5"></td>'
            . '<td width="25%" border="0.5"></td></tr>';
    $i++;
}
$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, 15, $y + 40, $corps);

$pdf->Output();
