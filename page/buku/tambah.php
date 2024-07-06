<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Data
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">

                <form method="post">
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="form-control" name="judul" required />
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input class="form-control" name="pengarang" required />
                    </div>

                    <div class="form-group">
                        <label>Penerbit</label>
                        <input class="form-control" name="penerbit" required />
                    </div>

                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <select class="form-control" name="tahun" required>
                            <?php
                            $tahun = date("Y");
                            for ($i = $tahun - 40; $i <= $tahun; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ISBN</label>
                        <input class="form-control" name="isbn" required />
                    </div>

                    <div class="form-group">
                        <label>Jumlah Buku</label>
                        <input class="form-control" type="number" name="jumlah" required />
                    </div>

                    <div class="form-group">
                        <label>Lokasi</label>
                        <select class="form-control" name="lokasi" required>
                            <option>Rak 1</option>
                            <option>Rak 2</option>
                            <option>Rak 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Input</label>
                        <input class="form-control" name="tanggal" type="date" required />
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
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $jumlah = $_POST['jumlah'];
    $lokasi = $_POST['lokasi'];
    $tanggal = $_POST['tanggal'];

    // Debugging: Tampilkan data yang diterima dari form
    echo "Data yang diterima: <br>";
    echo "Judul: $judul<br>";
    echo "Pengarang: $pengarang<br>";
    echo "Penerbit: $penerbit<br>";
    echo "Tahun: $tahun<br>";
    echo "ISBN: $isbn<br>";
    echo "Jumlah: $jumlah<br>";
    echo "Lokasi: $lokasi<br>";
    echo "Tanggal: $tanggal<br>";

    // Query insert data ke database
    $sql = $koneksi->query("INSERT INTO tb_buku (judul, pengarang, penerbit, tahun_terbit, isbn, jumlah_buku, lokasi, tgl_input) VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$isbn', '$jumlah', '$lokasi', '$tanggal')");

    if ($sql) {
        echo "<script type='text/javascript'>
            alert('Data Berhasil Disimpan');
            window.location.href='?page=buku';
            </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Data Gagal Disimpan: " . $koneksi->error . "');
            </script>";
        
    }
}
?>