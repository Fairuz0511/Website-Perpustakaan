<?php
session_start();
error_reporting(0); 

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Memeriksa sesi admin atau user, jika tidak terdefinisi maka arahkan ke halaman login
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perpustakaan</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- DATA TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>

<body>
    <div id="wrapper">
        <!-- NAVIGATION -->
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Perpustakaan</a>
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
                <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
        </nav>
        <!-- END NAVIGATION -->

        <!-- SIDEBAR -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/img/icon.png" class="user-image img-responsive" />
                    </li>
                    <li><a href="index.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a></li>
                    <li><a href="?page=anggota"><i class="fa fa-users fa-3x"></i> Data Anggota</a></li>
                    <li><a href="?page=buku"><i class="fa fa-book fa-3x"></i> Data Buku</a></li>
                    <li><a href="?page=transaksi"><i class="fa fa-exchange fa-3x"></i> Transaksi</a></li>
                    <li><a href="blank.html"><i class="fa fa-square-o fa-3x"></i> Blank Page</a></li>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR -->

        <!-- MAIN CONTENT -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : '';
                        $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

                        if ($page == "buku") {
                            if ($aksi == "") {
                                include "page/buku/buku.php"; // Halaman utama data buku
                            } elseif ($aksi == "tambah") {
                                include "page/buku/tambah.php"; // Halaman tambah buku
                            } elseif ($aksi == "edit") {
                                include "page/buku/edit.php"; // Halaman edit buku
                            } elseif ($aksi == "hapus") {
                                include "page/buku/hapus.php"; // Halaman hapus buku
                            }
                        } elseif ($page == "anggota") {
                            if ($aksi == "") {
                                include "page/anggota/anggota.php"; // Halaman utama data anggota
                            } elseif ($aksi == "tambah") {
                                include "page/anggota/tambah.php"; // Halaman tambah anggota
                            } elseif ($aksi == "edit") {
                                include "page/anggota/edit.php"; // Halaman edit anggota
                            } elseif ($aksi == "hapus") {
                                include "page/anggota/hapus.php"; // Halaman hapus anggota
                            }
                        } elseif ($page == "transaksi") {
                            if ($aksi == "") {
                                include "page/transaksi/transaksi.php"; // Halaman utama transaksi
                            } elseif ($aksi == "tambah") {
                                include "page/transaksi/tambah.php"; // Halaman tambah transaksi
                            } elseif ($aksi == "kembali") {
                                include "page/transaksi/kembali.php"; // Halaman pengembalian buku
                            } elseif ($aksi == "perpanjang") {
                                include "page/transaksi/perpanjang.php"; // Halaman perpanjang pinjaman
                            }
                        } else {
                            // Halaman default jika parameter page tidak ada atau tidak valid
                            include "dashboard.php";
                        }
                        ?>
                    </div>
                </div>
                <!-- /. ROW  -->
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- END MAIN CONTENT -->

       
        <!-- END FOOTER -->
    </div>
    <!-- /. WRAPPER -->

    <!-- SCRIPTS -->
    <!-- JQUERY -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
</body>

</html>
