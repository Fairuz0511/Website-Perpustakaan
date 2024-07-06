<?php
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $koneksi->prepare("DELETE FROM tb_anggota WHERE npm=?");
    $stmt->bind_param("s", $npm);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script type='text/javascript'>
            alert('Data Berhasil Dihapus');
            window.location.href='index.php?page=anggota';
            </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Data Gagal Dihapus: " . $stmt->error . "');
            window.location.href='index.php?page=anggota';
            </script>";
    }

    $stmt->close();
} else {
    echo "<script type='text/javascript'>
        alert('NPM tidak ditemukan');
        window.location.href='index.php?page=anggota';
        </script>";
}

$koneksi->close();
?>
