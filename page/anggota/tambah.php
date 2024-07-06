<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Data
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">

                <form method="post">
                    <div class="form-group">
                        <label>NPM</label>
                        <input class="form-control" name="npm" required />
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" name="nama" required />
                    </div>

                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input class="form-control" name="tempat_lahir" required />
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input class="form-control" type="date" name="tgl_lahir" required />
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="L" name="jk"/> Laki-laki
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="P" name="jk"/> Perempuan
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Prodi</label>
                        <select class="form-control" name="prodi" required>
                            <option value="TI">Teknik Informatika</option>
                            <!--Tambahkan opsi untuk prodi lain jika ada-->
                        </select>
                    </div>

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
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $prodi = $_POST['prodi'];

    $sql = $koneksi->query("INSERT INTO tb_anggota (npm, nama, tempat_lahir, tgl_lahir, jk, prodi) 
    VALUES ('$npm', '$nama', '$tempat_lahir', '$tgl_lahir', '$jk', '$prodi')");

    if ($sql) {
        echo "<script type='text/javascript'>
            alert('Data Berhasil Disimpan');
            window.location.href='?page=anggota';
            </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Data Gagal Disimpan: " . $koneksi->error . "');
            </script>";
    }
}
?>
