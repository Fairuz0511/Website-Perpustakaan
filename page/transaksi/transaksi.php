<?php

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

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    $id = $_GET['id'];

    if ($aksi == 'kembali') {
        $sql1 = $koneksi->query("UPDATE tb_transaksi SET status='Kembali' WHERE id='$id'");
        
        if ($sql1) {
            // Mengembalikan jumlah buku
            $judul = $_GET['judul'];
            $sql2 = $koneksi->query("UPDATE tb_buku SET jumlah_buku = (jumlah_buku + 1) WHERE judul = '$judul'");
            
            if ($sql2) {
                ?>
                <script type="text/javascript">
                    alert("Proses Mengembalikan Buku Telah Berhasil");
                    window.location.href = "?page=transaksi";
                </script>
                <?php
            } else {
                echo "Error updating record in tb_buku: " . $koneksi->error;
            }
        } else {
            echo "Error updating record in tb_transaksi: " . $koneksi->error;
        }
    } elseif ($aksi == 'perpanjang') {
        $sql = $koneksi->query("SELECT tgl_kembali FROM tb_transaksi WHERE id='$id'");
        $data = $sql->fetch_assoc();
        $tgl_kembali_lama = $data['tgl_kembali'];
        $tgl_kembali_baru = date('Y-m-d', strtotime($tgl_kembali_lama . ' + 7 days'));

        $koneksi->query("UPDATE tb_transaksi SET tgl_kembali='$tgl_kembali_baru' WHERE id='$id'");
        header("Location: ?page=transaksi");
        exit;
    }
}

?>
<a href="?page=transaksi&aksi=tambah" class="btn btn-primary" style="margin-bottom: 8px;"><i class="fa fa-plus"></i> Tambah Data</a>
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Transaksi
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>NPM</th>
                                <th>Nama</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Terlambat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_transaksi");

                            if ($sql->num_rows > 0) {
                                while ($data = $sql->fetch_assoc()) {
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
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['judul']; ?></td>
                                        <td><?php echo $data['npm']; ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td><?php echo $data['tgl_pinjam']; ?></td>
                                        <td><?php echo $data['tgl_kembali']; ?></td>
                                        <td>
                                            <?php
                                            if ($lambat > 0) {
                                                echo "<font color='red'>$lambat hari<br>(Rp $denda1)</font>";
                                            } else {
                                                echo $lambat . " Hari";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $data['status']; ?></td>
                                        <td>
                                            <a href="?page=transaksi&aksi=kembali&id=<?php echo $data['id']; ?>&judul=<?php echo $data['judul']; ?>" class="btn btn-info">Kembali</a>
                                            <a href="?page=transaksi&aksi=perpanjang&id=<?php echo $data['id']; ?>&judul=<?php echo $data['judul']; ?>&lambat=<?php echo $lambat; ?>&tgl_kembali=<?php echo $data['tgl_kembali']; ?>" class="btn btn-danger">Perpanjang</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                echo "<tr><td colspan='9'>Tidak ada data yang ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
