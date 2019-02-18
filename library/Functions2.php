<?php

function enseignantAbsentByPeriode($date, $absences, $idclasse = "", $horaire = "") {
    $absents = array();
    if (empty($idclasse) && empty($horaire)) {
        foreach ($absences as $abs) {
            if ($abs['DATEJOUR'] == $date) {
                $absents[] = $abs;
            }
        }
        return $absents;
    }

    if (!empty($idclasse) && !empty($horaire)) {
        foreach ($absences as $abs) {
            if ($abs['HORAIRE'] == $horaire && $abs['IDCLASSE'] == $idclasse) {
                $absents[] = $abs;
            }
        }
        return $absents;
    }
    return null;
}

/**
 * Obtenir le lundi de cette date qui correspond a la semaine de cette date
 * utiliser dans l'emploi du temps
 * @param type $date 
 * 0 = Dimanche, 1 = Lundi, ....
 */
function getSemaineDu($date) {
    $days = 0;
    $dayofweek = date("w", strtotime($date));
    if ($dayofweek == 0) {
        $days = "+1 day";
    } else {
        $dayofweek--;
        $days = "-" . $dayofweek . " day";
    }

    return date("Y-m-d", strtotime($days, strtotime($date)));
}

/**
 * Identique au fichier Functions,
 * Extension de ce fichier
 * 
 */
function parseDate($f) {
    if (isset($f)) {
        if (strstr($f, "/") != FALSE) {
            list($d, $m, $y) = explode("/", $f);
            $fl = $y . "-" . $m . "-" . $d;
            return $fl;
        } else {
            return $f;
        }
    }
    return "0000-00-00";
}

function enseignantAbsent($idenseignant, $absences, $horaire = 0, $datejour = "") {
    if (empty($horaire) && !empty($datejour)) {
        foreach ($absences as $abs) {
            if ($abs['PERSONNEL'] == $idenseignant && $abs['DATEJOUR'] == $datejour) {
                return $abs;
            }
        }
    } elseif (empty($datejour)) {
        foreach ($absences as $abs) {
            if ($abs['PERSONNEL'] == $idenseignant && $abs['HORAIRE'] == $horaire) {
                return $abs;
            }
        }
    } else {
        foreach ($absences as $abs) {
            if ($abs['PERSONNEL'] == $idenseignant && $abs['HORAIRE'] == $horaire && $abs['DATEJOUR'] == $datejour) {
                return $abs;
            }
        }
    }
    return null;
}

function enseignantAbsentByClasse($date, $absences, $idclasse = "", $horaire = "") {
    $absents = array();
    if (empty($idclasse) && empty($horaire)) {
        foreach ($absences as $abs) {
            if ($abs['DATEJOUR'] == $date) {
                $absents[] = $abs;
            }
        }
        return $absents;
    }

    if (!empty($idclasse) && !empty($horaire)) {
        foreach ($absences as $abs) {
            if ($abs['HORAIRE'] == $horaire && $abs['IDCLASSE'] == $idclasse) {
                $absents[] = $abs;
            }
        }
        return $absents;
    }
    return null;
}

/**
 * 
 * @param type $derniereleve information sur le dernier eleve
 * @param type $matric sous la forme 16T pour une terminale en 2015-2016, 166 pour une sixieme en 2015-2016
 * @return string le matricule generer
 */
function genererMatricule($derniereleve, $matric) {
    $matricule = $matric;
    # Si un dernier eleve existe, alors concatener
    if ($derniereleve) {
        # Obtenir les trois dernier chiffre du matricule du dernier eleve
        $increment = substr($derniereleve['MATRICULE'], -3);
        $fin = intval($increment) + 1;
        if (strlen($fin) == 1) {
            $fin = "00" . $fin;
        } elseif (strlen($fin) == 2) {
            $fin = "0" . $fin;
        }
        $matricule = $matric . $fin;
    }
    # Sinon, alors il est le premier
    else {
        $matricule = $matric . "001";
    }
    return $matricule;
}

/**
 * Un tableau contenant les moyennes des eleves pour chaque sequences
 * 
 * @param type $moyennes = array()
 */
