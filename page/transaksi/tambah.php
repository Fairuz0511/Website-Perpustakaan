<?php

error_reporting();

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

function terlambat($tgl_dateline, $tgl_kembali) {
    $tgl_dateline = new DateTime($tgl_dateline);
    $tgl_kembali = new DateTime($tgl_kembali);
    $selisih = $tgl_kembali->diff($tgl_dateline)->days;

    if ($tgl_kembali > $tgl_dateline) {
        return $selisih;
    } else {
        return 0;
    }
}

// Tanggal Pinjam dan Tanggal Kembali Otomatis
$tgl_pinjam = date("Y-m-d"); // format tanggal harus Y-m-d untuk input type date
$tujuh_hari = mktime(0, 0, 0, date("n"), date("j")+7, date("Y"));
$tgl_kembali = date('Y-m-d', $tujuh_hari);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Data
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">

                <form method="POST" action="">
                    <div class="form-group">
                        <label>Buku</label>
                        <select class="form-control" name="buku">
                            <?php
                            $sql = $koneksi->query("SELECT * FROM tb_buku ORDER BY id");
                            while ($data = $sql->fetch_assoc()) {
                                $id = $data['id'];
                                $judul = $data['judul'];
                                echo "<option value='$id.$judul'>$judul</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <select class="form-control" name="nama">
                            <?php
                            $sql = $koneksi->query("SELECT * FROM tb_anggota ORDER BY npm");
                            while ($data = $sql->fetch_assoc()) {
                                $npm = $data['npm'];
                                $nama = $data['nama'];
                                echo "<option value='$npm.$nama'>$npm - $nama</option>"; // Tambahkan npm - nama
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input class="form-control" type="date" name="tgl_pinjam" value="<?= $tgl_pinjam ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input class="form-control" type="date" name="tgl_kembali" value="<?= $tgl_kembali ?>" required />
                    </div>

                    <!-- <div class="form-group">
                        <label>Prodi</label>
                        <select class="form-control" name="prodi" required>
                            <option value="TI">Teknik Informatika</option>
                        </select>
                    </div> -->

                    <div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" />
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['simpan'])) {
    $buku = $_POST['buku'];
    $pecah_buku = explode(".", $buku);
    $id_buku = $pecah_buku[0];
    $judul_buku = $pecah_buku[1];

    $nama = $_POST['nama'];
    $pecah_nama = explode(".", $nama);
    $npm_anggota = $pecah_nama[0];
    $nama_anggota = $pecah_nama[1];

    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    // $prodi = $_POST['prodi'];

    // Query untuk memeriksa sisa stok buku
    $sql_cek_stok = $koneksi->query("SELECT * FROM tb_buku WHERE judul = '$judul_buku'");
    while ($data = $sql_cek_stok->fetch_assoc()) {
        $sisa = $data['jumlah_buku'];

        if ($sisa == 0) {
            ?>
            <script type="text/javascript">
                alert("Stok Buku Habis, Transaksi Tidak Dapat Dilakukan, Silakan Tambah Stok Buku Terlebih Dahulu");
                window.location.href="?page=transaksi&aksi=tambah";
            </script>
            <?php
            exit; // Hentikan eksekusi script jika stok buku habis
        } else {
            // Mengurangi jumlah stok buku
            $sisa_stok = $sisa - 1;
            $koneksi->query("UPDATE tb_buku SET jumlah_buku = '$sisa_stok' WHERE judul = '$judul_buku'");

            // Menyimpan data transaksi ke dalam tabel tb_transaksi
            $koneksi->query("INSERT INTO tb_transaksi (judul, npm, nama, tgl_pinjam, tgl_kembali, status) VALUES ('$judul_buku', '$npm_anggota', '$nama_anggota', '$tgl_pinjam', '$tgl_kembali', 'Pinjam')");

            ?>
            <script type="text/javascript">
                alert("Data Berhasil Disimpan");
                window.location.href="?page=transaksi";
            </script>
            <?php
        }
    }
}
?>
