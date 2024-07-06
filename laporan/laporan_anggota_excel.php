<?php
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$filename = "anggota_excel-" . date('Y-m-d') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

echo "<h2>Laporan Anggota</h2>";
echo "<table border='1'>";
echo "<tr>
        <th>NO</th>
        <th>NPM</th>
        <th>Nama</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Program Studi</th>
      </tr>";

$no = 1;

$sql = $koneksi->query("SELECT * FROM tb_anggota");
if ($sql->num_rows > 0) {
    while ($data = $sql->fetch_assoc()) {
        // Ubah kondisi jenis kelamin sesuai dengan data yang benar di database
        $jk = ($data['jk'] == 'P') ? "Perempuan" : "Laki-laki";
        
        // Ambil nilai program studi dari data yang sesuai di database
        $prodi = $data['prodi']; // Sesuaikan dengan nama kolom yang tepat di database

        echo "<tr>
                <td>$no</td>
                <td>" . $data['npm'] . "</td>
                <td>" . $data['nama'] . "</td>
                <td>" . $data['tempat_lahir'] . "</td>
                <td>" . $data['tgl_lahir'] . "</td>
                <td>$jk</td>
                <td>$prodi</td>
              </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='7'>Data tidak tersedia</td></tr>";
}

echo "</table>";

$koneksi->close();
?>