function genererCourbe($moyennes, $rang, $codeperiode = "S") {
    try {
        # Donnees de la courbe
        $ydata = $moyennes;
        $ydata2 = $moyennes;

        /* for ($i = 1; $i <= 6; $i++) {
          $r = rand(0, 20);
          $ydata[] = $r;
          $ydata2[] = $r;
          } */

        /** Definition des label de l'axe x */
        if ($codeperiode === "T") {
            $datax = array("TRIM1", "TRIM2", "TRIM3");
        } else {
            $datax = array("seq 1", "seq 2", "seq 3", "seq 4", "seq 5", "seq 6");
        }

        # Creation du graph
        $graph = new Graph(350, 250, 'auto');
        $graph->SetMarginColor('white');

        # Definir le max et le min des valeur X
        $graph->SetScale('textlin', 0, 20);

        #$graph->xaxis->title->Set("Séquences");
        $graph->yaxis->title->SetFont(FF_ARIAL, FS_BOLD, 12);
        $graph->yaxis->title->Set("Moyennes");
        $graph->xaxis->SetTickLabels($datax);
        $graph->xaxis->title->SetFont(FF_ARIAL, FS_BOLD, 12);
        if ($codeperiode === "T") {
            $graph->xaxis->SetTitle("Trimestres", "middle");
        } else {
            $graph->xaxis->SetTitle("Séquences", "middle");
        }

        $graph->SetBackgroundGradient('white', 'lightblue', GRAD_HOR, BGRAD_PLOT);

        # Adjuster les margins (left, right, top, bottom)
        $graph->SetMargin(40, 5, 21, 45);

        # Box autour du plotarea
        $graph->SetBox();

        # Un cadre ou frame autour de l'image
        $graph->SetFrame(false);

        # Definir le titre tabulaire
        $graph->tabtitle->SetFont(FF_ARIAL, FS_BOLD, 8);
        $graph->tabtitle->Set($_SESSION['anneeacademique']);
        # Definir le titre du graphe
        $graph->title->SetFont(FF_VERDANA, FS_BOLD, 8);
        $graph->title->SetAlign("right");
        if (count($ydata) > 1) {
            $prev = $ydata[count($ydata) - 2];
            if ($prev < $ydata[count($ydata) - 1]) {
                $graph->title->Set("Performance en hausse");
            } elseif ($prev == $ydata[count($ydata) - 1]) {
                $graph->title->Set("Performance constante");
            } else {
                $graph->title->Set("Performance en baisse");
            }
        }


        # Definir les grid X et Y
        $graph->ygrid->SetFill(true, '#BBBBBB@0.9', '#FFFFFF@0.9');
        //$graph->ygrid->SetLineStyle('dashed');
        //$graph->ygrid->SetColor('gray');
        //$graph->xgrid->SetLineStyle('dashed');

        $graph->xgrid->SetColor('gray');
        $graph->xgrid->Show();
        //$graph->ygrid->Show();
        #$graph->SetBackgroundGradient('blue','navy:0.5',GRAD_HOR,BGRAD_MARGIN);
        $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 8);
        $graph->xaxis->SetLabelAngle(0);

        # Creation d'une bar pot
        $bplot = new BarPlot($ydata);
        $bplot->SetWidth(0.9);
        $fcol = '#440000';
        $tcol = '#FF9090';

        $bplot->SetFillGradient($fcol, $tcol, GRAD_LEFT_REFLECTION);

        # Set line weigth to 0 so that there are no border around each bar
        $bplot->SetWeight(0);

        # Create filled line plot
        $lplot = new LinePlot($ydata2);
        $lplot->SetFillColor('skyblue@0.5');
        $lplot->SetStyle(1);
        $lplot->SetColor('navy@0.7');
        $lplot->SetBarCenter();

        $lplot->mark->SetType(MARK_SQUARE);
        $lplot->mark->SetColor('blue@0.5');
        $lplot->mark->SetFillColor('lightblue');
        $lplot->mark->SetSize(5);
        # Afficher les moyenne au dessus des barres
        $accbarplot = new AccBarPlot(array($bplot));
        $accbarplot->value->SetFormat("%.2f");
        $accbarplot->value->Show();
        $graph->Add($accbarplot);
        $graph->SetBackgroundImageMix(50);

        # Definir un fond d'ecran pour l'image
        $background = SITE_ROOT . "public/photos/eleves/" . $rang['PHOTOEL'];
        if (!empty($rang['PHOTOEL']) &&
                file_exists(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $rang['PHOTOEL'])) {
            $graph->SetBackgroundImage($background, BGIMG_FILLPLOT);

            # $icon = new IconPlot($background, 25, 25, 0.8, 50);
        } else {
            //$graph->SetBackgroundImage(SITE_ROOT . "public/img/". LOGO, BGIMG_FILLPLOT);
            # $icon = new IconPlot(SITE_ROOT . "public/img/ipw.png", 25, 25, 0.8, 50);
        }
        # $icon->SetAnchor('right', 'bottom');

        $graph->Add($lplot);


        // Display the graph
        $filename = ROOT . DS . "public" . DS . "tmp" . DS . $rang['IDELEVE'] . ".png";
        if (file_exists($filename)) {
            unlink($filename);
        }
        $graph->Stroke($filename);
        //echo "<img src='" . SITE_ROOT . "public/tmp/emp.png' />";
    } catch (Exception $e) {
        var_dump($e);
    }
}

/**
 * 
 * @param array $datax
 * @param array $datay1 Moy de classe pour une matiere
 * @param type $datay2 pourcentage de reussite
 */
function tracerCourbeMoyennes($datax, $datay1, $datay2) {

// Setup the graph
    $graph = new Graph(850, 400, 'auto');
    $graph->SetMargin(30, 15, 50, 5);
    $graph->SetMarginColor('black');
    $graph->SetScale("linlin");
    $graph->SetBox();
// Hide the frame around the graph
    $graph->SetFrame(false);

// Setup title
#$graph->title->Set("Using Builtin PlotMarks");
    $graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);

// Note: requires jpgraph 1.12p or higher
// $graph->SetBackgroundGradient('blue','navy:0.5',GRAD_HOR,BGRAD_PLOT);
#$graph->tabtitle->Set('Region 1' );
#$graph->tabtitle->SetWidth(TABTITLE_WIDTHFULL);
// Enable X and Y Grid
    $graph->SetScale('textlin', 0, max($datay2) + 1);
    $graph->xgrid->SetColor('gray@0.5');
    $graph->xaxis->SetTickLabels($datax);

    $graph->ygrid->SetColor('gray@0.5');

