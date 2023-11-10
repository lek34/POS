<?php
// Include necessary files and establish a database connection
include_once('config.php');
include('../../../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Select data from a table
$query = "SELECT * FROM barang";
$result = $db->query($query);

$id_akun = $_GET['id_akun'];

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

//Ambil Nama Akun
$queryAkun = "SELECT ha.id_akun, akun.nama_akun
                FROM history_akun ha
                INNER JOIN akun ON akun.id_akun = ha.id_akun
                WHERE ha.id_akun = $id_akun LIMIT 1;";
$resultAkun = $db->query($queryAkun);
$rowAkun = $resultAkun->fetch_assoc();
$nama_akun = $rowAkun['nama_akun'];


// Output data from each row to Excel
$rowIndex = 1;
// Define the row index for the second merged cell
$rowIndex2 = 2;

// Define the range to merge (from column A to column E) for the cell
$mergeRange = "A{$rowIndex}:E{$rowIndex}";
// Define the range to merge (from column A to column E) for the second cell
$mergeRange2 = "A{$rowIndex2}:E{$rowIndex2}";

// Set the value for the merged cell
$activeWorksheet->setCellValue('A' . $rowIndex, "KAS BESAR " . $nama_akun);
// Set the value for the second merged cell
$activeWorksheet->setCellValue('A' . $rowIndex2, "MODAL");

// Merge the cells in the defined range
$activeWorksheet->mergeCells($mergeRange);

// Merge the cells in the second defined range
$activeWorksheet->mergeCells($mergeRange2);

// Get the cell's style and alignment for the merged range
$cellStyle = $activeWorksheet->getStyle($mergeRange);
$alignment = $cellStyle->getAlignment();

// Set horizontal and vertical alignment for the merged range
$alignment->setHorizontal(Alignment::HORIZONTAL_CENTER);
$alignment->setVertical(Alignment::VERTICAL_CENTER);

// Get the cell's style and alignment for the second merged range
$cellStyle2 = $activeWorksheet->getStyle($mergeRange2);
$alignment2 = $cellStyle2->getAlignment();

// Set horizontal and vertical alignment for the second merged range
$alignment2->setHorizontal(Alignment::HORIZONTAL_CENTER);
$alignment2->setVertical(Alignment::VERTICAL_CENTER);

// Calculate the number of columns
$columnCount = count(range('A', 'E')); // Assuming you have columns A to E

// Set the headers for the next row
$headerRowIndex = 3;
$activeWorksheet->setCellValue('A' . $headerRowIndex, "Tanggal");
$activeWorksheet->setCellValue('B' . $headerRowIndex, "Debit");
$activeWorksheet->setCellValue('C' . $headerRowIndex, "Kredit");
$activeWorksheet->setCellValue('D' . $headerRowIndex, "Saldo");
$activeWorksheet->setCellValue('E' . $headerRowIndex, "Keterangan");

// Get the cell's style and alignment for the merged range
$cellStyle3 = $activeWorksheet->getStyle($headerRowIndex);
$alignment3 = $cellStyle->getAlignment();

// Set horizontal and vertical alignment for the second merged range
$alignment3->setHorizontal(Alignment::HORIZONTAL_CENTER);

$rowData = 4;

//Ambil Data
$queryData = "SELECT
                history_akun.*,
                pembelian.no_faktur AS pembelian_no_faktur,
                penjualan.no_faktur AS penjualan_no_faktur,
                cash_keluar.bukti_keluar AS keluar_no_faktur,
                cash_masuk.bukti_masuk AS masuk_no_faktur,
                akun.nama_akun
                FROM
                history_akun
                LEFT JOIN
                pembelian ON history_akun.id_pembelian = pembelian.id_pembelian
                LEFT JOIN
                penjualan ON history_akun.id_penjualan = penjualan.id_penjualan
                LEFT JOIN
                akun ON history_akun.id_akun = akun.id_akun
                LEFT JOIN
                cash_keluar ON history_akun.id_ckeluar = cash_keluar.id_ckeluar
                LEFT JOIN
                cash_masuk ON history_akun.id_cmasuk = cash_masuk.id_cmasuk
                WHERE
                history_akun.id_akun = $id_akun;";



$resultData = $db->query($queryData);

while ($row = $resultData->fetch_assoc()) {
     // Set cell values in the Excel worksheet
     $activeWorksheet->setCellValue('A' . $rowData, $row['tanggal']);
     $activeWorksheet->setCellValue('B' . $rowData, $row['debit']);
     $activeWorksheet->setCellValue('C' . $rowData, $row['kredit']);
     $activeWorksheet->setCellValue('D' . $rowData, $row['saldo']);
     $activeWorksheet->setCellValue('E' . $rowData, $row['Keterangan']);

    $rowData++;
}

// Optionally, you can style the merged cell (e.g., applying borders)
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];

// Auto-size columns
for ($col = 'A'; $col <= 'E'; $col++) {
    $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
}

$activeWorksheet->getStyle($mergeRange)->applyFromArray($styleArray);
$activeWorksheet->getStyle($mergeRange2)->applyFromArray($styleArray);

// Set appropriate headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data.xlsx"');
header('Cache-Control: max-age=0');  // Prevent caching

// Output the Excel file to the browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$connection->close();
?>
