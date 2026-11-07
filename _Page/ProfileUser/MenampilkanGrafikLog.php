<?php
    header('Content-Type: application/json; charset=utf8');
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['periode_grafik'])){
        $periode_grafik="Tahunan";
    }else{
        $periode_grafik=$_POST['periode_grafik'];
    }
    $id_akses=$SessionIdAkses;
    if(empty($_POST['kategori_log'])){
        $kategori_log="";
    }else{
        $kategori_log=$_POST['kategori_log'];
    }
    if(empty($_POST['tahun_grafik'])){
        $tahun_grafik=date('Y');
    }else{
        $tahun_grafik=$_POST['tahun_grafik'];
    }
    if(empty($_POST['bulan_grafik'])){
        $bulan_grafik=date('m');
    }else{
        $bulan_grafik=$_POST['bulan_grafik'];
    }
    $BulanTahun="$tahun_grafik-$bulan_grafik";
    // Prepared Statement: hitung log untuk tiap periode grafik.
    if (empty($kategori_log)) {
        $stmtLogCount = mysqli_prepare($Conn, "SELECT COUNT(*) AS total FROM log WHERE waktu LIKE ?");
    } else {
        $stmtLogCount = mysqli_prepare($Conn, "SELECT COUNT(*) AS total FROM log WHERE kategori=? AND waktu LIKE ?");
    }
    if($periode_grafik=="Tahunan"){
        $a=1;
        $b=12;
        for ( $i =$a; $i<=$b; $i++ ){
            //Zero pading
            $BulanNomor = sprintf("%02d", $i);
            $BulanList = array(
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            );
            $NamaBulan=$BulanList[$BulanNomor];
            $KeywordGrafik="$tahun_grafik-$BulanNomor";
            $periodPattern = "%$KeywordGrafik%";
            if (empty($kategori_log)) {
                mysqli_stmt_bind_param($stmtLogCount, "s", $periodPattern);
            } else {
                mysqli_stmt_bind_param($stmtLogCount, "ss", $kategori_log, $periodPattern);
            }
            mysqli_stmt_execute($stmtLogCount);
            $JumlahSemuaRad = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($stmtLogCount))['total'] ?? 0);
            $data [] = array(
                'x' => $NamaBulan,
                'y' => $JumlahSemuaRad
            );
        }
    }else{
        $a=1;
        $b=cal_days_in_month(CAL_GREGORIAN, $bulan_grafik, $tahun_grafik);
        for ( $i =$a; $i<=$b; $i++ ){
            $HariNomor = sprintf("%02d", $i);
            $BulanNomor = sprintf("%02d", $bulan_grafik);
            $BulanList = array(
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            );
            $NamaBulan=$BulanList[$BulanNomor];
            $x="$i $NamaBulan";
            //Hitung Jumlah
            $KeywordGrafik="$tahun_grafik-$BulanNomor-$HariNomor";
            $periodPattern = "%$KeywordGrafik%";
            if (empty($kategori_log)) {
                mysqli_stmt_bind_param($stmtLogCount, "s", $periodPattern);
            } else {
                mysqli_stmt_bind_param($stmtLogCount, "ss", $kategori_log, $periodPattern);
            }
            mysqli_stmt_execute($stmtLogCount);
            $JumlahSemuaRad = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($stmtLogCount))['total'] ?? 0);
            $data [] = array(
                'x' => $HariNomor,
                'y' => $JumlahSemuaRad
            );
        }
    }
    $FileName="GrafikLogAkses.json";
    $jsonfile = json_encode($data);
    // file_put_contents($FileName, $jsonfile);
    echo $jsonfile;
?>