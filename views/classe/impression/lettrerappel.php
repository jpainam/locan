<?php

$header_gauche = <<<EOD
                <p style = "text-align:center;line-height: 8px">
                    Minist&egrave;re des Enseignements Secondaires<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation R&eacute;gionale du Centre<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation D&eacute;partementale de la MEFOU<br/>
                                AFAMBA<br/>
                                *************<br/>
                    <b>INSTITUT POLYVALENT WAGU&Eacute;</b><br/>
                    <i>&nbsp;&nbsp;Autorisation d'ouverture N° 79/12/MINESEC</i><br/>
                    BP 5062 YAOUNDE<br/>
                    T&eacute;l&eacute;phone: +237 97 86 84 99<br/>
                    Email: institutwague@yahoo.fr<br/>
                    www.institutwague.com
                </p>
                        
EOD;
$header_droit = <<<EOD
                <p style = "text-align:center">R&eacute;publique du Cameroun<br/>
                    <i>Paix-Travail-Patrie<br/>***********</p>
EOD;

$pdf->SetPrintFooter(false);
$pdf->SetPrintHeader(false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();
$y = PDF_Y;
$x = PDF_X;
$middle = PDF_MIDDLE;
$d = new DateFR();
$dd = new DateFR();
$i = 0;
foreach ($eleves as $el) {
    if ($el['MONTANTPAYE'] < $montantfraisapplicable['MONTANTAPPLICABLE']) {
        $i++;
        $pdf->SetFontSize(8);
        $pdf->writeHTMLCell(70, 50, LEFT_UP_CORNER, ($y - 47) + 5, $header_gauche);
        $pdf->Image($pdf->getLogo(), 95, ($y - 47) + 5, 35, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $pdf->writeHTMLCell(50, 5, 156, ($y - 47) + 5, $header_droit);

        $d->setSource($frais['ECHEANCES']);
        # Cmt creer une tabulation
        $pdf->setFont("Times", '', 12);
        $pdf->WriteHTMLCell(0, 5, $middle - 13, $y - 10, '<b style="text-decoration:underline">Lettre de rappel</b>');

        $corps = '<p style="text-align:justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                . 'Cher parent de l\'&eacute;l&egrave;ve <b>' . $el['NOM'] . ' ' . $el['PRENOM'] . '</b> de la classe de '
                . $el['NIVEAUHTML'] . '; <b> Bien vouloir </b> s\'acquitter du frais <b>'
                . $frais['DESCRIPTION'].' (' . moneyString($montantfraisapplicable['MONTANTAPPLICABLE'] - $el['MONTANTPAYE']) . ')</b> '
                . 'dont la date est fix&eacute;e ce <b>'
                . $d->getJour() . ' ' . $d->getDate() . ' ' . $d->getMois() . ' ' . $d->getYear() . '</b>. '
                . 'Pass&eacute; ce delai, l\'administration de l\'&eacute;tablissement sera dans l\'obligation de <b>';
        if ($el['SEXE'] === "M") {
            $corps .= 'le ';
        } else {
            $corps .= 'la ';
        }
        $corps .= 'mettre hors des cours.<b>';
        $pdf->setFont("Times", '', 10);
        $pdf->WriteHTMLCell(0, 5, $x, $y, $corps);
        $corps = '<b>Sinc&egrave;re amiti&eacute;s pour votre bonne compr&eacute;hension.</b>';
        $pdf->WriteHTMLCell(0, 5, $x + 50, $y + 15, $corps);

        $pdf->WriteHTMLCell(0, 5, $x + 120, $y + 20, 'Fait &agrave; Nkolfoulou1 le , ' . $dd->getDate() . ' ' . $dd->getMois(3) . ' ' . $dd->getYear());

        $pdf->setFont("Times", '', 12);
        $pdf->WriteHTMLCell(0, 5, $x + 120, $y + 25, '<b style="text-decoration:underline">LA DIRECTRICE</b>');
        if ($i === 3) {
            $pdf->AddPage();
            $y = PDF_Y;
            $i = 0;
        } else {
            $y += 95;
        }
    }
}

$pdf->OutPut();
