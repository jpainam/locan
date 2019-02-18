<?php
$pdf->AddPage();
/* 
 *  courier : Courier
    courierB : Courier Bold
    courierBI : Courier Bold Italic
    courierI : Courier Italic
    helvetica : Helvetica
    helveticaB : Helvetica Bold
    helveticaBI : Helvetica Bold Italic
    helveticaI : Helvetica Italic
    symbol : Symbol
    times : Times New Roman
    timesB : Times New Roman Bold
    timesBI : Times New Roman Bold Italic
    timesI : Times New Roman Italic
    zapfdingbats : Zapf Dingbats
 */
$tab = ["courier", "helvetica", "symbol", "times", "zapfdingbats", 
      "dejavusans", "freemono", "freesans", "freeserif", "pdfatimesi", ""];
for($i = 1; $i <= count($tab); $i++){
    $pdf->setFont($tab[$i - 1], '', 13);
    $pdf->WriteHTMLCell(0, 5, 10, $i*7 + FIRST_TITLE , $tab[$i-1]." Un exemple de font");
    
}
$pdf->Output();
