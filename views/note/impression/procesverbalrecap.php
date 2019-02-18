<?php

#Proces vertabl recapitulatf des resultats
# accessible grace a Recapitulatif/index
# code d'impression 0006
$y = PDF_Y;
$pdf->setPageOrientation('L');
$pdf->isLandscape = true;
$middle = PDF_MIDDLE;
$x = PDF_X;
$pdf->bCertify = false;

$pdf->AddPage();
$pdf->SetPrintHeader(false);

$pdf->WriteHTMLCell(0, 0, $middle - 15, $y - 10, '<b>PROCES VERBAL RECAPITULATIF DES RESULTATS</b>');

$tab = trierParGroupe($notes);
$groupe1 = $tab[0];
$groupe2 = $tab[1];
$groupe3 = $tab[2];
//var_dump($groupe1);


$array_of_redoublants = is_null($array_of_redoublants) ? array() : $array_of_redoublants;
$eff = 1;

$prev = -1;

$enseignements = getMatiereDeLaClasse($notes);

usort($enseignements, function($a, $b) {
    if ($a['GROUPE'] === $b['GROUPE']) {
        return $a['ORDRE'] - $b['ORDRE'];
    } else {
        return $a['GROUPE'] - $b['GROUPE'];
    }
});
$taille = 4;
$col = [2, 10, 2, 2, 2];
if (count($enseignements) <= 14) {
    $taille = 6;
    $col = [2, 11, 3, 3, 2];
} elseif (count($enseignements) <= 17) {
    $taille = 5.5;
    $col = [2, 10, 2.5, 2.5, 2.5];
}
$pdf->SetFont("Times", '', $taille);
//enteteRecapitulatif($pdf, $enseignements, $x, $y);



$corps = '<table cellpadding="3"><thead><tr>'
        . '<th width="' . ($col[1] + $col[0]) . '%" border="1" colspan="2">Classe</th>'
        . '<th border="1" width="' . ($col[2] + 1) . '%" >' . $classe['NIVEAUHTML'] . '</th>'
        . '<th border="1" width="' . ($col[3] + 1) . '%"  rowspan="4" align="center">' . writeVerticalText("SEXE/REDOUBLANT") . "</th>";

$prevgroupe = 1;


foreach ($enseignements as $ens) {

    if ($prevgroupe !== $ens['GROUPE']) {
        $corps .= '<th align="center" border="1" rowspan="4" width="' . ($col[2]) . '%"><b>' . writeVerticalText('TOTAL') . '</b></th>'
                . '<th border="1" align="center" rowspan="4" width="' . $col[2] . '%"><b>' . writeVerticalText('MOYENNE GPE') . '</b></th>';
    }

    $prevgroupe = $ens['GROUPE'];
    $ens['BULLETIN'] = preg_replace("%[^\033-\176\r\n\t]%", '', $ens['BULLETIN']);
    $corps .= '<th border="1" width="' . $col[3] . '%" rowspan="4" align="center" style="font-size:8px">'
            . writeVerticalText($ens['BULLETIN']) . '</th>';
}

$corps .= '<th align="center" border="1" rowspan="4" width="' . ($col[2]) . '%"><b>' . writeVerticalText('TOTAL') . '</b></th>'
        . '<th border="1" align="center" rowspan="4" width="' . $col[2] . '%"><b>' . writeVerticalText('MOYENNE GPE') . '</b></th>';


$corps .= '<th border="1" width="' . ($col[2] + 1) . '%" rowspan="4" align="center"><b>' . writeVerticalText('Total Gen.') . '</b></th>'
        . '<th border="1" width="' . ($col[2] + 1) . '%" rowspan="4" align="center"><b>' . writeVerticalText('MOYENNE GEN.') . '</b></th>'
        . '<th border="1" width="' . ($col[2]) . '%" rowspan="4" align="center"><b>' . writeVerticalText("RANG") . '</b></th>';

$taux = getTauxReussite($rangs);
if ($taux[1] === 0) {
    $tauxreussite = 0;
} else {
    $tauxreussite = $taux[0] / $taux[1] * 100;
}
$corps .= '<th border="1" width="' . $col[4] . '%" rowspan="4" align="center"><b>' . writeVerticalText('ABS N.J') . '</b></th>'
        . '<th border="1" width="' . $col[4] . '%" rowspan="4" align="center"><b>' . writeVerticalText('ABS J.') . '</b></th>'
        . '<th border="1" width="' . $col[4] . '%" rowspan="4" align="center"><b>' . writeVerticalText('Consignes') . '</b></th>';
