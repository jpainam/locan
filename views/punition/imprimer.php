<?php
function basicTable($punition){
    $str =  '<table border = "1"><tr><td>'.$punition['DESCRIPTION'].'</td>';
    $str .= "<td>".$punition['NOM']."</td></tr>";
    $str .= "<tr><td>".$punition['PRENOM']."</td><td>".print_r($punition, true)."</td></tr></table>";
    return $str;
    
}
$pdf->SetTitle('Impression de la punition');
$pdf->SetSubject('Punition IPW');
$pdf->SetKeywords('Puntion, classe, exclusion');
/**
 * 
 */
$pdf->AddPage('P','A4');
$titre =<<<EOD
        <p style="text-decoration:underline"><b>PUNITION</b></p>
EOD;
//Le 1 c'est pour mettre la bordure
$pdf->WriteHTMLCell(30, 10, 100, 40, $titre, 1);

/*$pdf->SetXY(120, 40);
$pdf->Write(12, "PUNITION");*/
$pdf->setFontSize(5);
$val = print_r($punition, true);
//
$pdf->writeHTMLCell(150, 130, 50, 50, basicTable($punition), 1);
$pdf->Output();