// Format the legend box
    $graph->legend->SetColor('black');
#$graph->legend->SetFillColor('lightgreen');
    $graph->legend->SetLineWeight(1);
    $graph->legend->SetFont(FF_ARIAL, FS_BOLD, 8);
    $graph->legend->SetShadow('gray@0.4', 3);
#$graph->legend->SetAbsPos(15,120,'right','top');
    $graph->legend->SetPos(0.3, 0.03, 'right', 'top');

// Create the line plots

    $p1 = new LinePlot($datay1);
    $p1->SetColor("red");
    $p1->SetFillColor("yellow@0.5");
    $p1->SetWeight(2);
    $p1->mark->SetType(MARK_IMG_DIAMOND, 5, 0.6);

    $p1->SetLegend('Moy.Classe');
    $graph->Add($p1);



    $p2 = new LinePlot($datay2);
    $p2->SetColor("darkgreen");
    $p2->SetWeight(2);
    $p2->SetLegend('%REUSSITE');
    $p2->mark->SetType(MARK_IMG_MBALL, 'red');
    $graph->Add($p2);

// Add a vertical line at the end scale position '7'
    $l1 = new PlotLine(VERTICAL, intval(count($datax) / 2));
    $graph->Add($l1);


// Display the graph
    $filename = ROOT . DS . "public" . DS . "tmp" . DS . "courbe.png";
    if (file_exists($filename)) {
        unlink($filename);
    }
    $graph->Stroke($filename);
}

function getMoyennesRecapitulatives($recapitulatifs, $ideleve, $codeperiode = "S") {
    if ($codeperiode === "A") {
        foreach ($recapitulatifs as $recap) {
            if ($recap['IDELEVE'] === $ideleve) {
                return [$recap['MOYSEQ1'], $recap['MOYSEQ2'], $recap['MOYSEQ3'],
                    $recap['MOYSEQ4'], $recap['MOYSEQ5'], $recap['MOYSEQ6']];
            }
        }
    } else {
        $moy = array();
        foreach ($recapitulatifs as $recap) {
            if ($recap['IDELEVE'] == $ideleve) {
                $moy[] = $recap['MOYGENERALE'];
            }
        }
        return $moy;
    }
}

/**
 * FUNCTION UTILISEES DANS LE BULLETIN
 */
function trierParGroupe($notes, $ideleve = "") {
    $tab = array();
    $g1 = $g2 = $g3 = array();
    if (empty($el)) {
        foreach ($notes as $n) {
            if ($n['GROUPE'] == 1) {
                $g1[] = $n;
            } elseif ($n['GROUPE'] == 2) {
                $g2[] = $n;
            } else {
                $g3[] = $n;
            }
        }
    } else {
        foreach ($notes as $n) {
            if ($n['IDELEVE'] == $el['IDELEVE']) {
                if ($n['GROUPE'] == 1) {
                    $g1[] = $n;
                } elseif ($n['GROUPE'] == 2) {
                    $g2[] = $n;
                } else {
                    $g3[] = $n;
                }
            }
        }
    }
    $tab[0] = $g1;
    $tab[1] = $g2;
    $tab[2] = $g3;
    return $tab;
}

function printGroupe($col, $params) {
    # Ecrire le GROUPE 1
    #$backg = "#F7F7F7";
    $backg = "#CCC";
    if (strlen($params['description']) > 10) {
        $backg = "#CCC";
    }
    $str = '<tr style="background-color:' . $backg . ';line-height:14px;text-align:center;font-weight:bold;">';
    $str .= '<td border="1" witdh="' . $col[1] . '%" style="text-align:left">&nbsp;&nbsp;' . $params['description'] . '</td>';

    # Moyenne totale du groupe 
    if ($params['sumcoeff'] != 0) {
        $moy = ($params['sumtotal']) / $params['sumcoeff'];
    } else {
        $moy = 0;
    }
    if ($params['codeperiode'] === "S") {
        $str .= '<td border="1" width="' . $col[4] . '%"></td>';
        $str .= '<td border="1" width="' . $col[5] . '%">' . $params['sumcoeff'] . '</td>'
                . '<td border="1" colspan="3" width="' . ($col[6] + $col[7] + $col[8]) . '%">'
                . 'Points : ' . $params['sumtotal'] . " / " . ($params['sumcoeff'] * 20) . '</td>';
        $str .= '<td style="text-align:left" border="1" colspan="2" width="' . ($col[9] + $col[10]) . '%">'
                . '&nbsp;&nbsp;Moyenne : ' . sprintf("%.2f", $moy) . '</td></tr>';
    } elseif ($params['codeperiode'] === "T") {
        $str .= '<td border="1" colspan="3" width="' . ($col[2] + $col[3] + $col[4]) . '%">'
                . 'Points : ' . $params['sumtotal'] . " / " . ($params['sumcoeff'] * 20) . '</td>'
                . '<td border="1" width="' . $col[5] . '%">' . $params['sumcoeff'] . '</td>';

        $str .= '<td style="text-align:left" border="1" colspan="5" width="' . ($col[6] + $col[7] + $col[8] + $col[9] + $col[10]) . '%">'
                . '&nbsp;&nbsp;Moyenne : ' . sprintf("%.2f", $moy) . '</td></tr>';
    }

    return $str;
}

