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

$sheet->setCellValue('A1', 'SITUATION FINANCIERE')
        ->setCellValue('A2', 'Classe : ' . strip_tags($classe['NIVEAUHTML']))
        ->setCellValue('A3', 'Effectif : ' . $effectif)
        ->setCellValue('A4', "Total des frais &agrave; payer : " . moneyString($montanttotal) . ' fcfa');
$sheet->mergeCells("A1:F1");
$sheet->mergeCells("A2:F2");
$sheet->mergeCells("A3:F3");
$sheet->mergeCells("A4:F4");
$sheet->setCellValue('A5', "N°")
        ->setCellValue('B5', "Matricule")
        ->setCellValue('C5', 'Noms')
        ->setCellValue('D5', 'Prénoms')
        ->setCellValue('E5', 'Redoublant')
        ->setCellValue('F5', "Total versé")
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
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="situation_financiere.xlsx"');
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
