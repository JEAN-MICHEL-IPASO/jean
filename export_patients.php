<?php
require 'autoload.php';
include 'db.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Patients");
$sheet->fromArray(['Nom', 'Âge', 'Sexe', 'Téléphone'], NULL, 'A1');

$res = $conn->query("SELECT nom, age, sexe, telephone FROM patients");
$rowIndex = 2;
while ($row = $res->fetch_row()) {
  $sheet->fromArray($row, NULL, 'A'. $rowIndex++);
}

$writer = new Xlsx($spreadsheet);
$filename = "patients_export.xlsx";
$writer->save($filename);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
readfile($filename);
unlink($filename);
exit;
?>
