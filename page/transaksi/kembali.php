<?php

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$id = $_GET['id'];
$judul = $_GET['judul'];

// Melakukan query untuk memperbarui status transaksi
$sql1 = $koneksi->query("UPDATE tb_transaksi SET status = 'kembali' WHERE id = '$id'");

if ($sql1) {
    // Melakukan query untuk memperbarui jumlah buku
    $sql2 = $koneksi->query("UPDATE tb_buku SET jumlah_buku = (jumlah_buku + 1) WHERE judul = '$judul'");

    if ($sql2) {
        ?>
        <script type="text/javascript">
            alert("Proses Mengembalikan Buku Telah Berhasil");
            window.location.href = "?page=transaksi";
        </script>
        <?php
    } else {
        echo "Error updating record: " . $koneksi->error;
    }
} else {
    echo "Error updating record: " . $koneksi->error;
}

?>
