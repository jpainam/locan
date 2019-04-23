<?php

#https://phpspreadsheet.readthedocs.io/en/develop/topics/recipes
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$spreadsheet->getDefaultStyle()->getFont()->setName("Verdana");
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'LISTE DES ELEVES DE ' . strip_tags($classe['NIVEAUHTML']));
$sheet->mergeCells("A1:F1");
$style = array(
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    )
);
$sheet->getStyle("A1")->applyFromArray($style);

$sheet->setCellValue("A2", "N°")
        ->setCellValue("B2", "Matricule")
        ->setCellValue("C2", "Noms")
        ->setCellValue("D2", "Prénoms")
        ->setCellValue("E2", "Date Naiss")
        ->setCellValue("F2", "Redoublant")
        ->setCellValue("G2", "Sexe")
        ->setCellValue("H2", "Lieu de Naissance")
        ->setCellValue("I2", "Provenance")
        ->setCellValue("J2", "Résidence");
$sheet->getStyle("A1:J2")->getFont()->setBold(true);
$sheet->getStyle('A2:J2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

$sheet->getStyle('A2:J2')->getFill()->getStartColor()->setARGB('FFC4BD97');


if (!is_array($array_of_redoublants)) {
    $array_of_redoublants = array();
}
$i = 3;
$j = 1;
foreach ($eleves as $el) {
    if (in_array($el['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }

    $sheet->setCellValue('A' . $i, $j)
            ->setCellValue('B' . $i, $el['MATRICULE'])
            ->setCellValue('C' . $i,  preg_replace('/(\'|&#0*39;)/', '\'', $el['NOM']))
            ->setCellValue('D' . $i, preg_replace('/(\'|&#0*39;)/', '\'', $el['PRENOM']))
            ->setCellValue('E' . $i, date("d/m/Y", strtotime($el['DATENAISS'])))
            ->setCellValue('F' . $i, $redoublant)
            ->setCellValue("G" . $i, $el['SEXE'])
            ->setCellValue("H" . $i, $el['LIEUNAISS'])
            ->setCellValue("I" . $i, $el['FK_PROVENANCE'])
            ->setCellValue("J" . $i, $el['RESIDENCE'])
            ;
    $i++;
    $j++;
}

setAutoSize($sheet, ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"]);
$sheet->setTitle("Liste des Eleves");
$spreadsheet->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="liste_des_eleves.xlsx"');
header('Cache-Control: max-age=0');
# If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

# If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