#   . '<th border="1" width="' . $col[2] . '%" rowspan="4" align="center"><b>' . writeVerticalText('NB SOUS MOY.') . '</b></th>'
if ($codeperiode === "S") {
    $libelleseq = $sequence['LIBELLEHTML'];
    $moyclasse =  $travail['MOYCLASSE'];
} elseif($codeperiode === "T") {
    $libelleseq = $trimestre['LIBELLE'];
    $moyclasse =  $travail['MOYCLASSE'];
}else{
    $libelleseq = "ANNUEL " . $_SESSION['anneeacademique'];
}
$corps .= '<th border="1" width="' . ($col[3] + 3) . '%" rowspan="4" align="center"><b>' . $libelleseq . '<br/><br/><br/>'
        . 'NB MOY. >= 10/20<br/><br/><br/>(' . $taux[0] . ' SUR ' . $effectif . ')</b></th>';

$corps .= '</tr>'
        . '<tr><th width="' . ($col[1] + $col[0]) . '%" border="1" colspan="2">Effectif</th>'
        . '<th border="1" width="' . ($col[2] + 1) . '%">' . $effectif . '</th></tr>'
        . '<tr><th width="' . ($col[1] + $col[0]) . '%" border="1" colspan="2">Moy. Classe</th>'

        . '<th width="' . ($col[2] + 1) . '%" border="1">' . sprintf("%.2f",$moyclasse) . '</th></tr>'
        . '<tr><th width="' . ($col[1] + $col[0]) . '%" border="1" colspan="2">Taux de r&eacute;ussite</th>'
        . '<th width="' . ($col[2] + 1) . '%" border="1">' . sprintf("%.2f", $tauxreussite) . '%</th></tr>';
$corps .= '</thead><tbody>';
$i = 1;

foreach ($rangs as $rang) {

    $corps .= '<tr><td align="center" border="1" width="' . $col[0] . '%">' . $i . '</td>'
            . '<td border="1" width="' . ($col[1] + $col[2] + 1) . '%" colspan="2">' .
            $rang['NOMEL'] . ' ' . $rang['PRENOMEL'] . '</td>';
    $sexeredouble = $rang['SEXEEL'] . "/";
    if (in_array($rang['IDELEVE'], $array_of_redoublants)) {
        $sexeredouble .= "OUI";
    } else {
        $sexeredouble .= "NON";
    }
    $corps .= '<td border="1" width="' . ($col[3] + 1) . '%">' . $sexeredouble . '</td>';

    $corps .= getBodyRecapitulatif($groupe1, $col[2], $rang['IDELEVE']);
    $corps .= getBodyRecapitulatif($groupe2, $col[2], $rang['IDELEVE']);
    $corps .= getBodyRecapitulatif($groupe3, $col[2], $rang['IDELEVE']);

    $corps .= printTravailRecapitulatif($rang, $col[2], $prev);
    $prev = $rang['RANG'];

    # Discripline
    foreach ($discipline as $disc) {
        if ($disc['IDELEVE'] == $rang['IDELEVE']) {
            break;
        }
    }
    $disc = array();
    $corps .= printDisciplineRecapitulatif($disc, $col[4]);
    $corps .= '<td border="1" width="' . ($col[3] + 3) . '%"><b style="text-transform:uppercase">'
            . getAppreciations($rang['MOYGENERALE']) . '</b></td>';
    $i++;
    $corps .= '</tr>';
}
$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 0, $x - 5, $y + 5, $corps);
$pdf->Output();

function writeVerticalText($input) {
    $str = '';
    for ($i = 0; $i < strlen($input) - 1; $i++) {
        $str .= $input[$i] . '<br style="line-height:7px" />';
    }
    $str .= $input[$i];
    return $str;
}

function getTauxReussite($rangs) {
    $tab = array();
    $supmoy = 0;
    $totalmoy = 0;
    foreach ($rangs as $rang) {
        if ($rang['MOYGENERALE'] >= 10) {
            $supmoy++;
        }
        $totalmoy++;
    }
    # moy >= 10
    $tab[0] = $supmoy;
    $tab[1] = $totalmoy;
    return $tab;
}

function getMatiereDeLaClasse($notes) {
    $tab = array();
    $array_of_deja = array();
    foreach ($notes as $n) {
        if (!in_array($n['MATIERE'], $array_of_deja)) {
            $array_of_deja[] = $n['MATIERE'];
            $tab[] = $n;
        }
    }
    return $tab;
}
