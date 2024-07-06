<?php
session_start();
error_reporting(E_ALL);

$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>


                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-red set-icon">
                                <i class="fa fa-book"></i>
                            </span>
                            <div class="text-box">
                                <p class="main-text">
                                    <?php
                                    $query_buku = $koneksi->query("SELECT COUNT(*) as total_buku FROM tb_buku");
                                    $data_buku = $query_buku->fetch_assoc();
                                    echo $data_buku['total_buku'];
                                    ?>
                                </p>
                                <p class="text-muted">Total Buku</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-blue set-icon">
                                <i class="fa fa-users"></i>
                            </span>
                            <div class="text-box">
                                <p class="main-text">
                                    <?php
                                    $query_anggota = $koneksi->query("SELECT COUNT(*) as total_anggota FROM tb_anggota");
                                    $data_anggota = $query_anggota->fetch_assoc();
                                    echo $data_anggota['total_anggota'];
                                    ?>
                                </p>
                                <p class="text-muted">Total Anggota</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-green set-icon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <div class="text-box">
                                <p class="main-text">
                                    <?php
                                    $query_transaksi = $koneksi->query("SELECT COUNT(*) as total_transaksi FROM tb_transaksi");
                                    $data_transaksi = $query_transaksi->fetch_assoc();
                                    echo $data_transaksi['total_transaksi'];
                                    ?>
                                </p>
                                <p class="text-muted">Total Transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Grafik Data Buku
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    <!-- SCRIPTS -AT THE BOTTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

    <script>
        $(document).ready(function() {
            // Morris.js Charts sample data for SB Admin template

            Morris.Bar({
                element: 'morris-bar-chart',
                data: [{
                        y: '2010',
                        a: 100,
                        b: 90
                    },
                    {
                        y: '2011',
                        a: 75,
                        b: 65
                    },
                    {
                        y: '2012',
                        a: 50,
                        b: 40
                    },
                    {
                        y: '2013',
                        a: 75,
                        b: 65
                    },
                    {
                        y: '2014',
                        a: 50,
                        b: 40
                    },
                    {
                        y: '2015',
                        a: 75,
                        b: 65
                    },
                    {
                        y: '2016',
                        a: 100,
                        b: 90
                    }
                ],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Total Buku', 'Total Transaksi'],
                hideHover: 'auto',
                resize: true
            });

        });
    </script>
</body>

</html>
