<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(!empty($_POST['PeriodeDataExport'])){
        $PeriodeDataExport=$_POST['PeriodeDataExport'];
        if(empty($_POST['GetTahunForm'])){
            $GetTahunForm="";
        }else{
            $GetTahunForm=$_POST['GetTahunForm'];
        }
        if(empty($_POST['GetBulanForm'])){
            $BulanData=date('m');
        }else{
            $BulanData=$_POST['GetBulanForm'];
        }
        if(empty($_POST['GetWaktu'])){
            $KeywordWaktu=date('Y-m-d');
        }else{
            $KeywordWaktu=$_POST['GetWaktu'];
        }
        $BulanTahun="$GetTahunForm-$BulanData";
        if($PeriodeDataExport=="Tahunan"){
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
                $KeywordGrafik="$GetTahunForm-$BulanNomor";
                $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$KeywordGrafik%'"));
                $data [] = array(
                    'x' => $NamaBulan,
                    'y' => $JumlahSemuaRad
                );
            }
        }else{
            if($PeriodeDataExport=="Bulanan"){
                $a=1;
                $b=cal_days_in_month(CAL_GREGORIAN, $BulanData, $GetTahunForm);
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
                    $KeywordGrafik="$GetTahunForm-$BulanNomor-$HariNomor";
                    $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$KeywordGrafik%'"));
                    $data [] = array(
                        'x' => $x,
                        'y' => $JumlahSemuaRad
                    );
                }
            }else{
                
            }
        }
        $FileName="GrafikLaboratorium.json";
        $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($FileName, $jsonfile);
    }
?>