function printDisciplineRecapitulatif($disc, $width) {
    $str = '';
    #$width = $width - 1;
    $str .= '<td border="1" width="' . $width . '%"></td>'
            . '<td border="1" width="' . $width . '%"></td>'
            . '<td border="1" width="' . $width . '%"></td>';
    #. '<td border="1" width="' . $width . '%"></td>';
    return $str;
}

function printDiscipline($disc) {
    $cold = array();
    $cold[0] = 0;
    $cold[1] = 15;
    $cold[2] = $cold[3] = 12;
    $cold[4] = 15;
    $cold[5] = 24;
    $cold[6] = 24;

    $str = '<table style="text-align:center;" cellpadding="2"><tr style="font-weight:bold;line-height:12px;font-size:8px">'
            . '<td width="' . $cold[1] . '%"  border="1">DISCIPLINE</td><td border="1" width="' . $cold[2] . '%" >T. ABS</td>'
            . '<td width="' . $cold[3] . '%" border="1">Abs.J</td><td width="' . $cold[4] . '%" border="1">Retards (H)</td>'
            . '<td width="' . $cold[5] . '%"  border="1">Conseil de Classe</td>'
            . '<td width="' . $cold[6] . '%"  border="1">Observations</td></tr>';
    # Total absences
    if (empty($disc['TOTALABS'])) {
        $disc['TOTALABS'] = 0;
    }
    $str .= '<tr style="font-weight:bold;line-height:12px"><td></td><td border="1">' . $disc['TOTALABS'] . '</td>';
    if (empty($disc['ABSINJUST'])) {
        $disc['ABSINJUST'] = 0;
    }
    # Absence Non Justifier
    $str .= '<td border="1">' . $disc['ABSJUST'] . '</td>';

    #Retards
    $str .= '<td border="1">0</td>';

    #Avertissements

    $str .= '<td border="1">' . getConseilClasseConduite($disc['ABSINJUST']) . '</td>';
    $str .= '<td border="1"></td>';
    $str .= '</tr></table>';
    return $str;
}

function printTravailRecapitulatif($rang, $width, $prev) {
    $str = "";
    $str .= '<td border="1" align="center" width="' . ($width + 1) . '%">' . sprintf("%.2f", $rang['POINTS']) . '</td>'
            . '<td border="1" align="center" width="' . ($width + 1) . '%">' . sprintf("%.2f", $rang['MOYGENERALE']) . '</td>';

    $expo = "<sup>e</sup>";
    if ($rang['RANG'] == 1) {
        $expo = '<sup>' . ($rang['SEXEEL'] == "F" ? "e" : "e") . '</sup>';
    }
    $execo = "";
    if ($rang['RANG'] == $prev) {
        $execo = "ex";
    }
    $str .= '<td align="center" border="1" width="' . ($width) . '%">' . $rang['RANG'] . $expo . ' ' . $execo . '</td>';
    return $str;
}

function printTravail($rang, $travail, $prev) {
    $colt = array();
    $colt[0] = 0;
    $colt[1] = 15;
    $colt[2] = 9;
    $colt[3] = 7;
    $colt[5] = 9;
    $colt[7] = $colt[8] = 8;
    $colt[4] = 7;
    $colt[6] = 9;
    $colt[9] = 30;
    $str = '<table style="text-align:center" cellpadding="2"><tr style="font-weight:bold;line-height:12px;font-size:10px">'
            . '<td width="' . $colt[1] . '%"  border="1">TRAVAIL</td><td width="' . $colt[2] . '%" border="1">Points</td>'
            . '<td width="' . $colt[3] . '%" border="1">Coef</td><td width="' . $colt[4] . '%" border="1">Moy.</td>'
            . '<td width="' . $colt[5] . '%" border="1">Rang</td><td width="' . $colt[6] . '%" border="1">Moy.CL</td>'
            . '<td width="' . $colt[7] . '%" border="1">Min</td><td width="' . $colt[8] . '%" border="1">Max</td>'
            . '<td width="' . $colt[9] . '%" border="1">Mention</td></tr>';

    $str .= '<tr style="font-weight:bold;line-height:12px;font-size:10px"><td></td><td  border="1">' . sprintf("%.2f", $rang['POINTS']) . '</td>';
    $str .= '<td  border="1">' . sprintf("%.0f", $rang['SUMCOEFF']) . '</td>';
    # Moyenne generale
    $str .= '<td  border="1" style="background-color:#CCC">' . sprintf("%.2f", $rang['MOYGENERALE']) . '</td>';

    # Rang sequentielle
    $expo = "<sup>&egrave;me</sup>";
    if ($rang['RANG'] == 1) {
        $expo = '<sup>' . ($rang['SEXEEL'] == "F" ? "&egrave;re" : "er") . '</sup>';
    }
    $execo = "";
    if ($rang['RANG'] == $prev) {
        $execo = "ex";
    }
    $str .= '<td  border="1" style="background-color:#CCC">' . $rang['RANG'] . $expo . ' ' . $execo . '</td>';

    # Moyenne generale de la classe
    $str .= '<td  border="1">' . sprintf("%.2f", $travail['MOYCLASSE']) . '</td>';

    #Moyenne Min de la classe
    $str .= '<td  border="1">' . sprintf("%.2f", $travail['MOYMIN']) . '</td>';

    #Moyenne Max de la classe

    $str .= '<td  border="1">' . sprintf("%.2f", $travail['MOYMAX']) . '</td>';

    # Mention en fonction de la moyenne generale
    $mention = getMentions($rang['MOYGENERALE']);

    $str .= '<td  border="1" >' . $mention . '</td>';

    $str .= '</tr></table>';
    return $str;
}

