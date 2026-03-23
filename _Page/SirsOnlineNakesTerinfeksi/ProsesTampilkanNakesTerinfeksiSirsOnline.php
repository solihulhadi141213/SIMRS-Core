<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Log
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['PeriodeTanggal'])){
        echo '<tr>';
        echo '  <td colspan="7" class="text-center text-danger">Periode Tanggal Tidak Boleh Kosong!</td>';
        echo '</tr>';
    }else{
        $tanggal=$_POST['PeriodeTanggal'];
        //Kirim Data
        $KirimData=GetNakesTerinfeksi($x_id_rs,$password_sirs_online,$url_sirs_online,$tanggal);
        if(empty($KirimData)){
            echo '<tr>';
            echo '  <td colspan="7" class="text-center text-danger">Tidak ada response dari SIRS Online</td>';
            echo '</tr>';
        }else{
            $response = json_decode($KirimData, true);
            if(!empty($response['HarianNakesTerinfeksi']['0']['status'])){
                $message =$response['HarianNakesTerinfeksi']['0']['message'];
                echo '<tr>';
                echo '  <td colspan="7" class="text-center text-danger">Tidak ada data yang ditampilkan</td>';
                echo '</tr>';
                echo '<tr>';
                echo '  <td colspan="7" class="text-center text-danger">'.$message.'</td>';
                echo '</tr>';
            }else{
                $JumlahData=count($response['HarianNakesTerinfeksi']);
                if(empty($JumlahData)){
                    echo '<tr>';
                    echo '  <td colspan="7" class="text-center text-danger">Tidak ada data yang ditampilkan</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '  <td colspan="7" class="text-center text-danger">'.$KirimData.'</td>';
                    echo '</tr>';
                }else{
                    if(empty($response['HarianNakesTerinfeksi']['0']['tgllapor'])){
                        echo '<tr>';
                        echo '  <td colspan="7" class="text-center text-danger">Tidak ada data yang ditampilkan</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '  <td colspan="7" class="text-center text-danger">'.$KirimData.'</td>';
                        echo '</tr>';
                    }else{
                        $co_ass=$response['HarianNakesTerinfeksi']['0']['co_ass'];
                        $residen=$response['HarianNakesTerinfeksi']['0']['residen'];
                        $intership=$response['HarianNakesTerinfeksi']['0']['intership'];
                        $dokter_spesialis=$response['HarianNakesTerinfeksi']['0']['dokter_spesialis'];
                        $dokter_umum=$response['HarianNakesTerinfeksi']['0']['dokter_umum'];
                        $dokter_gigi=$response['HarianNakesTerinfeksi']['0']['dokter_gigi'];
                        $perawat=$response['HarianNakesTerinfeksi']['0']['perawat'];
                        $bidan=$response['HarianNakesTerinfeksi']['0']['bidan'];
                        $apoteker=$response['HarianNakesTerinfeksi']['0']['apoteker'];
                        $radiografer=$response['HarianNakesTerinfeksi']['0']['radiografer'];
                        $analis_lab=$response['HarianNakesTerinfeksi']['0']['analis_lab'];
                        $nakes_lainnya=$response['HarianNakesTerinfeksi']['0']['nakes_lainnya'];
                        $co_ass_meninggal=$response['HarianNakesTerinfeksi']['0']['co_ass_meninggal'];
                        $residen_meninggal=$response['HarianNakesTerinfeksi']['0']['residen_meninggal'];
                        $intership_meninggal=$response['HarianNakesTerinfeksi']['0']['intership_meninggal'];
                        $dokter_spesialis_meninggal=$response['HarianNakesTerinfeksi']['0']['dokter_spesialis_meninggal'];
                        $dokter_umum_meninggal=$response['HarianNakesTerinfeksi']['0']['dokter_umum_meninggal'];
                        $dokter_gigi_meninggal=$response['HarianNakesTerinfeksi']['0']['dokter_gigi_meninggal'];
                        $perawat_meninggal=$response['HarianNakesTerinfeksi']['0']['perawat_meninggal'];
                        $bidan_meninggal=$response['HarianNakesTerinfeksi']['0']['bidan_meninggal'];
                        $apoteker_meninggal=$response['HarianNakesTerinfeksi']['0']['apoteker_meninggal'];
                        $radiografer_meninggal=$response['HarianNakesTerinfeksi']['0']['radiografer_meninggal'];
                        $analis_lab_meninggal=$response['HarianNakesTerinfeksi']['0']['analis_lab_meninggal'];
                        $nakes_lainnya_meninggal=$response['HarianNakesTerinfeksi']['0']['nakes_lainnya_meninggal'];
                        $co_ass_dirawat=$response['HarianNakesTerinfeksi']['0']['co_ass_dirawat'];
                        $co_ass_isoman=$response['HarianNakesTerinfeksi']['0']['co_ass_isoman'];
                        $co_ass_sembuh=$response['HarianNakesTerinfeksi']['0']['co_ass_sembuh'];
                        $residen_dirawat=$response['HarianNakesTerinfeksi']['0']['residen_dirawat'];
                        $residen_isoman=$response['HarianNakesTerinfeksi']['0']['residen_isoman'];
                        $residen_sembuh=$response['HarianNakesTerinfeksi']['0']['residen_sembuh'];
                        $intership_dirawat=$response['HarianNakesTerinfeksi']['0']['intership_dirawat'];
                        $intership_isoman=$response['HarianNakesTerinfeksi']['0']['intership_isoman'];
                        $intership_sembuh=$response['HarianNakesTerinfeksi']['0']['intership_sembuh'];
                        $dokter_spesialis_dirawat=$response['HarianNakesTerinfeksi']['0']['dokter_spesialis_dirawat'];
                        $dokter_spesialis_isoman=$response['HarianNakesTerinfeksi']['0']['dokter_spesialis_isoman'];
                        $dokter_spesialis_sembuh=$response['HarianNakesTerinfeksi']['0']['dokter_spesialis_sembuh'];
                        $dokter_umum_dirawat=$response['HarianNakesTerinfeksi']['0']['dokter_umum_dirawat'];
                        $dokter_umum_isoman=$response['HarianNakesTerinfeksi']['0']['dokter_umum_isoman'];
                        $dokter_umum_sembuh=$response['HarianNakesTerinfeksi']['0']['dokter_umum_sembuh'];
                        $dokter_gigi_dirawat=$response['HarianNakesTerinfeksi']['0']['dokter_gigi_dirawat'];
                        $dokter_gigi_isoman=$response['HarianNakesTerinfeksi']['0']['dokter_gigi_isoman'];
                        $dokter_gigi_sembuh=$response['HarianNakesTerinfeksi']['0']['dokter_gigi_sembuh'];
                        $bidan_dirawat=$response['HarianNakesTerinfeksi']['0']['bidan_dirawat'];
                        $bidan_isoman=$response['HarianNakesTerinfeksi']['0']['bidan_isoman'];
                        $bidan_sembuh=$response['HarianNakesTerinfeksi']['0']['bidan_sembuh'];
                        $apoteker_dirawat=$response['HarianNakesTerinfeksi']['0']['apoteker_dirawat'];
                        $apoteker_isoman=$response['HarianNakesTerinfeksi']['0']['apoteker_isoman'];
                        $apoteker_sembuh=$response['HarianNakesTerinfeksi']['0']['apoteker_sembuh'];
                        $radiografer_dirawat=$response['HarianNakesTerinfeksi']['0']['radiografer_dirawat'];
                        $radiografer_isoman=$response['HarianNakesTerinfeksi']['0']['radiografer_isoman'];
                        $radiografer_sembuh=$response['HarianNakesTerinfeksi']['0']['radiografer_sembuh'];
                        $analis_lab_dirawat=$response['HarianNakesTerinfeksi']['0']['analis_lab_dirawat'];
                        $analis_lab_isoman=$response['HarianNakesTerinfeksi']['0']['analis_lab_isoman'];
                        $analis_lab_sembuh=$response['HarianNakesTerinfeksi']['0']['analis_lab_sembuh'];
                        $nakes_lainnya_dirawat=$response['HarianNakesTerinfeksi']['0']['nakes_lainnya_dirawat'];
                        $nakes_lainnya_isoman=$response['HarianNakesTerinfeksi']['0']['nakes_lainnya_isoman'];
                        $nakes_lainnya_sembuh=$response['HarianNakesTerinfeksi']['0']['nakes_lainnya_sembuh'];
                        $perawat_dirawat=$response['HarianNakesTerinfeksi']['0']['perawat_dirawat'];
                        $perawat_isoman=$response['HarianNakesTerinfeksi']['0']['perawat_isoman'];
                        $perawat_sembuh=$response['HarianNakesTerinfeksi']['0']['perawat_sembuh'];
                        $tgllapor=$response['HarianNakesTerinfeksi']['0']['tgllapor'];
?>
    <tr>
        <td class="text-center">1</td>
        <td class="text-left">Co Ass</td>
        <td class="text-center"><?php echo $co_ass;?></td>
        <td class="text-center"><?php echo $co_ass_sembuh;?></td>
        <td class="text-center"><?php echo $co_ass_isoman;?></td>
        <td class="text-center"><?php echo $co_ass_dirawat;?></td>
        <td class="text-center"><?php echo $co_ass_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">2</td>
        <td class="text-left">Residen</td>
        <td class="text-center"><?php echo $residen;?></td>
        <td class="text-center"><?php echo $residen_sembuh;?></td>
        <td class="text-center"><?php echo $residen_isoman;?></td>
        <td class="text-center"><?php echo $residen_dirawat;?></td>
        <td class="text-center"><?php echo $residen_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">3</td>
        <td class="text-left">Intership</td>
        <td class="text-center"><?php echo $intership;?></td>
        <td class="text-center"><?php echo $intership_sembuh;?></td>
        <td class="text-center"><?php echo $intership_isoman;?></td>
        <td class="text-center"><?php echo $intership_dirawat;?></td>
        <td class="text-center"><?php echo $intership_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">4</td>
        <td class="text-left">Dokter Spesialis</td>
        <td class="text-center"><?php echo $dokter_spesialis;?></td>
        <td class="text-center"><?php echo $dokter_spesialis_sembuh;?></td>
        <td class="text-center"><?php echo $dokter_spesialis_isoman;?></td>
        <td class="text-center"><?php echo $dokter_spesialis_dirawat;?></td>
        <td class="text-center"><?php echo $dokter_spesialis_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">5</td>
        <td class="text-left">Dokter Umum</td>
        <td class="text-center"><?php echo $dokter_umum;?></td>
        <td class="text-center"><?php echo $dokter_umum_sembuh;?></td>
        <td class="text-center"><?php echo $dokter_umum_isoman;?></td>
        <td class="text-center"><?php echo $dokter_umum_dirawat;?></td>
        <td class="text-center"><?php echo $dokter_umum_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">6</td>
        <td class="text-left">Dokter Gigi</td>
        <td class="text-center"><?php echo $dokter_gigi;?></td>
        <td class="text-center"><?php echo $dokter_gigi_sembuh;?></td>
        <td class="text-center"><?php echo $dokter_gigi_isoman;?></td>
        <td class="text-center"><?php echo $dokter_gigi_dirawat;?></td>
        <td class="text-center"><?php echo $dokter_gigi_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">7</td>
        <td class="text-left">Perawat</td>
        <td class="text-center"><?php echo $perawat;?></td>
        <td class="text-center"><?php echo $perawat_sembuh;?></td>
        <td class="text-center"><?php echo $perawat_isoman;?></td>
        <td class="text-center"><?php echo $perawat_dirawat;?></td>
        <td class="text-center"><?php echo $perawat_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">8</td>
        <td class="text-left">Bidan</td>
        <td class="text-center"><?php echo $bidan;?></td>
        <td class="text-center"><?php echo $bidan_sembuh;?></td>
        <td class="text-center"><?php echo $bidan_isoman;?></td>
        <td class="text-center"><?php echo $bidan_dirawat;?></td>
        <td class="text-center"><?php echo $bidan_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Apoteker</td>
        <td class="text-center"><?php echo $apoteker;?></td>
        <td class="text-center"><?php echo $apoteker_sembuh;?></td>
        <td class="text-center"><?php echo $apoteker_isoman;?></td>
        <td class="text-center"><?php echo $apoteker_dirawat;?></td>
        <td class="text-center"><?php echo $apoteker_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Radiografer</td>
        <td class="text-center"><?php echo $radiografer;?></td>
        <td class="text-center"><?php echo $radiografer_sembuh;?></td>
        <td class="text-center"><?php echo $radiografer_isoman;?></td>
        <td class="text-center"><?php echo $radiografer_dirawat;?></td>
        <td class="text-center"><?php echo $radiografer_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Analis Lab</td>
        <td class="text-center"><?php echo $analis_lab;?></td>
        <td class="text-center"><?php echo $analis_lab_sembuh;?></td>
        <td class="text-center"><?php echo $analis_lab_isoman;?></td>
        <td class="text-center"><?php echo $analis_lab_dirawat;?></td>
        <td class="text-center"><?php echo $analis_lab_meninggal;?></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Nakes Lainnya</td>
        <td class="text-center"><?php echo $nakes_lainnya;?></td>
        <td class="text-center"><?php echo $nakes_lainnya_sembuh;?></td>
        <td class="text-center"><?php echo $nakes_lainnya_isoman;?></td>
        <td class="text-center"><?php echo $nakes_lainnya_dirawat;?></td>
        <td class="text-center"><?php echo $nakes_lainnya_meninggal;?></td>
    </tr>
<?php
                    }
                }
            }
        }
    }
?>