<?php
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $koneksi->prepare("SELECT * FROM tb_anggota WHERE npm=?");
    $stmt->bind_param("s", $npm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        die("Data tidak ditemukan.");
    }
} else {
    die("NPM tidak ditemukan.");
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        Edit Data
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <form method="post">
                    <div class="form-group">
                        <label>NPM</label>
                        <input class="form-control" name="npm" value="<?php echo $data['npm']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" name="nama" value="<?php echo $data['nama']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input class="form-control" name="tempat_lahir" value="<?php echo $data['tempat_lahir']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input class="form-control" type="date" name="tgl_lahir" value="<?php echo $data['tgl_lahir']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <label class="radio-inline">
                            <input type="radio" value="L" name="jk" <?php echo ($data['jk'] == 'L') ? 'checked' : ''; ?>/> Laki-laki
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="P" name="jk" <?php echo ($data['jk'] == 'P') ? 'checked' : ''; ?>/> Perempuan
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Prodi</label>
                        <select class="form-control" name="prodi" required>
                            <option value="TI" <?php echo ($data['prodi'] == 'TI') ? 'selected' : ''; ?>>Teknik Informatika</option>
                        </select>
                    </div>

                    <div>
                        <input type="submit" name="update" value="Update" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update'])) {
    $new_npm = $_POST['npm']; // NPM baru
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $prodi = $_POST['prodi'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt_update = $koneksi->prepare("UPDATE tb_anggota SET 
        npm=?, 
        nama=?, 
        tempat_lahir=?, 
        tgl_lahir=?, 
        jk=?, 
        prodi=? 
        WHERE npm=?");

    $stmt_update->bind_param("sssssss", $new_npm, $nama, $tempat_lahir, $tgl_lahir, $jk, $prodi, $npm);
    $stmt_update->execute();

    if ($stmt_update) {
        echo "<script type='text/javascript'>
            alert('Data Berhasil Diupdate');
            window.location.href='index.php?page=anggota';
            </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Data Gagal Diupdate: " . $stmt_update->error . "');
            </script>";
    }
}
?>