function getBodyRecapitulatif($groupe, $width, $ideleve) {
    $str = "";
    $sumtotal = $sumcoeff = 0;
    foreach ($groupe as $g) {
        if ($g['IDELEVE'] === $ideleve) {
            if (!empty($g['COEFF'])) {
                $str .= '<td border="1" align="center" width="' . $width . '%" style="text-align:center">' . sprintf("%.2f", $g['MOYENNE']) . '</td>';
            } else {
                $str .= '<td border="1" width="' . $width . '%"></td>';
            }
            $sumcoeff += $g['COEFF'];
            $sumtotal += $g['TOTAL'];
        }
    }
    if ($sumcoeff != 0) {
        $moy = ($sumtotal) / $sumcoeff;
    } else {
        $moy = 0;
    }
    if (!empty($groupe)) {
        $str .= '<td border="1" align="center" width="' . ($width) . '%">' . sprintf("%.2f",$sumtotal) . '</td>'
                . '<td border="1" align="center" width="' . $width . '%">' . sprintf("%.2f", $moy) . '</td>';
    }
    return $str;
}

function getBody($groupe, $col, $el, $codeperiode, &$sumtotal = 0, &$sumcoeff = 0) {
    $str = "";
    $sumdh = $sumdp = $summoy = 0;
    foreach ($groupe as $g) {
        if ($g['IDELEVE'] == $el['IDELEVE']) {
            $str .= '<tr style="text-align:center;font-weight:bold;">';
            # Matiere
            //$g['NOM'] = preg_replace("%[^\033-\176\r\n\t]%", '', $g['NOM']);
            //$g['PRENOM'] = preg_replace("%[^\033-\176\r\n\t]%", '', $g['PRENOM']);

            $str .= '<td border="1" style="text-align:left;" '
                    . 'width="' . $col[1] . '%">&nbsp;&nbsp;<b style="text-transform:uppercase">' . trim($g['BULLETIN']) .
                    '</b><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:7px;font-weight:normal">'
                    . ($g['CIVILITE'] . ' ' . $g['NOM']) . '</span></td>';

            # DP
            if ($codeperiode === "T") {
                if ($g['SEQ1'] != "" && $g['SEQ1'] != null) {
                    $str .= '<td  style="line-height:17px" border="1" width="' . $col[2] . '%">' . sprintf("%.2f", $g['SEQ1']) . '</td>';
                } else {
                    $str .= '<td border="1" width="' . $col[2] . '%"></td>';
                }
                # DH
                if ($g['SEQ2'] != "" && $g['SEQ2'] != null) {
                    $str .= '<td  style="line-height:17px" border="1" width="' . $col[3] . '%">' . sprintf("%.2f", $g['SEQ2']) . '</td>';
                } else {
                    $str .= '<td border="1" width="' . $col[3] . '%"></td>';
                }
            }

            # Moyenne DP et DH
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px" border="1" width="' . $col[4] . '%">' . sprintf("%.2f", $g['MOYENNE']) . '</td>';
            } else {
                $str .= '<td border="1" width="' . $col[4] . '%"></td>';
            }
            # Coeff
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px" border="1" width="' . $col[5] . '%">' . sprintf("%.0f", $g['COEFF']) . '</td>';
            } else {
                $str .= '<td border="1" width="' . $col[5] . '%"></td>';
            }
            # Total = coeff * moy
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px" border="1" width="' . $col[6] . '%">' . sprintf("%.2f", $g['TOTAL']) . '</td>';
            } else {
                $str .= '<td border="1" width="' . $col[6] . '%"></td>';
            }
            # Rang
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px" border="1" width="' . $col[7] . '%">' . $g['RANG'] . '</td>';
            } else {
                $str .= '<td border="1" width="' . $col[7] . '%"></td>';
            }
            #Moyenne de classe
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px" border="1" width="' . $col[8] . '%">' . sprintf("%.2f", $g['MOYCL']) . '</td>';
            } else {
                $str .= '<td border="1" width="' . $col[8] . '%"></td>';
            }
            #Min / Max
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px" border="1" width="' . $col[9] . '%">' . sprintf("%.2f", $g['NOTEMIN']) . ' / ' . sprintf("%.2f", $g['NOTEMAX']) . '</td>';
            } else {
                $str .= '<td border="1" width="' . $col[9] . '%"></td>';
            }
            #Appreciation
            if (!empty($g['COEFF'])) {
                $str .= '<td  style="line-height:17px;text-align:left;"'
                        . ' border="1" width="' . $col[10] . '%" >&nbsp;&nbsp;<b style="text-transform:uppercase">' .
                        getAppreciations($g['MOYENNE']) . '</b></td>';
            } else {
                $str .= '<td border="1" width="' . $col[10] . '%"></td>';
            }
            # Sommes
            #$sumdh += $g['MOYENNE'];
            #$sumdp += $g['DP'];
            $sumcoeff += $g['COEFF'];
            $sumtotal += $g['TOTAL'];
            $summoy += $g['MOYENNE'];

            $str .= '</tr>';
        }
    }
    if (!empty($groupe)) {
        $param = ["sumtotal" => $sumtotal, "sumcoeff" => $sumcoeff,
            "description" => $g['DESCRIPTION'], "codeperiode" => $codeperiode];
        $str .= printGroupe($col, $param);
    }
    return $str;
}

