<?php
    //menangkap akses group
    if(empty($_POST['AksesGroup'])){
        echo '<div class="card-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-primary">';
        echo '          Silahkan pilih group akses terlebih dulu untuk menampilkan setting aksesibilitas. ';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Buat variabel
        $AksesGroup=$_POST['AksesGroup'];
        //Koneksi
        include "../../_Config/Connection.php";
        //Membuka Setting akses group
        //setting_a
        $QryAksesHalaman = mysqli_query($Conn,"SELECT * FROM setting_a WHERE akses='$AksesGroup'")or die(mysqli_error($Conn));
        $DataAksesHalaman = mysqli_fetch_array($QryAksesHalaman);
        //rincian Ijin Halaman
        $id_setting_a= $DataAksesHalaman['id_setting_a'];
        $bantuan= $DataAksesHalaman['bantuan'];
        $aksesibilitas= $DataAksesHalaman['aksesibilitas'];
        $SettingProfile= $DataAksesHalaman['SettingProfile'];
        $Personalisasi= $DataAksesHalaman['Personalisasi'];
        $SettingBridging= $DataAksesHalaman['SettingBridging'];
        $LogAktivitas= $DataAksesHalaman['LogAktivitas'];
        $RefPoli= $DataAksesHalaman['RefPoli'];
        $RefDokter= $DataAksesHalaman['RefDokter'];
        $JadwalPraktek= $DataAksesHalaman['JadwalPraktek'];
        $Wilayah= $DataAksesHalaman['Wilayah'];
        $KelasRuangan= $DataAksesHalaman['KelasRuangan'];
        $MasterPasien= $DataAksesHalaman['MasterPasien'];
        $Kunjungan= $DataAksesHalaman['Kunjungan'];
        $Rujukan= $DataAksesHalaman['Rujukan'];
        $SpriSkdp= $DataAksesHalaman['SpriSkdp'];
        $FingerPrint= $DataAksesHalaman['FingerPrint'];
        $Monitoring= $DataAksesHalaman['Monitoring'];
        $Antrian= $DataAksesHalaman['Antrian'];
        $JadwalOperasi= $DataAksesHalaman['JadwalOperasi'];
?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>Kode</dt></th>
                            <th class="text-center"><dt>Nama Aksesibilitas</dt></th>
                            <th class="text-center"><dt>Status</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left" colspan="4"><dt>A. Pengaturan</dt></td>
                        </tr>
                        <tr>
                            <td class="text-center">A.1</td>
                            <td>Aksesibilitas</td>
                            <td>Ijin akses halaman aksesibilitas</td>
                            <td class="text-center">
                                <?php
                                    if($aksesibilitas=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="aksesibilitas,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="aksesibilitas,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($aksesibilitas=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="aksesibilitas,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="aksesibilitas,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="aksesibilitas,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="aksesibilitas,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">A.2</td>
                            <td>Setting Profile</td>
                            <td>Ijin halaman pengaturan profile faskes</td>
                            <td class="text-center">
                                <?php
                                    if($SettingProfile=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingProfile,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingProfile,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($SettingProfile=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingProfile,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingProfile,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingProfile,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingProfile,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">A.3</td>
                            <td>Personalisasi</td>
                            <td>Ijin halaman pengaturan personalisasi</td>
                            <td class="text-center">
                                <?php
                                    if($Personalisasi=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Personalisasi,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Personalisasi,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($Personalisasi=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Personalisasi,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Personalisasi,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Personalisasi,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Personalisasi,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">A.4</td>
                            <td>Setting Bridging</td>
                            <td>Ijin halaman Setting Bridging</td>
                            <td class="text-center">
                                <?php
                                    if($SettingBridging=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingBridging,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingBridging,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($SettingBridging=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingBridging,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingBridging,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingBridging,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SettingBridging,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">A.5</td>
                            <td>Log Aktivitas</td>
                            <td>Ijin halaman log</td>
                            <td class="text-center">
                                <?php
                                    if($LogAktivitas=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="LogAktivitas,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="LogAktivitas,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($LogAktivitas=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="LogAktivitas,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="LogAktivitas,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="LogAktivitas,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="LogAktivitas,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="4"><dt>B. Halaman Referensi</dt></td>
                        </tr>
                        <tr>
                            <td class="text-center">B.1</td>
                            <td>Referensi Poli</td>
                            <td>Ijin Halaman Referensi Poli</td>
                            <td class="text-center">
                                <?php
                                    if($RefPoli=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefPoli,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefPoli,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($RefPoli=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefPoli,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefPoli,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefPoli,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefPoli,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">B.2</td>
                            <td>Referensi Dokter</td>
                            <td>Ijin Halaman Referensi Dokter</td>
                            <td class="text-center">
                                <?php
                                    if($RefDokter=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefDokter,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefDokter,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($RefDokter=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefDokter,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefDokter,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefDokter,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="RefDokter,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">B.3</td>
                            <td>Referensi Jadwal Poli/Dokter</td>
                            <td>Ijin Halaman Referensi Jadwal Praktek Dokter</td>
                            <td class="text-center">
                                <?php
                                    if($JadwalPraktek=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalPraktek,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalPraktek,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($JadwalPraktek=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalPraktek,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalPraktek,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalPraktek,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalPraktek,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">B.4</td>
                            <td>Referensi Wilayah</td>
                            <td>Ijin Halaman Referensi Wilayah</td>
                            <td class="text-center">
                                <?php
                                    if($Wilayah=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Wilayah,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Wilayah,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($Wilayah=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Wilayah,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Wilayah,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Wilayah,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Wilayah,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">B.5</td>
                            <td>Kelas/Ruangan</td>
                            <td>Ijin Halaman Kelas/Ruangan</td>
                            <td class="text-center">
                                <?php
                                    if($KelasRuangan=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="KelasRuangan,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="KelasRuangan,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($KelasRuangan=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="KelasRuangan,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="KelasRuangan,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="KelasRuangan,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="KelasRuangan,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="4"><dt>C. Halaman Pasien</dt></td>
                        </tr>
                        <tr>
                            <td class="text-center">C.1</td>
                            <td>Master Pasien</td>
                            <td>Ijin Halaman Master Pasien</td>
                            <td class="text-center">
                                <?php
                                    if($MasterPasien=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="MasterPasien,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="MasterPasien,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($MasterPasien=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="MasterPasien,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="MasterPasien,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="MasterPasien,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="MasterPasien,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">C.2</td>
                            <td>Kunjungan</td>
                            <td>Ijin Halaman Kunjungan</td>
                            <td class="text-center">
                                <?php
                                    if($Kunjungan=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Kunjungan,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Kunjungan,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($Kunjungan=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Kunjungan,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Kunjungan,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Kunjungan,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Kunjungan,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">C.3</td>
                            <td>Rujukan</td>
                            <td>Ijin Halaman Rujukan</td>
                            <td class="text-center">
                                <?php
                                    if($Rujukan=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Rujukan,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Rujukan,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($Rujukan=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Rujukan,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Rujukan,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Rujukan,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Rujukan,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">C.4</td>
                            <td>SPRI/SKDP</td>
                            <td>Ijin Halaman SPRI/SKDP</td>
                            <td class="text-center">
                                <?php
                                    if($SpriSkdp=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SpriSkdp,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SpriSkdp,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($SpriSkdp=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SpriSkdp,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SpriSkdp,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SpriSkdp,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="SpriSkdp,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">C.5</td>
                            <td>Fingerprint</td>
                            <td>Ijin Halaman Fingerprint</td>
                            <td class="text-center">
                                <?php
                                    if($FingerPrint=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="FingerPrint,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="FingerPrint,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($FingerPrint=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="FingerPrint,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="FingerPrint,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="FingerPrint,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="FingerPrint,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">C.6</td>
                            <td>Monitoring</td>
                            <td>Ijin Halaman Monitoring</td>
                            <td class="text-center">
                                <?php
                                    if($Monitoring=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Monitoring,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Monitoring,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($Monitoring=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Monitoring,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Monitoring,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Monitoring,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Monitoring,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="4"><dt>D. Halaman Antrian</dt></td>
                        </tr>
                        <tr>
                            <td class="text-center">C.6</td>
                            <td>Antrian</td>
                            <td>Ijin Halaman Antrian</td>
                            <td class="text-center">
                                <?php
                                    if($Antrian=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Antrian,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Antrian,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($Antrian=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Antrian,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Antrian,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Antrian,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="Antrian,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">C.7</td>
                            <td>Jadwal Operasi</td>
                            <td>Ijin Halaman Jadwal Operasi</td>
                            <td class="text-center">
                                <?php
                                    if($JadwalOperasi=="Ya"){
                                        echo '<div class="btn-group">';
                                        echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalOperasi,Ya">Yes</button>';
                                        echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalOperasi,No">No</button>';
                                        echo '</div>';
                                    }else{
                                        if($JadwalOperasi=="No"){
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalOperasi,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalOperasi,No">No</button>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="btn-group">';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalOperasi,Ya">Yes</button>';
                                            echo '  <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#ModalUpdateSetting" data-id="JadwalOperasi,No">No</button>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>