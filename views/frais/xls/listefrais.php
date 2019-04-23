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

$sheet->setCellValue('A1', 'LISTE DES FRAIS');
$sheet->mergeCells("A1:F1");
$sheet->setCellValue('A5', "N°")
        ->setCellValue('B5', "Classe")
        ->setCellValue('C5', 'Description')
        ->setCellValue('D5', 'Montant')
        ->setCellValue('E5', 'Echéances');

$i = 6;
$j = 1;
foreach ($frais as $f) {
    $sheet->setCellValue('A' . $i, $j)
            ->setCellValue('B' . $i, strip_tags($f['NIVEAUHTML']))
            ->setCellValue('C' . $i, $f['DESCRIPTION'])
            ->setCellValue('D' . $i, $f['MONTANT'])
            ->setCellValue('E' . $i, date("d/m/Y", strtotime($f['ECHEANCES'])));
    $i++;
    $j++;
}
setAutoSize($sheet, ['A', 'B', 'C', 'D', 'E']);
$spreadsheet->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="liste_des_frais.xlsx"');
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
