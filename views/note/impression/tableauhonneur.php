<?php

#Fiche de report de note vierge
# accessible grace a note/saisie
# code d'impression 0001
$y = PDF_Y;
$x = PDF_X;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF
$middle = PDF_MIDDLE;
$titre = '<p style = "text-decoration:underline">TABLEAU D\'HONNEUR</p>';
$pdf->WriteHTMLCell(0, 50, $middle - 20, $y - 5, $titre);


$pdf->SetFont("Times", "", 10);
$titre = '<p>CLASSE  : <i>' . $classe['NIVEAUHTML'] . "</i></p>";
$pdf->WriteHTMLCell(0, 0, $middle + 30, $y, $titre);

if($codeperiode === "S"){
    $pdf->WriteHTMLCell(0, 0, $middle - 40, $y, 'SEQUENCE N° : '. $sequence['SEQUENCEORDRE']);
}else{
    $pdf->WriteHTMLCell(0, 0, $middle - 40, $y, 'TRIMESTRE N° : '. $trimestre['ORDRE']);
}

$pdf->SetFont("Times", "", 8);
$col = [5, 8, 30, 17, 9, 15, 20];
$corps = '<table cellpadding="2"><thead><tr style="text-align:center;font-weight:bold;"><th border="1" width="' . $col[0] . '%">N°</th>'
        . '<th border="1" width="' . $col[1] . '%">Matricule</th>'
        . '<th border="1" width="' . $col[2] . '%">Noms et Pr&eacute;noms</th>'
        . '<th border="1" width="' . $col[3] . '%">Date/LieuNaiss</th>'
        . '<th border="1" width="' . $col[4] . '%">Redouble</th>'
        . '<th border="1" width="' . $col[5] . '%">Moyenne(>12)</th>'
        . '<th border="1" width="' . $col[6] . '%">Observation</th></tr></thead><tbody>';
$i = 1;
$array_of_redoublants = is_null($array_of_redoublants) ? array() : $array_of_redoublants;
foreach ($rangs as $rang) {
    if ($rang['MOYGENERALE'] >= 12) {

        $corps .= '<tr><td border="1" width="' . $col[0] . '%">' . $i . '</td>'
                . '<td border="1" width="' . $col[1] . '%">' . $rang['MATRICULEEL'] . '</td>'
                . '<td border="1" width="' . $col[2] . '%">' . $rang['NOMEL'] . ' ' . $rang['PRENOMEL'] . '</td>'
                . '<td border="1" width="' . $col[3] . '%">' . date("d/m/Y", strtotime($rang['DATENAISSEL'])) . '/' . $rang['LIEUNAISSEL'] . '</td>';
        if (in_array($rang['IDELEVE'], $array_of_redoublants)) {
            $redouble = "OUI";
        } else {
            $redouble = "NON";
        }
        $corps .= '<td border="1" width="' . $col[4] . '%" align="center">' . $redouble . '</td>'
                . '<td border="1" width="' . $col[5] . '%" align="center">' . sprintf("%.2f", $rang['MOYGENERALE']) . '</td>'
                . '<td border="1" width="' . $col[6] . '%">' . getMentions($rang['MOYGENERALE']) . '</td></tr>';
        $i++;
    }
}
$corps .= '</table>';
$pdf->WriteHTMLCell(0, 0, $x, $y + 10, $corps);
$pdf->Output();
