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
    if(empty($_POST['id_sirs_online_task'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">ID Log Tidak Boleh Kosong!</div>';
        echo '</div>';
    }else{
        $id_sirs_online_task=$_POST['id_sirs_online_task'];
        $json_data=getDataDetail($Conn,'sirs_online_task','id_sirs_online_task',$id_sirs_online_task,'keterangan');
        $data = json_decode($json_data, true);
        if(empty($data['tanggal'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">Tidak ada data yang ditampilkan!</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger"><textarea class="form-control">'.$json_data.'</textarea></div>';
            echo '</div>';
        }else{
            $co_ass=$data['co_ass'];
            $residen=$data['residen'];
            $intership=$data['intership'];
            $dokter_spesialis=$data['dokter_spesialis'];
            $dokter_umum=$data['dokter_umum'];
            $dokter_gigi=$data['dokter_gigi'];
            $perawat=$data['perawat'];
            $bidan=$data['bidan'];
            $apoteker=$data['apoteker'];
            $radiografer=$data['radiografer'];
            $analis_lab=$data['analis_lab'];
            $nakes_lainnya=$data['nakes_lainnya'];
            $co_ass_meninggal=$data['co_ass_meninggal'];
            $residen_meninggal=$data['residen_meninggal'];
            $intership_meninggal=$data['intership_meninggal'];
            $dokter_spesialis_meninggal=$data['dokter_spesialis_meninggal'];
            $dokter_umum_meninggal=$data['dokter_umum_meninggal'];
            $dokter_gigi_meninggal=$data['dokter_gigi_meninggal'];
            $perawat_meninggal=$data['perawat_meninggal'];
            $bidan_meninggal=$data['bidan_meninggal'];
            $apoteker_meninggal=$data['apoteker_meninggal'];
            $radiografer_meninggal=$data['radiografer_meninggal'];
            $analis_lab_meninggal=$data['analis_lab_meninggal'];
            $nakes_lainnya_meninggal=$data['nakes_lainnya_meninggal'];
            $co_ass_dirawat=$data['co_ass_dirawat'];
            $co_ass_isoman=$data['co_ass_isoman'];
            $co_ass_sembuh=$data['co_ass_sembuh'];
            $residen_dirawat=$data['residen_dirawat'];
            $residen_isoman=$data['residen_isoman'];
            $residen_sembuh=$data['residen_sembuh'];
            $intership_dirawat=$data['intership_dirawat'];
            $intership_isoman=$data['intership_isoman'];
            $intership_sembuh=$data['intership_sembuh'];
            $dokter_spesialis_dirawat=$data['dokter_spesialis_dirawat'];
            $dokter_spesialis_isoman=$data['dokter_spesialis_isoman'];
            $dokter_spesialis_sembuh=$data['dokter_spesialis_sembuh'];
            $dokter_umum_dirawat=$data['dokter_umum_dirawat'];
            $dokter_umum_isoman=$data['dokter_umum_isoman'];
            $dokter_umum_sembuh=$data['dokter_umum_sembuh'];
            $dokter_gigi_dirawat=$data['dokter_gigi_dirawat'];
            $dokter_gigi_isoman=$data['dokter_gigi_isoman'];
            $dokter_gigi_sembuh=$data['dokter_gigi_sembuh'];
            $bidan_dirawat=$data['bidan_dirawat'];
            $bidan_isoman=$data['bidan_isoman'];
            $bidan_sembuh=$data['bidan_sembuh'];
            $apoteker_dirawat=$data['apoteker_dirawat'];
            $apoteker_isoman=$data['apoteker_isoman'];
            $apoteker_sembuh=$data['apoteker_sembuh'];
            $radiografer_dirawat=$data['radiografer_dirawat'];
            $radiografer_isoman=$data['radiografer_isoman'];
            $radiografer_sembuh=$data['radiografer_sembuh'];
            $analis_lab_dirawat=$data['analis_lab_dirawat'];
            $analis_lab_isoman=$data['analis_lab_isoman'];
            $analis_lab_sembuh=$data['analis_lab_sembuh'];
            $nakes_lainnya_dirawat=$data['nakes_lainnya_dirawat'];
            $nakes_lainnya_isoman=$data['nakes_lainnya_isoman'];
            $nakes_lainnya_sembuh=$data['nakes_lainnya_sembuh'];
            $perawat_dirawat=$data['perawat_dirawat'];
            $perawat_isoman=$data['perawat_isoman'];
            $perawat_sembuh=$data['perawat_sembuh'];
?>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" valign="middle" rowspan="2"><dt>No</dt></th>
                            <th class="text-center" valign="middle" rowspan="2"><dt>Kategori</dt></th>
                            <th class="text-center" valign="middle" rowspan="2"><dt>Jumlah</dt></th>
                            <th class="text-center" colspan="4"><dt>Status</dt></th>
                        </tr>
                        <tr>
                            <th class="text-center"><dt>Sembuh</dt></th>
                            <th class="text-center"><dt>Isoman</dt></th>
                            <th class="text-center"><dt>Dirawat</dt></th>
                            <th class="text-center"><dt>Meninggal</dt></th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td class="text-center"><?php echo $dokter_spesialis_meninggal;?></td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
        }
    }
?>