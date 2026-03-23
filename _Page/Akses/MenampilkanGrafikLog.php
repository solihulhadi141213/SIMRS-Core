<?php
    // header('Content-Type: application/json; charset=utf8');
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_akses'])){
        echo "ID Akses Tidak Boleh Kosong!";
    }else{
        if(empty($_POST['periode_grafik'])){
            echo "Periode Grafik Tidak Boleh Kosong!";
        }else{
            $id_akses=$_POST['id_akses'];
            $periode_grafik=$_POST['periode_grafik'];
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
                    if(empty($kategori_log)){
                        $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE waktu like '%$KeywordGrafik%'"));
                    }else{
                        $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE kategori='$kategori_log' AND waktu like '%$KeywordGrafik%'"));
                    }
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
                    if(empty($kategori_log)){
                        $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE waktu like '%$KeywordGrafik%'"));
                    }else{
                        $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE kategori='$kategori_log' AND waktu like '%$KeywordGrafik%'"));
                    }
                    $data [] = array(
                        'x' => $BulanNomor,
                        'y' => $JumlahSemuaRad
                    );
                }
            }
            $FileName="GrafikLogAkses.json";
            $jsonfile = json_encode($data);
            file_put_contents($FileName, $jsonfile);
            // echo $jsonfile;
        }
    }
?>