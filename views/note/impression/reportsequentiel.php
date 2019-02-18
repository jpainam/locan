<?php

$y = PDF_Y;
$pdf->AddPage();
$pdf->SetPrintHeader(false);


$classe = $classe['NIVEAUHTML'];
$col = [5, 35, 5, 7, 7, 18, 5, 8];
$corps = <<<EOD
        <table border = "0" cellpadding = "5" style="text-align:center;line-height:7px;"><thead>
        <tr style = "font-weight:bold;" ><th colspan="13" style="font-size:13px" >LISTE DES ELEVES</th></tr>
        <tr style = "font-weight:bold"  ><th colspan="3">CLASSE  : $classe </th><th colspan="8"></th>
            <th colspan="3">Coef : .................</th></tr>
       <tr style = "font-weight:bold"  ><th colspan="2"></th><th colspan="11" style="font-size:10px">   
           Discipline + Nom de l'enseignant : ........................................................................................</th>
               <th><br/><br/><br/><br/></th></tr>
        <tr style = "font-weight:bold"  >
        <th border="0.5" width ="$col[0]%" rowspan="2">N°</th>
        <th border="0.5" width ="$col[1]%" rowspan="2">Noms & Pr&eacute;noms</th>
        <th border="0.5" width ="$col[2]%" rowspan="2">Sexe</th>
        <th border="0.5" width ="$col[3]%" rowspan="2" style="font-size:5px">Redoublant</th>
        <th border="0.5" colspan="3" width ="$col[5]%" >TRIM1</th>
        <th border="0.5" colspan="3" width ="$col[5]%">TRIM2</th>
        <th border="0.5" colspan="3" width ="$col[5]%">TRIM3</th>
       </tr>
       <tr style = "font-weight:bold">
         
          <th border="0.5" width ="$col[6]%" style="font-size:5px">SEQ1</th>
          <th border="0.5" width ="$col[6]%" style="font-size:5px">SEQ2</th>
            <th border="0.5" width ="$col[7]%" style="font-size:5px">SEQ1 + SEQ2</th>
          <th border="0.5" width ="$col[6]%" style="font-size:5px">SEQ3</th>
          <th border="0.5" width ="$col[6]%" style="font-size:5px">SEQ4</th>
            <th border="0.5" width ="$col[7]%" style="font-size:5px">SEQ3 + SEQ4</th>
          <th border="0.5" width ="$col[6]%" style="font-size:5px">SEQ5</th>
          <th border="0.5" width ="$col[6]%" style="font-size:5px">SEQ6</th>
         <th border="0.5" width ="$col[7]%" style="font-size:5px">SEQ5 + SEQ6</th>
       </tr>
         </thead><tbody>
EOD;
$i = 1;
$array_of_redoublants = is_null($array_of_redoublants) ? array() : $array_of_redoublants;
foreach ($eleves as $el) {
    $d = new DateFR($el['DATENAISS']);
    $corps .= '<tr>'
            . '<td width ="' . $col[0] . '%" border="0.5">' . $i . '</td>'
            . '<td width ="' . $col[1] . '%" border="0.5" align="left">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>'
            . '<td width ="' . $col[2] . '%" border="0.5">' . $el['SEXE'] . '</td>';
    $situ = "Non";
    if (in_array($el['IDELEVE'], $array_of_redoublants)) {
        $situ = "Oui";
    }
    /* $nbInscr = getNBInscription($nbInscriptions, $el['IDELEVE']);
      if ($nbInscr['NBINSCRIPTION'] <= 1) {
      if ($el['PROVENANCE'] == ETS_ORIGINE) {
      $situ .= "A";
      } else {
      $situ .= "N";
      }
      } else {
      $situ .= "A";
      } */

    $corps .= '<td width ="' . $col[3] . '%" border="0.5">' . $situ . '</td>';

    $corps .= '<td  border="0.5" width ="' . $col[6] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[6] . '%"></td>'
            . '<td border="0.5" width ="' . $col[7] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[6] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[6] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[7] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[6] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[6] . '%"></td>'
            . '<td  border="0.5" width ="' . $col[7] . '%"></td></tr>';
    $i++;
}
$corps .= "</tbody></table>";

$pdf->SetFont("Times", "", 8);
$pdf->WriteHTMLCell(0, 5, 5, $y, $corps);

$pdf->Output();

function getNBInscription($nbInscriptions, $ideleve) {
    foreach ($nbInscriptions as $nbInscr) {
        if ($nbInscr['IDELEVE'] === $ideleve) {
            return $nbInscr;
        }
    }
    return null;
}
