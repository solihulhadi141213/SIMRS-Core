<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(!empty($_POST['KategoriGrafik'])){
        $KategoriGrafik=$_POST['KategoriGrafik'];
        if(empty($_POST['GetTahun'])){
            $GetTahun=date('Y');
        }else{
            $GetTahun=$_POST['GetTahun'];
        }
        if(empty($_POST['GetBulan'])){
            $GetBulan=date('m');
        }else{
            $GetBulan=$_POST['GetBulan'];
        }
        
        if($KategoriGrafik=="Tahunan"){
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
                $KeywordGrafik="$GetTahun-$BulanNomor";
                $JumlahKunjungan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE tanggal like '%$KeywordGrafik%'"));
                $data [] = array(
                    'x' => $NamaBulan,
                    'y' => $JumlahKunjungan
                );
            }
        }else{
            if($KategoriGrafik=="Bulanan"){
                $a=1;
                $b=cal_days_in_month(CAL_GREGORIAN, $GetBulan, $GetTahun);
                for ( $i =$a; $i<=$b; $i++ ){
                    $HariNomor = sprintf("%02d", $i);
                    $BulanNomor = sprintf("%02d", $BulanData);
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
                    $NamaBulan=$BulanList[$bulan];
                    $x="$i $NamaBulan";
                    //Hitung Jumlah
                    $KeywordGrafik="$GetTahun-$GetBulan-$HariNomor";
                    $JumlahKunjungan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE tanggal like '%$KeywordGrafik%'"));
                    $data [] = array(
                        'x' => $x,
                        'y' => $JumlahKunjungan
                    );
                }
            }else{
                
            }
        }
        $FileName="GrafikDashboard.json";
        $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($FileName, $jsonfile);
    }
?>