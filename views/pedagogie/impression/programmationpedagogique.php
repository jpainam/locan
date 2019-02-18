<?php

$pdf->isLandscape = true;
$pdf->setPageOrientation('L');
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$y = FIRST_TITLE;
$x = 5;
//nbChapitres($idactivite, $chapitres);
//var_dump($enseignement);
/* foreach($chapitres as $chap){ 
  $nligne=nbChapitres($chap['IDACTIVITE'],$chapitres);
  echo  $nligne;
  echo '<br/>';
  var_dump($chap);
  rowspan='.$nb.'
  } */

$corps = '<table border="1"  style="text-align:center" cellpadding="2">
    <thead><tr><th border="0.5">Activit&eacute;s</th><th border="0.5">Chapitres</th><th border="0.5">S&eacute;quences</th></tr></thead>
    <tbody>';

$previous = 0;

foreach ($chapitres as $chap) {
    $corps .= "<tr>";

    if ($previous != $chap['ACTIVITE']) {
        $nb = nbChapitres($chap['ACTIVITE'], $chapitres);
        $corps .= '<td rowspan="' . $nb . '"  border="0.5">' . $chap['TITREACTIVITE'] . ' </td>';
    }
    $previous = $chap['ACTIVITE'];
    $corps .='<td border="0.5">' . $chap['TITRECHAPITRE'] . '</td><td  border="0.5">' . $chap['TITRESEQUENCE'] . '</td>';
    $corps .= "</tr>";
}

$corps .= '</tbody></table>';

$pdf->WriteHTMLCell(0, 0, $x + 5, $y + 40, $corps);
$pdf->Output();
