<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $UrlInfo=urlService('Web Monitoring Info');
?>
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center" id="TabShortNama">
                    <dt>No</dt>
                </th>
                <th class="text-center" id="TabShortNama">
                    <dt>Periode</dt>
                </th>
                <th class="text-center" id="TabShortNama">
                    <dt>Jumlah Visitor</dt>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                //keyword
                if(empty($_POST['periode'])){
                    echo '<tr>';
                    echo '  <td colspan="3" class="text-center">';
                    echo "      Informasi Periode Data Tidak Boleh Kosong!";
                    echo '  </td>';
                    echo '</tr>';
                }else{
                    if(empty($_POST['tahun'])){
                        echo '<tr>';
                        echo '  <td colspan="3" class="text-center">';
                        echo "      Informasi Tahun Data Tidak Boleh Kosong!";
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $periode=$_POST['periode'];
                        $tahun=$_POST['tahun'];
                        if(empty($_POST['bulan'])){
                            $bulan="";
                        }else{
                            $bulan=$_POST['bulan'];
                        }
                        if($periode=="Tahunan"){
                            //Looping 12 kali
                            $a=1;
                            $b=12;
                            for ( $i =$a; $i<=$b; $i++ ){
                                $BulanNomor = sprintf("%02d", $i);
                                $BulanList = array(
                                    '1' => 'Januari',
                                    '2' => 'Februari',
                                    '3' => 'Maret',
                                    '4' => 'April',
                                    '5' => 'Mei',
                                    '6' => 'Juni',
                                    '7' => 'Juli',
                                    '8' => 'Agustus',
                                    '9' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember',
                                );
                                $NamaBulan=$BulanList[$i];
                                //Hitung Jumlah
                                $keyword_by="tanggal";
                                $keyword="$tahun-$BulanNomor";
                                $parameter="Jumlah";
                                $JumlahVisitor =jumlahData($api_key,$UrlInfo,$keyword_by,$keyword,$parameter);
                                echo '<tr>';
                                echo '  <td class="text-center">'.$i.'</td>';
                                echo '  <td class="text-left">'.$NamaBulan.' '.$tahun.'</td>';
                                echo '  <td class="text-right">'.$JumlahVisitor.' View</td>';
                                echo '</tr>';
                            }
                        }else{
                            if($periode=="Bulanan"){
                                //Looping 12 kali
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
                                    //Hitung Jumlah
                                    $keyword_by="tanggal";
                                    $keyword="$tahun-$BulanNomor-$HariNomor";
                                    $parameter="Jumlah";
                                    $JumlahVisitor =jumlahData($api_key,$UrlInfo,$keyword_by,$keyword,$parameter);
                                    echo '<tr>';
                                    echo '  <td class="text-center">'.$i.'</td>';
                                    echo '  <td class="text-left">'.$i.' '.$NamaBulan.' '.$tahun.'</td>';
                                    echo '  <td class="text-right">'.$JumlahVisitor.' View</td>';
                                    echo '</tr>';
                                }
                            }else{
                                
                            }
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>
