<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$spreadsheet = new Spreadsheet();
$spreadsheet->getDefaultStyle()->getFont()->setName("Verdana");
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
$sheet = $spreadsheet->getActiveSheet();

$titre = 'LISTE DES ELEVES DE ' . $classe['NIVEAUHTML'] . ' ' . $classe['LIBELLE'];
$sheet->setCellValue('A1', $titre);

if (!is_array($array_of_redoublants)) {
    $array_of_redoublants = array();
}
$i = 1;
foreach ($eleves as $el) {
    if (in_array($el['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }
    
    $sheet->setCellValue('B' . $i, $el['MATRICULE'])
            ->setCellValue('C' . $i, $el['NOM'])
            ->setCellValue('D' . $i, $el['PRENOM'])
            ->setCellValue('E' . $i, date("d/m/Y", strtotime($el['DATENAISS'])))
            ->setCellValue('F' . $i, $redoublant);
    $i++;
}
$sheet->mergeCells("A1:F1");
setAutoSize($sheet, ["A", "B", "C", "D", "E", "F"]);
$spreadsheet->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rapport.xls"');
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
