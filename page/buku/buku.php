<?php

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

?>
<a href="?page=buku&aksi=tambah" class="btn btn-primary" style="margin-bottom: 8px;">Tambah Data</a>

<a a href="./laporan/laporan_buku_excel.php" class="btn btn-default  " style="margin-bottom: 8px"><i class="fa fa-print"></i>ExportToExcel</a>


<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Buku
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>ISBN</th>
                                <th>Jumlah Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                        
                            $sql = $koneksi->query("SELECT * FROM tb_buku ORDER BY id");

                            if ($sql) {
                                $no = 1;
                                while ($data = $sql->fetch_assoc()) {
                            ?>

                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['judul']; ?></td>
                                        <td><?php echo $data['pengarang']; ?></td>
                                        <td><?php echo $data['penerbit']; ?></td>
                                        <td><?php echo $data['isbn']; ?></td>
                                        <td><?php echo $data['jumlah_buku']; ?></td>
                                        <td>
                                            <a href="?page=buku&aksi=edit&id=<?php echo $data['id']; ?>" class="btn btn-info">Edit</a>
                                            <a onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" href="?page=buku&aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>

                            <?php 
                                }
                            } else {
                                echo "Error retrieving records: " . $koneksi->error;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
