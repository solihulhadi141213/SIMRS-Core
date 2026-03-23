<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_encounter
    if(empty($_POST['id_encounter'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center"><span class="text-danger">ID Encounter Tidak Boleh Kosong!</span></div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-success">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center">';
        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Menangkap id_kunjungan
        if(empty($_POST['id_kunjungan'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center"><span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span></div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-success">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center">';
            echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
            echo '              <i class="ti-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_kunjungan=$_POST['id_kunjungan'];
            $id_encounter=$_POST['id_encounter'];
            $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
            $Token=GenerateTokenSatuSehat($Conn);
            $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
            if(empty($SettingSatuSehat)){
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center"><span class="text-danger">Tidak Ada Setting Satu Sehat Yang Aktif!</span></div>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="modal-footer bg-success">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center">';
                echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
                echo '              <i class="ti-close"></i> Tutup';
                echo '          </button>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($Token)){
                    echo '<div class="modal-body">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center"><span class="text-danger">Gagal Melakukan Generate Token!</span></div>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="modal-footer bg-success">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center">';
                    echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
                    echo '              <i class="ti-close"></i> Tutup';
                    echo '          </button>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($baseurl_satusehat)){
                        echo '<div class="modal-body">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center"><span class="text-danger">Tidak Ada Base URL Satu Sehat!</span></div>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="modal-footer bg-success">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center">';
                        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
                        echo '              <i class="ti-close"></i> Tutup';
                        echo '          </button>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $response=EncounterById($baseurl_satusehat,$Token,$id_encounter);
                        $json_decode =json_decode($response, true);
                        if(!empty($json_decode['status'])){
                            $StatusEncounter=$json_decode['status'];
                        }else{
                            $StatusEncounter="";
                        }
                        if(!empty($json_decode['hospitalization'])){
                            if(!empty($json_decode['hospitalization']['dischargeDisposition'])){
                                if(!empty($json_decode['hospitalization']['dischargeDisposition']['coding'])){
                                    $DispotionCoding=$json_decode['hospitalization']['dischargeDisposition']['coding'];
                                    foreach($DispotionCoding as $ValueDisposition){
                                        $dischargeDispositionStatus=$ValueDisposition['code'];
                                    }
                                    $dischargeDispositionText=$json_decode['hospitalization']['dischargeDisposition']['text'];
                                }else{
                                    $dischargeDispositionStatus="";
                                    $dischargeDispositionText="";
                                }
                            }else{
                                $dischargeDispositionStatus="";
                                $dischargeDispositionText="";
                            }
                        }else{
                            $dischargeDispositionStatus="";
                            $dischargeDispositionText="";
                        }
                        //Mencari waktu arrive
                        if(!empty($json_decode['statusHistory'])){
                            $statusHistory=$json_decode['statusHistory'];
                            if(!empty(count($statusHistory))){
                                $JumlahArrive=0;
                                $JumlahProgress=0;
                                $JumlahFinish=0;
                                foreach($statusHistory as $ValueHistory){
                                    $period=$ValueHistory['period'];
                                    $end=$period['end'];
                                    $start=$period['start'];
                                    $status=$ValueHistory['status'];
                                    if($status=="arrived"){
                                        $JumlahArrive=$JumlahArrive+1;
                                        $WaktuMulaiArrive=$start;
                                        $WaktuSelesaiArrive=$end;
                                    }else{
                                        if($status=="in-progress"){
                                            $JumlahProgress=$JumlahProgress+1;
                                            $WaktuMulaiProgress=$start;
                                            $WaktuSelesaiProgress=$end;
                                        }else{
                                            if($status=="finished"){
                                                $JumlahFinish=$JumlahFinish+1;
                                                $WaktuMulaiFinish=$start;
                                                $WaktuSelesaiFinish=$end;
                                            }
                                        }
                                    }
                                }
                                if(empty($JumlahArrive)){
                                    $WaktuMulaiArrive="";
                                    $WaktuSelesaiArrive="";
                                }
                                if(empty($JumlahProgress)){
                                    $WaktuMulaiProgress="";
                                    $WaktuSelesaiProgress="";
                                }
                                if(empty($JumlahFinish)){
                                    $WaktuMulaiFinish="";
                                    $WaktuSelesaiFinish="";
                                }
                            }else{
                                $WaktuMulaiArrive="";
                                $WaktuSelesaiArrive="";
                                $WaktuMulaiProgress="";
                                $WaktuSelesaiProgress="";
                                $WaktuMulaiFinish="";
                                $WaktuSelesaiFinish="";
                            }
                        }else{
                            $WaktuMulaiArrive="";
                            $WaktuSelesaiArrive="";
                            $WaktuMulaiProgress="";
                            $WaktuSelesaiProgress="";
                            $WaktuMulaiFinish="";
                            $WaktuSelesaiFinish="";
                        }
                        //Arrive
                        if(!empty($WaktuMulaiArrive)){
                            $strtotime=strtotime($WaktuMulaiArrive);
                            $TanggalMulaiArrive=date('Y-m-d',$strtotime);
                            $JamMulaiArrive=date('H:i',$strtotime);
                        }else{
                            $TanggalMulaiArrive="";
                            $JamMulaiArrive="";
                        }
                        if(!empty($WaktuSelesaiArrive)){
                            $strtotime=strtotime($WaktuSelesaiArrive);
                            $TanggalSelesaiArrive=date('Y-m-d',$strtotime);
                            $JamSelesaiArrive=date('H:i',$strtotime);
                        }else{
                            $TanggalSelesaiArrive="";
                            $JamSelesaiArrive="";
                        }
                        //Progress
                        if(!empty($WaktuMulaiProgress)){
                            $strtotime=strtotime($WaktuMulaiProgress);
                            $TanggalMulaiProgress=date('Y-m-d',$strtotime);
                            $JamMulaiProgress=date('H:i',$strtotime);
                        }else{
                            $TanggalMulaiProgress="";
                            $JamMulaiProgress="";
                        }
                        if(!empty($WaktuSelesaiProgress)){
                            $strtotime=strtotime($WaktuSelesaiProgress);
                            $TanggalSelesaiProgress=date('Y-m-d',$strtotime);
                            $JamSelesaiProgress=date('H:i',$strtotime);
                        }else{
                            $TanggalSelesaiProgress="";
                            $JamSelesaiProgress="";
                        }
                        //Finish
                        if(!empty($WaktuMulaiFinish)){
                            $strtotime=strtotime($WaktuMulaiFinish);
                            $TanggalMulaiFinish=date('Y-m-d',$strtotime);
                            $JamMulaiFinish=date('H:i',$strtotime);
                        }else{
                            $TanggalMulaiFinish="";
                            $JamMulaiFinish="";
                        }
                        if(!empty($WaktuSelesaiFinish)){
                            $strtotime=strtotime($WaktuSelesaiFinish);
                            $TanggalSelesaiFinish=date('Y-m-d',$strtotime);
                            $JamSelesaiFinish=date('H:i',$strtotime);
                        }else{
                            $TanggalSelesaiFinish="";
                            $JamSelesaiFinish="";
                        }
?>
                    <form action="javascript:void(0);" id="ProsesUpdateEncounter">
                        <input type="hidden" name="id_encounter" id="id_encounter" value="<?php echo $id_encounter; ?>">
                        <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
                        <div class="modal-body border-0 pb-0 mb-4">
                            <div class="row mb-3"> 
                                <div class="col-md-12">
                                    <dt>Status History</dt>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="StatusEncounter">Status</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="StatusEncounter" id="StatusEncounter" class="form-control">
                                        <option <?php if($StatusEncounter==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($StatusEncounter=="arrived"){echo "selected";} ?> value="arrived">Arrived</option>
                                        <option <?php if($StatusEncounter=="in-progress"){echo "selected";} ?> value="in-progress">In-progress</option>
                                        <option <?php if($StatusEncounter=="finished"){echo "selected";} ?> value="finished">Finished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-12">
                                    <dt>Arrived Datetime</dt>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalMulai">Arrived Start</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalMulaiArrive" id="TanggalMulaiArrive" value="<?php echo $TanggalMulaiArrive; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamMulaiArrive" id="JamMulaiArrive" value="<?php echo $JamMulaiArrive; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalSelesai">Arrived End</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalSelesaiArrive" id="TanggalSelesaiArrive" value="<?php echo $TanggalSelesaiArrive; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamSelesaiArrive" id="JamSelesaiArrive" value="<?php echo $JamSelesaiArrive; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-12">
                                    <dt>In-Progress Datetime</dt>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalMulai">Progress Start</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalMulaiProgress" id="TanggalMulaiProgress" value="<?php echo $TanggalMulaiProgress; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamMulaiProgress" id="JamMulaiProgress" value="<?php echo $JamMulaiProgress; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalSelesai">Progress End</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalSelesaiProgress" id="TanggalSelesaiProgress" value="<?php echo $TanggalSelesaiProgress; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamSelesaiProgress" id="JamSelesaiProgress" value="<?php echo $JamSelesaiProgress; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-12">
                                    <dt>Finish Datetime</dt>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalMulai">Finish Start</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalMulaiFinish" id="TanggalMulaiFinish" value="<?php echo $TanggalMulaiFinish; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamMulaiFinish" id="JamMulaiFinish" value="<?php echo $JamMulaiFinish; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalSelesaiFinish">Finish End</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalSelesaiFinish" id="TanggalSelesaiFinish" value="<?php echo $TanggalSelesaiFinish; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamSelesaiFinish" id="JamSelesaiFinish" value="<?php echo $JamSelesaiFinish; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-12">
                                    <dt>Discharge Disposition</dt>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="dischargeDispositionStatus">Disposition Status</label>
                                    <?php echo $dischargeDispositionStatus;?>
                                </div>
                                <div class="col-md-8">
                                    <select name="dischargeDispositionStatus" id="dischargeDispositionStatus" class="form-control">
                                        <option <?php if($dischargeDispositionStatus==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($dischargeDispositionStatus=="home"){echo "selected";} ?> value="home">Home</option>
                                        <option <?php if($dischargeDispositionStatus=="alt-home"){echo "selected";} ?> value="alt-home">Alternative home</option>
                                        <option <?php if($dischargeDispositionStatus=="other-hcf"){echo "selected";} ?> value="other-hcf">Other healthcare facility</option>
                                        <option <?php if($dischargeDispositionStatus=="hosp"){echo "selected";} ?> value="hosp">Hospice</option>
                                        <option <?php if($dischargeDispositionStatus=="long"){echo "selected";} ?> value="long">Long-term care</option>
                                        <option <?php if($dischargeDispositionStatus=="aadvice"){echo "selected";} ?> value="aadvice">Left against advice</option>
                                        <option <?php if($dischargeDispositionStatus=="exp"){echo "selected";} ?> value="exp">Expired</option>
                                        <option <?php if($dischargeDispositionStatus=="psy"){echo "selected";} ?> value="psy">Psychiatric hospital</option>
                                        <option <?php if($dischargeDispositionStatus=="rehab"){echo "selected";} ?> value="rehab">Rehabilitation</option>
                                        <option <?php if($dischargeDispositionStatus=="snf"){echo "selected";} ?> value="snf">Skilled nursing facility</option>
                                        <option <?php if($dischargeDispositionStatus=="oth"){echo "selected";} ?> value="oth">The discharge disposition has not otherwise defined.</option>
                                    </select>
                                    <a href="https://terminology.hl7.org/5.2.0/CodeSystem-discharge-disposition.html" target="_blank" class="text-success">
                                        <small>Referensi <i class="ti ti-new-window"></i></small>
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="dischargeDispositionText">Disposition Text</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="dischargeDispositionText" id="dischargeDispositionText" value="<?php echo $dischargeDispositionText; ?>">
                                    <small>
                                        Contoh: Anjuran dokter untuk pulang dan kontrol kembali 1 bulan setelah minum obat
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-12" id="NotifikasiUpdateEncounter">
                                    <span class="text-primary">Pastikan Data Encounter Sudah Sesuai!</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-success">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-sm btn-inverse mr-2">
                                        <i class="ti-save"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                                        <i class="ti-close"></i> Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
<?php
                    }
                }
            }
        }
    }
?>