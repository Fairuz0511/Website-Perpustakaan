<?php
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>

<a href="?page=anggota&aksi=tambah" class="btn btn-primary" style="margin-bottom: 8px;">Tambah Data</a>

<a a href="./laporan/laporan_anggota_excel.php" class="btn btn-default  " style="margin-bottom: 8px"><i class="fa fa-print"></i>ExportToExcel</a>


<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Anggota
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NPM</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Prodi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $koneksi->query("SELECT * FROM tb_anggota");

                            $no = 1;
                            while ($data = $sql->fetch_assoc()) {
                                $jk = ($data['jk'] == 'P') ? "Perempuan" : "Laki-laki";
                                $prodi = "Teknik Informatika";
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['npm']; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['tempat_lahir']; ?></td>
                                    <td><?php echo $data['tgl_lahir']; ?></td>
                                    <td><?php echo $jk; ?></td>
                                    <td><?php echo $prodi; ?></td>
                                    <td>
                                        <a href="?page=anggota&aksi=edit&npm=<?php echo $data['npm']; ?>" class="btn btn-info">Edit</a>
                                        <a onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" href="?page=anggota&aksi=hapus&npm=<?php echo $data['npm']; ?>" class="btn btn-danger">Hapus</a>

                                        
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
