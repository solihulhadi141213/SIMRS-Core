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
            //Apakah Sudah Punya MedicationRequest
            $JumlahMedReq=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_med_req WHERE id_kunjungan='$id_kunjungan'"));
            if(empty($JumlahMedReq)){
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-12 text-center text-danger">';
                echo '      Kunjungan Ini Belum Memiliki Data/Informasi Medication Request';
                echo '  </div>';
                echo '</div>';
            }else{
                $no=1;
                $query = mysqli_query($Conn, "SELECT DISTINCT id_resep FROM kunjungan_med_req WHERE id_kunjungan='$id_kunjungan'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_resep=$data['id_resep'];
                    //Jumlah Item Resep
                    $JumlahItemResep=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_med_req WHERE id_resep='$id_resep'"));
                    $updatetime=getDataDetail($Conn,'kunjungan_med_req','id_resep',$id_resep,'updatetime');
                    $strtotime=strtotime($updatetime);
                    $TanggalResep=date('d/m/Y H:i:s',$strtotime);
?>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="HeadingMedicationRequest1">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MedicationRequestContent1" aria-expanded="false" aria-controls="MedicationRequestContent1">
                                        <span class="text-primary">
                                            1.6.1.<?php echo "$no. $TanggalResep"; ?>
                                            <span class="badge badge-inverse-primary">
                                                <?php echo "$JumlahItemResep"; ?>
                                            </span>
                                        </span>
                                    </a>
                                </h3>
                            </div>
                        </div>
                        <div id="MedicationRequestContent1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="HeadingMedicationRequest1">
                            <div class="accordion-content accordion-desc">
                                <p>
                                    <ol>
                                        <?php
                                            $query2 = mysqli_query($Conn, "SELECT * FROM kunjungan_med_req WHERE id_resep='$id_resep'");
                                            while ($data2 = mysqli_fetch_array($query2)) {
                                                $id_kunjungan_med_req =$data2['id_kunjungan_med_req'];
                                                $id_item_resep=$data2['id_item_resep'];
                                                $id_akses=$data2['id_akses'];
                                                $updatetime=$data2['updatetime'];
                                                $raw_med_req=$data2['raw_med_req'];
                                                $data_array = json_decode($raw_med_req, true);
                                                $medicationReference_display=$data_array['medicationReference']['display'];
                                                $medicationReference_reference=$data_array['medicationReference']['reference'];
                                                //Explode
                                                $explode=explode('/',$medicationReference_reference);
                                                $id_medication=$explode[1];
                                                //Nama Petugas
                                                $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                                                echo '<li class="mb-3">';
                                                echo '    '.$medicationReference_display.'';
                                                echo '      <ul>';
                                                echo '          <li>- ID Med Req:';
                                                echo '              <a href="javascriot:void(0);" class="text-info" title="Lihat Detail Medication Request" data-toggle="modal" data-target="#ModalDetailMedicationRequest2" data-id="'.$id_item_resep.'">';
                                                echo '                  <code class="text-info">'.$id_item_resep.'</code>';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '          <li>- ID Med:';
                                                echo '              <a href="javascriot:void(0);" class="text-info" title="Lihat Detail Medication" data-toggle="modal" data-target="#ModalDetailMedication" data-id="'.$id_medication.'">';
                                                echo '                  <code class="text-info">'.$id_medication.'</code>';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '          <li>- Petugas: <code class="text-secondary">'.$NamaPetugas.'</code></li>';
                                                echo '          <li>';
                                                echo '              <a href="javascriot:void(0);" class="text-success" title="Edit medication Request" data-toggle="modal" data-target="#ModalEditMedicationRequest" data-id="'.$id_item_resep.'">';
                                                echo '                  - Edit Medication Request <i class="ti ti-pencil"></i>';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '      </ul>';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ol>
                                </p>
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