function getHeaderBulletin($enseignements, $col, $attrs = array()) {
    $nbMatieres = count($enseignements);
    $line_height = "10px";
    if ($nbMatieres > 14) {
        $line_height = "8px";
    }
    if ($attrs['codeperiode'] === "A") {
        $corps = '<table cellpadding="0.5" style="line-height: ' . $line_height . '">
    <thead>
        <tr style="text-align:center;font-weight:bold;font-size:7px;line-height: 15px;">
        <th width="' . $col[10] . '%"></th>
           <th colspan="2" width="' . $col[12] . '%" border="1">1<sup>er</sup>Trimestre</th>
        <th border="1" colspan="2"  width="' . $col[12] . '%">2<sup>nd</sup>Trimestre</th>
            <th border="1" colspan="2" width="' . $col[12] . '%">3<sup>e</sup>Trimestre</th>
                <th colspan="5" border="1" width="' . ($col[7] + $col[11] + $col[13] + $col[8] + $col[9]) . '%">Annuel</th></tr>
        <tr style="text-align:center;font-weight:bold; line-height: 15px;font-size:8px;background-color:#000;color:#FFF;">
            <th border="1" width="' . $col[10] . '%">Mati&egrave;res</th>
            <th width="' . $col[1] . '%">S1</th>
            <th width="' . $col[2] . '%">S2</th>
            <th width="' . $col[3] . '%">S3</th>
            <th width="' . $col[4] . '%">S4</th><th  width="' . $col[5] . '%">S5</th>
            <th width="' . $col[6] . '%">S6</th>
            <th width="' . $col[7] . '%" border="1">Moy</th>
            <th  width="' . $col[11] . '%" border="1">Coef</th>
            <th width="' . $col[13] . '%" border="1">Total</th>
            <th width="' . $col[8] . '%" border="1">Rang</th>
            <th width="' . $col[9] . '%" border="1">Appr&eacute;ciation</th></tr>
        </thead>
        <tbody>';
        return $corps;
    }
    $str = '<table border="1" cellpadding="0.5" style="line-height: ' . $line_height . '"><thead>'
            . '<tr style="text-align:center;font-weight:bold; line-height: 15px;font-size:10px;background-color:#000;color:#FFF;">'
            . '<th border="1"  width="' . $col[1] . '%" style="text-align:left">&nbsp;&nbsp;Mati&egrave;res</th>';

    if ($attrs['codeperiode'] === "S") {
        $str .= '<th border="1" width="' . $col[4] . '%">Note</th>';
    } else {
        $str .= '<th border="1" width="' . $col[2] . '%">' . $attrs['seq1'] . '</th>'
                . '<th border="1" width="' . $col[3] . '%">' . $attrs['seq2'] . '</th>'
                . '<th border="1" width="' . $col[4] . '%">Moy</th>';
    }

    $str .= '<th border="1"  width="' . $col[5] . '%">Coef</th>'
            . '<th border="1"  width="' . $col[6] . '%">Total</th>'
            . '<th border="1" width="' . $col[7] . '%">Rang</th>'
            . '<th border="1"  width="' . $col[8] . '%">Moy.Cl</th>'
            . '<th border="1"  width="' . $col[9] . '%">Min/Max</th>'
            . '<th border="1"  width="' . $col[10] . '%">Appr&eacute;ciation</th></tr></thead><tbody>';
    return $str;
}

function getLargeurColonne($codeperiode) {
    $col = array();
    if ($codeperiode === "S") {
        $col[0] = 0;
        $col[1] = 35;
        $col[2] = 7;
        $col[3] = 7;
        $col[4] = 8;
        $col[5] = 7;
        $col[6] = 7;
        $col[7] = 6;
        $col[8] = 8;
        $col[9] = 12;
        $col[10] = 19;
    } elseif ($codeperiode === "T") {
        $col[0] = 0;
        $col[1] = 32;
        $col[2] = 6;
        $col[3] = 6;
        $col[4] = 6;
        $col[5] = 6;
        $col[6] = 6;
        $col[7] = 6;
        $col[8] = 7;
        $col[9] = 10;
        $col[10] = 17;
    } elseif ($codeperiode === "A") {
        $col = [5, 5, 5, 5, 5, 5, 5, 6, 6, 12, 36, 5, 10, 7];
    }
    return $col;
}

function getLibelleSequences($sequences) {
    $tab = array();
    $tab[0] = "Seq" . $sequences[0]['ORDRE'];
    $tab[1] = "Seq" . $sequences[1]['ORDRE'];
    return $tab;
}

