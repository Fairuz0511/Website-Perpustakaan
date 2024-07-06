<?php
require_once '../../PHPExcel/Classes/PHPExcel.php'; // Adjust path as per your directory structure

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Your Name")
                             ->setLastModifiedBy("Your Name")
                             ->setTitle("Data Transaksi")
                             ->setSubject("Data Transaksi")
                             ->setDescription("Data transaksi perpustakaan dalam format Excel.")
                             ->setKeywords("excel php perpustakaan")
                             ->setCategory("Data Transaksi");

$sheet = $objPHPExcel->getActiveSheet();
$sheet->setTitle('Data Transaksi');

$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Judul');
$sheet->setCellValue('C1', 'NPM');
$sheet->setCellValue('D1', 'Nama');
$sheet->setCellValue('E1', 'Tanggal Pinjam');
$sheet->setCellValue('F1', 'Tanggal Kembali');
$sheet->setCellValue('G1', 'Terlambat');
$sheet->setCellValue('H1', 'Status');

$sql = "SELECT * FROM tb_transaksi";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $tgl_dateline2 = $data['tgl_kembali'];
        $tgl_kembali = date('Y-m-d');
        $lambat = terlambat($tgl_dateline2, $tgl_kembali);
        $denda = 1000;
        $denda1 = $lambat * $denda;

        // Pengecekan status
        if ($data['status'] == "Kembali") {
            $lambat = 0;
            $denda1 = 0;
        }

        $sheet->setCellValue('A' . $row, $row - 1);
        $sheet->setCellValue('B' . $row, $data['judul']);
        $sheet->setCellValue('C' . $row, $data['npm']);
        $sheet->setCellValue('D' . $row, $data['nama']);
        $sheet->setCellValue('E' . $row, $data['tgl_pinjam']);
        $sheet->setCellValue('F' . $row, $data['tgl_kembali']);
        $sheet->setCellValue('G' . $row, $lambat > 0 ? "$lambat hari (Rp $denda1)" : "Tidak Terlambat");
        $sheet->setCellValue('H' . $row, $data['status']);

        $row++;
    }
} else {
    echo "Tidak ada data yang ditemukan.";
    exit;
}

// Set header for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="laporan_transaksi_' . date('Y-m-d') . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

$koneksi->close();
?>
