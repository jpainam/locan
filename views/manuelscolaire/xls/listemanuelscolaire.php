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

$sheet->setCellValue('A1', 'LISTE DES MANUELS SCOLAIRES');
$sheet->mergeCells("A1:F1");
$sheet->setCellValue('A5', "N°")
        ->setCellValue('B5', "Titre du manuel")
        ->setCellValue('C5', 'Editeurs')
        ->setCellValue('D5', 'Auteurs')
        ->setCellValue('E5', 'Prix');

$i = 6;
$j = 1;
foreach ($manuels as $m) {
    $sheet->setCellValue('A' . $i, $j)
            ->setCellValue('B' . $i, $m['TITRE'])
            ->setCellValue('C' . $i, $m['EDITEURS'])
            ->setCellValue('D' . $i, $m['AUTEURS'])
            ->setCellValue('E' . $i, $m['PRIX']);
    $i++;
    $j++;
}
setAutoSize($sheet, ['A', 'B', 'C', 'D', 'E']);
$spreadsheet->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="liste_des_manuels_scolaires.xlsx"');
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
