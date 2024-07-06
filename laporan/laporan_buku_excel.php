<?php
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$filename = "laporan_buku_" . date('Y-m-d') . ".xls"; // Nama file Excel

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

echo "<h2>Laporan Buku</h2>";
echo "<table border='1'>";
echo "<tr>
        <th>NO</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Penerbit</th>
        <th>ISBN</th>
        <th>Jumlah Buku</th>
     </tr>";

$sql = $koneksi->query("SELECT * FROM tb_buku ORDER BY id");

if ($sql->num_rows > 0) {
    $no = 1;
    while ($data = $sql->fetch_assoc()) {
        echo "<tr>
                <td>$no</td>
                <td>" . $data['judul'] . "</td>
                <td>" . $data['pengarang'] . "</td>
                <td>" . $data['penerbit'] . "</td>
                <td>" . $data['isbn'] . "</td>
                <td>" . $data['jumlah_buku'] . "</td>
              </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6'>Data tidak tersedia</td></tr>";
}

echo "</table>";

$koneksi->close();
?>
