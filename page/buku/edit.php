<?php

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$tampil = null;

// Periksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    // Dapatkan nilai 'id' dari URL
    $id = $_GET['id'];
    
    // Mengambil data buku berdasarkan ID
    $stmt = $koneksi->prepare("SELECT * FROM tb_buku WHERE id = ?");    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Periksa apakah data buku ditemukan
    if ($result->num_rows > 0) {
        // Ambil data dari hasil query
        $tampil = $result->fetch_assoc();
    } else {
        echo "Data buku tidak ditemukan.";
        exit;
    }
} else {
    echo "Parameter 'id' tidak ditemukan di URL.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $id = $_POST['id']; // Pastikan ID diambil dari form hidden input
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $jumlah = $_POST['jumlah'];
    $lokasi = $_POST['lokasi'];
    $tanggal = $_POST['tanggal'];

    // Debugging: Tampilkan nilai lokasi untuk memastikan sudah benar
    // echo "Lokasi yang dipilih: $lokasi";

    // Sisipkan nilai lokasi ke dalam pernyataan SQL
    $stmt = $koneksi->prepare("UPDATE tb_buku SET judul=?, pengarang=?, penerbit=?, tahun_terbit=?, isbn=?, jumlah_buku=?, lokasi=?, tgl_input=? WHERE id=?");
    $stmt->bind_param("sssssiisi", $judul, $pengarang, $penerbit, $tahun, $isbn, $jumlah, $lokasi, $tanggal, $id);

    // Eksekusi pernyataan SQL
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href='?page=buku';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data buku: " . $koneksi->error . "');</script>";
    }
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
                    <input type="hidden" name="id" value="<?php echo isset($tampil['id']) ? $tampil['id'] : ''; ?>" />
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="form-control" name="judul" value="<?php echo isset($tampil['judul']) ? $tampil['judul'] : ''; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input class="form-control" name="pengarang" value="<?php echo isset($tampil['pengarang']) ? $tampil['pengarang'] : ''; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Penerbit</label>
                        <input class="form-control" name="penerbit" value="<?php echo isset($tampil['penerbit']) ? $tampil['penerbit'] : ''; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <select class="form-control" name="tahun" required>
                            <?php
                            $tahun_sekarang = date("Y");
                            for ($i = $tahun_sekarang - 40; $i <= $tahun_sekarang; $i++) {
                                if ($tampil['tahun_terbit'] == $i) {
                                    echo "<option value='$i' selected>$i</option>";
                                } else {
                                    echo "<option value='$i'>$i</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ISBN</label>
                        <input class="form-control" name="isbn" value="<?php echo isset($tampil['isbn']) ? $tampil['isbn'] : ''; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Jumlah Buku</label>
                        <input class="form-control" type="number" name="jumlah" value="<?php echo isset($tampil['jumlah_buku']) ? $tampil['jumlah_buku'] : ''; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Lokasi</label>
                        <select class="form-control" name="lokasi" required>
                            <option value="Rak 1" <?php if (isset($tampil['lokasi']) && $tampil['lokasi'] == "Rak 1") echo 'selected' ?>>Rak 1</option>
                            <option value="Rak 2" <?php if (isset($tampil['lokasi']) && $tampil['lokasi'] == "Rak 2") echo 'selected' ?>>Rak 2</option>
                            <option value="Rak 3" <?php if (isset($tampil['lokasi']) && $tampil['lokasi'] == "Rak 3") echo 'selected' ?>>Rak 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Input</label>
                        <input class="form-control" name="tanggal" type="date" value="<?php echo isset($tampil['tgl_input']) ? $tampil['tgl_input'] : ''; ?>" required />
                    </div>

                    <div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