function printTravailTrimestre($rang, $travail, $prev, $seq1, $seq2) {
    $col = [0, 11, 6, 20, 20, 7, 7, 20, 6, 5];
    $ordretrimestre = 3;
    if ($seq1['ORDRE'] === 1) {
        $ordretrimestre = 1;
    } elseif ($seq1['ORDRE'] === 3) {
        $ordretrimestre = 2;
    }
    $corps = '<table>'
            . '<tr style="background-color:#CCC;font-weight:bold;text-align:center;font-size:8px">'
            . '<td border="1" width="' . ($col[1] + $col[5]/2) . '%" style="background-color:#FFF">TRAVAIL</td>'
           // . '<td border="1" align="center"  width="' . $col[5] . '%">Points</td>'
            . '<td border="1" align="center"  width="' . $col[9] . '%">Coef</td>'
            . '<td colspan="3" border="1" align="center" width="' . $col[3] . '%">Moyenne</td>'
            . '<td colspan="3" border="1" align="center" width="' . $col[4] . '%">RANG</td>'
            . '<td border="1" align="center"  width="' . $col[5] . '%">Moy.CL</td>'
            . '<td border="1" align="center"  width="' . $col[8] . '%">MIN</td>'
            . '<td border="1" align="center"  width="' . $col[8] . '%">MAX</td>'
            . '<td border="1" align="center"  width="' . ($col[7] + $col[5]/2) . '%">Mention</td>'
            . '</tr>'
            . '<tr align="center" style="text-align:center;font-weight:bold;font-size:10px"><td></td>'
            # Points
            //. '<td border="1" rowspan="2" style="line-height:21px" width="' . $col[5] . '%">' . sprintf("%.2f", $rang['POINTS']) . '</td>'
            # Coefficient total
            . '<td border="1" rowspan="2" style="line-height:21px" width="' . $col[9] . '%">' . sprintf("%.0f", $rang['SUMCOEFF']) . '</td>'
            . '<td border="1"  width="' . $col[2] . '%" style="font-size:6px">SEQ' . $seq1['ORDRE'] . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px">SEQ' . $seq2['ORDRE'] . '</td>'
            . '<td border="1" width="' . ($col[2] + 2) . '%" style="font-size:6px">TRIM' . $ordretrimestre . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px">SEQ' . $seq1['ORDRE'] . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px">SEQ' . $seq2['ORDRE'] . '</td>'
            . '<td border="1" width="' . ($col[2] + 2) . '%" style="font-size:6px">TRIM' . $ordretrimestre . '</td>'
            # Moy. CL
            . '<td border="1" rowspan="2" style="line-height:21px" width="' . $col[5] . '%">' . sprintf("%.2f", $travail['MOYCLASSE']) . '</td>'
            # MIN
            . '<td border="1" rowspan="2" style="line-height:21px" width="' . $col[8] . '%">' . sprintf("%.2f", $travail['MOYMIN']) . '</td>'
            # MAX
            . '<td border="1" rowspan="2" style="line-height:21px" width="' . $col[8] . '%">' . sprintf("%.2f", $travail['MOYMAX']) . '</td>';

    # MENTION
    $mention = getMentions($rang['MOYGENERALE']);
    $corps .= '<td  border="1" rowspan="2"  width="' . ($col[7] + $col[5]/2) . '%" >' . $mention . '</td>';

    $corps .= '</tr>';

    $corps .= '<tr align="center"><td></td>'
            . '<td border="1">' . (isset($seq1['MOYGENERALE']) ? sprintf("%.2f", $seq1['MOYGENERALE']) : "") . '</td>'
            . '<td border="1">' . (isset($seq2['MOYGENERALE']) ? sprintf("%.2f", $seq2['MOYGENERALE']) : "") . '</td>'
            . '<td border="1" style="background-color:#CCC;"><b>' . sprintf("%.2f", $rang['MOYGENERALE']) . '</b></td>'
            . '<td border="1">' . (isset($seq1['RANG']) ? $seq1['RANG']."<sup>e</sup>" : "") . '</td>'
            . '<td border="1">' . (isset($seq2['RANG']) ? $seq2['RANG']."<sup>e</sup>" : "") . '</td>';
    # Rang TRIMESTRIEL
    $expo = "<sup>&egrave;me</sup>";
    if ($rang['RANG'] == 1) {
        $expo = '<sup>' . ($rang['SEXEEL'] == "F" ? "&egrave;re" : "er") . '</sup>';
    }
    $execo = "";
    if ($rang['RANG'] == $prev) {
        $execo = "ex";
    }
    $corps .= '<td border="1" style="background-color:#CCC;"><b>' . $rang['RANG'] . $expo . ' ' . $execo . '</b></td>'
            . '</tr></table>';

    return $corps;
}

