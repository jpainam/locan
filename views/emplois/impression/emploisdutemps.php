<?php

$y = PDF_Y;
$pdf->AddPage();
$pdf->SetPrintHeader(false);

$pdf->WriteHTMLCell(0, 30, 30, $y - 10, '<p style="text-align:center">EMPLOIS DU TEMPS <br/>' . $classe['NIVEAUHTML'] . '</p>');
$d = new DateFR();
$cols = [12, 15];
//Corps du PDF
$corps = '<table border = "1" cellpadding = "5"><thead><tr style = "font-weight:bold">
        <th align="center" width="' . $cols[0] . '%">Horaire</th>'
        . '<th align="center" width ="' . $cols[1] . '%">Lundi</th>'
        . '<th align="center" width ="' . $cols[1] . '%">Mardi</th>
        <th align="center" width ="' . $cols[1] . '%">Mercredi</th>'
        . '  <th align="center" width ="' . $cols[1] . '%">Jeudi</th>'
        . '<th align="center" width ="' . $cols[1] . '%">Vendredi</th>
            <th align="center" width ="' . $cols[1] . '%">Samedi</th></tr></thead><tbody>';

# Lundi = 1 ... Dimanche = 7
foreach ($horaires as $hor) {
    $ligne = getEmploiHoraire($hor['IDHORAIRE'], $enseignements);
    $str = '<tr><td align="center" width="' . $cols[0] . '%">' . 
            substr($hor['HEUREDEBUT'], 0, 5).'-'.substr($hor['HEUREFIN'], 0, 5) . '</td>';
    for ($i = 1; $i < 7; $i++) {
        $lg = getEmploiJour($i, $ligne);
        if($lg){
            $str .= '<td align="center" width ="' . $cols[1] . '%">' . $lg['LIBELLE'] . '</td>';
        } else {
            $str .= '<td width ="' . $cols[1] . '%"></td>';
        }
    }
    $str .= '</tr>';
    $corps .= $str;
}

$pdf->SetFont("helvetica", '', 8);

$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, 20, $y + 10, $corps);

$pdf->Output();

function getEmploiJour($idjour, $uneligne){
    foreach($uneligne as $lg){
        if($lg['JOUR'] == $idjour){
            return $lg;
        }
    }
    return null;
}
function getEmploiHoraire($idhoraire, $tousemplois) {
    $result = [];
    foreach ($tousemplois as $tt) {
        if ($tt['HORAIRE'] == $idhoraire) {
            $result[] = $tt;
        }
    }
    usort($result, function($a, $b) {
        if ($a["JOUR"] === $b["JOUR"]) {
            return 0;
        } else {
            return $a["JOUR"] < $b['JOUR'] ? -1 : 1;
        }
    });
    return $result;
}
