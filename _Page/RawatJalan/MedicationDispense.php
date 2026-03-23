<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $Token=GenerateTokenSatuSehat($Conn);
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Cek id_encounter
        $id_encounter=getDataDetail($Conn,' kunjungan_utama','id_kunjungan',$id_kunjungan,'id_encounter');
        if(empty($id_encounter)){
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12 text-center text-danger">';
            echo '      Kunjungan Ini Belum mempunyai ID Encounter';
            echo '  </div>';
            echo '</div>';
        }else{
            //Apakah Sudah Punya MedicationDispense
            $JumlahMedDis=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_med_dis WHERE id_kunjungan='$id_kunjungan'"));
            if(empty($JumlahMedDis)){
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-12 text-center text-danger">';
                echo '      Kunjungan Ini Belum Memiliki Data/Informasi Medication Dispense';
                echo '  </div>';
                echo '</div>';
            }else{
                $no=1;
                $query = mysqli_query($Conn, "SELECT * FROM kunjungan_med_dis WHERE id_kunjungan='$id_kunjungan'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_kunjungan_med_dis=$data['id_kunjungan_med_dis'];
                    $id_resep=$data['id_resep'];
                    $id_item_resep=$data['id_item_resep'];
                    $id_medication_dis=$data['id_medication_dis'];
                    $raw_med_dis=$data['raw_med_dis'];
                    $id_akses=$data['id_akses'];
                    $updatetime=$data['updatetime'];
                    $strtotime=strtotime($updatetime);
                    $updatetime=date('d/m/Y H:i:s',$strtotime);
                    $data_array = json_decode($raw_med_dis, true);
                    $medicationReference_display=$data_array['medicationReference']['display'];
                    $medicationReference_reference=$data_array['medicationReference']['reference'];
                    //Petugas
                    $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
?> 
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="javascript:void(0);" class="text-info mb-3" data-toggle="modal" data-target="#ModalDetailMedicationDispense" data-id="<?php echo $id_kunjungan_med_dis; ?>">
                                        <?php echo "$medicationReference_display"; ?>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <ul class="ml-3">
                                        <li class="mb-3">
                                            - ID IHS : <code class="text-secondary"><?php echo "$id_medication_dis"; ?></code>
                                        </li>
                                        <li class="mb-3">
                                            - Reff : <code class="text-secondary"><?php echo "$medicationReference_reference"; ?></code>
                                        </li>
                                        <li class="mb-3">
                                            - Petugas : <code class="text-secondary"><?php echo "$NamaPetugas"; ?></code>
                                        </li>
                                        <li class="mb-3">
                                            - Update : <code class="text-secondary"><?php echo "$updatetime"; ?></code>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer text-center icon-btn">
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Lihat Detail Medication Dispense" data-toggle="modal" data-target="#ModalDetailMedicationDispense" data-id="<?php echo $id_kunjungan_med_dis; ?>">
                                        <i class="ti ti-info"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Edit/Ubah Medication Dispense" data-toggle="modal" data-target="#ModalEditMedicationDispense" data-id="<?php echo $id_kunjungan_med_dis; ?>">
                                        <i class="ti ti-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Cetak Medication Dispense" data-toggle="modal" data-target="#ModalCetakMedicationDispense" data-id="<?php echo $id_kunjungan_med_dis; ?>">
                                        <i class="ti ti-printer"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Hapus Medication Dispense" data-toggle="modal" data-target="#ModalHapusMedicationDispense" data-id="<?php echo $id_kunjungan_med_dis; ?>">
                                        <i class="ti ti-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
?>