function printDisciplineTrimestre($abs1, $abs2, $sequences) {
    $col = [0, 11, 6, 18, 18, 7, 7, 21, 20];
    $ordretrimestre = 3;
    if ($sequences[0]['ORDRE'] === 1) {
        $ordretrimestre = 1;
    } elseif ($sequences[0]['ORDRE'] === 3) {
        $ordretrimestre = 2;
    }
    $corps = '<table><tr style="background-color:#CCC;font-weight:bold;text-align:center;font-size:8px">'
            . '<td border="1" width="' . $col[1] . '%" style="background-color:#FFF">DISCIPLINE</td>'
            . '<td border="1" align="center"  width="' . $col[5] . '%">T.ABS</td>'
            . '<td border="1" align="center"  width="' . $col[5] . '%">Retard</td>'
            . '<td colspan="3" border="1" align="center" width="' . $col[3] . '%">ABS. Justifi&eacute;es</td>'
            . '<td colspan="3" border="1" align="center" width="' . $col[4] . '%">Consignes</td>'
            . '<td border="1" align="center"  width="' . $col[7] . '%">Conseil de classe</td>'
            . '<td border="1" align="center"  width="' . $col[8] . '%">Observation</td>'
            . '</tr>'
            . '<tr align="center" style="text-align:center;font-size:10px; font-weight:bold;"><td></td>'
            # Total des absence des deux sequence
            . '<td border="1" style="line-height:21px" rowspan="2" width="' . $col[5] . '%">' . ($abs1['TOTALABS'] + $abs2['TOTALABS']) . '</td>'
            # Total des retard
            . '<td style="line-height:21px" border="1" rowspan="2" width="' . $col[5] . '%">0</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px;">SEQ' . $sequences[0]['ORDRE'] . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px;">SEQ' . $sequences[1]['ORDRE'] . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px;">TRIM' . $ordretrimestre . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px;">SEQ' . $sequences[0]['ORDRE'] . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px;">SEQ' . $sequences[1]['ORDRE'] . '</td>'
            . '<td border="1" width="' . $col[2] . '%" style="font-size:6px;">TRIM' . $ordretrimestre . '</td>'
            . '<td border="1" rowspan="2"  width="' . $col[7] . '%">' . getConseilClasseConduite($abs1['ABSINJUST'] + $abs2['ABSINJUST']) . '</td>'
            . '<td border="1" rowspan="2"  width="' . $col[8] . '%"></td></tr>';

    $corps .= '<tr align="center"><td></td>'
            . '<td border="1">' . $abs1['ABSJUST'] . '</td>'
            . '<td border="1">' . $abs2['ABSJUST'] . '</td>'
            . '<td border="1">' . ($abs1['ABSJUST'] + $abs2['ABSJUST']) . '</td>'
            . '<td border="1">' . $abs1['CONSIGNE'] . '</td>'
            . '<td border="1">' . $abs2['CONSIGNE'] . '</td>'
            . '<td border="1">' . ($abs1['CONSIGNE'] + $abs2['CONSIGNE']) . '</td>'
            . '</tr>';

    $corps .= '</table>';
    return $corps;
}

/**
 * utiliser pour le bulletin trimestre,
 * recherche les info sequentielle de l'eleve seq1 et seq2 pour remplir les seq 
 * @param type $ideleve
 * @param type $moy_sequentiel
 */
function getMoyRecapitulativeSequence($ideleve, $moy_sequentiel) {
    foreach ($moy_sequentiel as $seq) {
        if ($seq['IDELEVE'] === $ideleve) {
            return $seq;
        }
    }
    return null;
}

/**
 * utiliser dans le bulletin trimestrielle, retourne l'entree de l'absence pour cet eeleve
 * @param type $ideleve
 * @param type $absences
 * @return type
 */
function getDisciplineRecapitulativeSequence($ideleve, $absences) {
    foreach ($absences as $abs) {
        if ($abs['ELEVE'] === $ideleve) {
            return $abs;
        }
    }
    return null;
}

function setSpecialInterval(&$rangs, &$eff, &$prev, &$debut, &$fin, $effectif) {
    if (empty($fin) || $fin > $effectif) {
        $fin = $effectif;
    }

    if (!empty($debut)) {
        $eff = $debut;
        $prev = $debut - 1;
    } else {
        $debut = 1;
    }
    if ($fin !== $effectif || $debut !== 1) {
        $newRang = array();
        for ($i = $debut - 1; $i < $fin; $i++) {
            $newRang[] = $rangs[$i];
        }
        $rangs = $newRang;
    }
}
/**
 * Utiliser pour la rubrique DISCIPLINE dans le bulletin
 * @param type $absinjust
 * @return string
 */
function getConseilClasseConduite($absinjust) {
    if ($absinjust === 0) {
        return "Bonne Conduite";
    } elseif ($absinjust > 0 && $absinjust <= 6) {
        return "";
    } elseif ($absinjust >= 7 && $absinjust <= 9) {
        return "AV. Conduite";
    } elseif ($absinjust >= 10 && $absinjust <= 14) {
        return "Bl&acirc;mes";
    } elseif ($absinjust >= 15 && $absinjust <= 18) {
        return "Excl. 3jrs + BC";
    } elseif ($absinjust >= 19 && $absinjust <= 25) {
        return "Excl. 5jrs + BC";
    } elseif ($absinjust >= 26) {
        return "Excl. 8jrs + BC";
    }
}

/**
 * Utiliser dans le cas d'un bulletin individuelle 
 * afin d'obtenir le rang de leleve
 * @param type $ideleve
 * @param type $rangs
 */
function getRangEleve($ideleve, $rangs, &$prev = 0) {
    foreach ($rangs as $r) {
        if ($r['IDELEVE'] == $ideleve) {
            return $r;
        } else {
            $prev = $r['RANG'];
        }
    }
    return null;
}
