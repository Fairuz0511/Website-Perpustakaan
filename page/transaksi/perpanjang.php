<?php
$id = $_GET['id'];
$judul = $_GET['judul'];
$tgl_kembali = $_GET['tgl_kembali'];
$lambat = $_GET['lambat'];

if ($lambat > 7) {
?>
    <script type="text/javascript">
        alert("Peminjaman Buku Tidak Dapat Diperpanjang, Karena Sudah Lebih Dari 7 Hari. Kembalikan Terlebih Dahulu Dan Lakukan Peminjaman Ulang");
        window.location.href = "?page=transaksi";
    </script>
    <?php
} else {
    // Memecah tanggal kembali menjadi bagian-bagian tahun, bulan, hari
    list($tahun, $bulan, $hari) = explode("-", $tgl_kembali);
    // Membuat timestamp dari tanggal kembali
    $tgl_kembali_timestamp = mktime(0, 0, 0, $bulan, $hari, $tahun);
    // Menambahkan 7 hari ke tanggal kembali
    $next_7_hari = strtotime("+7 days", $tgl_kembali_timestamp);
    // Mengubah timestamp kembali menjadi format tanggal 'Y-m-d'
    $hari_next = date("Y-m-d", $next_7_hari);

    // Melakukan query untuk memperbarui tanggal kembali di database
    $sql = $koneksi->query("UPDATE tb_transaksi SET tgl_kembali='$hari_next' WHERE id='$id'");

    if ($sql) {
    ?>
        <script type="text/javascript">
            alert("Berhasil Memperpanjang Pinjaman Buku");
            window.location.href = "?page=transaksi";
        </script>
    <?php
    } else {
    ?>
        <script type="text/javascript">
            alert("Gagal Memperpanjang Buku");
            window.location.href = "?page=transaksi";
        </script>
<?php
    }
}
?>