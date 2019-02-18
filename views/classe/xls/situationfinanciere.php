<?php

$spreadsheet = $excel->spreadsheet;
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'SITUATION FINANCIERE')
        ->setCellValue('A2', 'Classe : ' . $classe['NIVEAUHTML'] . ' ' . $classe['LIBELLE'])
        ->setCellValue('A3', 'Effectif : ' . $effectif)
        ->setCellValue('A4', "Total des frais &agrave; payer : " . moneyString($montanttotal) . ' fcfa');

$sheet->setCellValue('A5', "N°")
        ->setCellValue('B5', "Matricule")
        ->setCellValue('C5', 'Noms')
        ->setCellValue('D5', 'Pr&eacute;noms')
        ->setCellValue('E5', 'Redoublant')
        ->setCellValue('F5', "Total vers&eacute;")
        ->setCellValue('G5', "Solde");

if (!is_array($array_of_redoublants)) {
    $array_of_redoublants = array();
}
$i = 6;
$j = 1;
foreach ($soldes as $scol) {
    if (in_array($scol['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }
    if ($scol['MONTANTPAYE'] >= $montanfraisapplicable) {
        $code = "#C#";
        $bgcolor = "FF99FF99";
    } else {
        $code = "#D#";
        $bgcolor = "FFFF9999";
    }
    $sheet->setCellValue('A' . $i, $j)
            ->setCellValue('B' . $i, $scol['MATRICULE'])
            ->setCellValue('C' . $i, $scol['NOM'])
            ->setCellValue('D' . $i, $scol['PRENOM'])
            ->setCellValue('E' . $i, $redoublant)
            ->setCellValue('F' . $i, moneyString($scol['MONTANTPAYE']))
            ->setCellValue('G' . $i, moneyString($scol['MONTANTPAYE'] - $montanfraisapplicable))
            ->setCellValue('H' . $i, $code);
    $sheet->getStyle('A' . $i . ':H' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB($bgcolor);
    $i++;
    $j++;
}
setAutoSize($sheet, ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']);
$spreadsheet->setActiveSheetIndex(0);
$excel->save();
exit;
