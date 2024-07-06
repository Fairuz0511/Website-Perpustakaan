<?php
function terlambat($tgl_dateline, $tgl_kembali) {
    // Pecah tanggal untuk format dd-mm-yyyy atau yyyy-mm-dd
    $tgl_dateline_pecah = explode("-", $tgl_dateline);
    $tgl_dateline_pecah = $tgl_dateline_pecah[2]."-".$tgl_dateline_pecah[1]."-".$tgl_dateline_pecah[0];

    $tgl_kembali_pecah = explode("-", $tgl_kembali);
    $tgl_kembali_pecah = $tgl_kembali_pecah[2]."-".$tgl_kembali_pecah[1]."-".$tgl_kembali_pecah[0];

    // Menghitung selisih hari
    $selisih = strtotime($tgl_kembali_pecah) - strtotime($tgl_dateline_pecah);

    $selisih = $selisih / 86400; // 86400 detik = 1 hari

    if ($selisih >= 1) {
        $hasil_tgl = floor($selisih); // Pembulatan ke bawah
    } else {
        $hasil_tgl = 0;
    }
    return $hasil_tgl;
    }
?>
