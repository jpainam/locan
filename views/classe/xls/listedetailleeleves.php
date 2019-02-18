<?php

$spreadsheet = $excel->spreadsheet;
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Matricule')
        ->setCellValue('B1', 'Nom')
        ->setCellValue('C1', 'Prenom')
        ->setCellValue('D1', 'Date de Naiss')
        ->setCellValue('E1', 'Lieu de Naiss')
        ->setCellValue('F1', 'Sexe')
        ->setCellValue('G1', 'Redoublant')
        ->setCellValue('H1', 'Date Entr&eacute;e')
        ->setCellValue('I1', 'Provenance');

if (!is_array($array_of_redoublants)) {
    $array_of_redoublants = array();
}
$i = 2;
foreach ($eleves as $el) {
    if (in_array($el['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }
    $d = new DateFR($el['DATENAISS']);
    $sheet->setCellValue('A' . $i, $el['MATRICULE'])
            ->setCellValue('B' . $i, $el['NOM'])
            ->setCellValue('C' . $i, $el['PRENOM'])
            ->setCellValue('D' . $i, $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear())
            ->setCellValue('E' . $i, $el['LIEUNAISS'])
            ->setCellValue('F' . $i, $el['SEXE'])
            ->setCellValue('G' . $i, $redoublant)
            ->setCellValue('H' . $i, $el['DATEENTREE'])
            ->setCellValue('I' . $i, $el['PROVENANCE']);
    $i++;
}
$sheet->mergeCells("A1:F1");
setAutoSize($sheet, ["A", "B", "C", "D", "E", "F", "G", "H", "I"]);
$spreadsheet->setActiveSheetIndex(0);
$excel->save();
exit;
