<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $UrlInfo=urlService('Web Monitoring Info');
    if(empty($_POST['periode'])){
        echo 'Periode Tidak Boleh Kosong!';
    }else{
        if(empty($_POST['tahun'])){
            echo 'Data Tahun Tidak Boleh Kosong!';
        }else{
            $periode=$_POST['periode'];
            $tahun=$_POST['tahun'];
            if($periode=="Bulanan"&&empty($_POST['bulan'])){
                echo 'Untuk periode Bulanan, informasi bulan tidak boleh kosong!';
            }else{
                $bulan=$_POST['bulan'];
                if($periode=="Bulanan"){
                    $FileName="WebMonitoringBulanan.json";
                }else{
                    $FileName="WebMonitoringTahunan.json";
                }
                if($periode=="Tahunan"){
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
                        $keyword_by="tanggal";
                        $keyword="$tahun-$BulanNomor";
                        $tanggal="01";
                        $Waktu="$tahun-$BulanNomor-$tanggal";
                        $parameter="Jumlah";
                        $Jumlah =jumlahData($api_key,$UrlInfo,$keyword_by,$keyword,$parameter);
                        $data [] = array(
                            'x' => $NamaBulan,
                            'y' => $Jumlah
                        );
                    }
                }else{
                    if($periode=="Bulanan"){
                        $a=1;
                        $b=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                        for ( $i =$a; $i<=$b; $i++ ){
                            $HariNomor = sprintf("%02d", $i);
                            $BulanNomor = sprintf("%02d", $bulan);
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
                            $keyword_by="tanggal";
                            $keyword="$tahun-$BulanNomor-$HariNomor";
                            $parameter="Jumlah";
                            $JumlahVisitor =jumlahData($api_key,$UrlInfo,$keyword_by,$keyword,$parameter);
                            $data [] = array(
                                'x' => $x,
                                'y' => $JumlahVisitor
                            );
                        }
                    }else{
                        
                    }
                }
                $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
                file_put_contents($FileName, $jsonfile);
            }
        }
    }
    
?>