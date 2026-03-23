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
                        if(!empty($json_decode['subject']['reference'])){
                            $id_ihs=$json_decode['subject']['reference'];
                        }else{
                            $id_ihs="";
                        }
                        $PecahIhs = explode("/" , $id_ihs);
                        $id_ihs=$PecahIhs[1];
                        if(!empty($json_decode['subject']['display'])){
                            $nama=$json_decode['subject']['display'];
                        }else{
                            $nama="";
                        }
                        if(!empty($json_decode['subject']['display'])){
                            $nama=$json_decode['subject']['display'];
                        }else{
                            $nama="";
                        }
                        if(!empty($json_decode['class']['code'])){
                            $ActCodeEncounter=$json_decode['class']['code'];
                        }else{
                            $ActCodeEncounter="";
                            echo $response;
                        }
                        if(!empty($json_decode['participant'])){
                            $participant=$json_decode['participant'];
                            if(!empty(count($participant))){
                                foreach($participant as $Valueparticipant){
                                    $individual=$Valueparticipant['individual'];
                                    $individualdisplay=$individual['display'];
                                    $individualreference=$individual['reference'];
                                    $type=$Valueparticipant['type'];
                                    if(!empty(count($type))){
                                        foreach($type as $ValueType){
                                            if(!empty(count($ValueType['coding']))){
                                                $coding=$ValueType['coding'];
                                                foreach($coding as $ValueCoding){
                                                    $participant_code=$ValueCoding['code'];
                                                    $display=$ValueCoding['display'];
                                                    $system=$ValueCoding['system'];
                                                }
                                            }
                                        }
                                    }else{
                                        $participant_code="";
                                    }
                                }
                            }
                        }else{
                            $individualreference="";
                            $participant_code="";
                        }
                        $Pecah = explode("/" , $individualreference);
                        $IdPractitioner=$Pecah[1];
                        //Buka Location
                        if(!empty($json_decode['location'])){
                            $location=$json_decode['location'];
                            if(!empty(count($location))){
                                foreach($location as $ValueLocation){
                                    $ReferenceIdLocation=$ValueLocation['location']['reference'];
                                    $display=$ValueLocation['location']['display'];
                                }
                            }else{
                                $ReferenceIdLocation="";
                            }
                        }else{
                            $ReferenceIdLocation="";
                        }
                        $PecahLocation = explode("/" , $ReferenceIdLocation);
                        $GetIdLocation=$PecahLocation[1];
                        if(!empty($json_decode['serviceProvider']['reference'])){
                            $IdServiceProvider=$json_decode['serviceProvider']['reference'];
                        }else{
                            $IdServiceProvider="";
                        }
                        $PecahProvider = explode("/" , $IdServiceProvider);
                        $GetServiceProvider=$PecahProvider[1];
                        //Buka Waktu Arrived
                        if(!empty($json_decode['period'])){
                            if(!empty($json_decode['period']['start'])){
                                $WaktuMulai=$json_decode['period']['start'];
                                $strtotimewaktumulai=strtotime($WaktuMulai);
                                $TanggalMulai=date('Y-m-d',$strtotimewaktumulai);
                                $JamMulai=date('H:i',$strtotimewaktumulai);
                            }else{
                                $TanggalMulai="";
                                $JamMulai="";
                            }
                            if(!empty($json_decode['period']['end'])){
                                $WaktuSelesai=$json_decode['period']['end'];
                                $strtotimewaktuselesai=strtotime($WaktuSelesai);
                                $TanggalSelesai=date('Y-m-d',$strtotimewaktuselesai);
                                $JamSelesai=date('H:i',$strtotimewaktuselesai);
                            }else{
                                $TanggalSelesai="";
                                $JamSelesai="";
                            }
                        }else{
                            $TanggalMulai="";
                            $JamMulai="";
                            $TanggalSelesai="";
                            $JamSelesai="";
                        }

?>
                    <form action="javascript:void(0);" id="ProsesEditEncounter">
                        <input type="hidden" name="id_encounter" id="id_encounter" value="<?php echo $id_encounter; ?>">
                        <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
                        <div class="modal-body border-0 pb-0 mb-4">
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="id_ihs">ID IHS</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="id_ihs" id="id_ihs" value="<?php echo "$id_ihs"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="nama">Patient Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="ActCode">Action Code</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="ActCode" id="ActCode" class="form-control">
                                        <option <?php if($ActCodeEncounter==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($ActCodeEncounter=="AMB"){echo "selected";} ?> value="AMB">Ambulatory</option>
                                        <option <?php if($ActCodeEncounter=="EMER"){echo "selected";} ?> value="EMER">Emergency</option>
                                        <option <?php if($ActCodeEncounter=="FLD"){echo "selected";} ?> value="FLD">Field</option>
                                        <option <?php if($ActCodeEncounter=="HH"){echo "selected";} ?> value="HH">Home Health</option>
                                        <option <?php if($ActCodeEncounter=="ACUTE"){echo "selected";} ?> value="ACUTE">Inpatient Acute</option>
                                        <option <?php if($ActCodeEncounter=="NONAC"){echo "selected";} ?> value="NONAC">Inpatient Non-Acute</option>
                                        <option <?php if($ActCodeEncounter=="OBSENC"){echo "selected";} ?> value="OBSENC">Observation Encounter</option>
                                        <option <?php if($ActCodeEncounter=="PRENC"){echo "selected";} ?> value="PRENC">Pre-Admission</option>
                                        <option <?php if($ActCodeEncounter=="SS"){echo "selected";} ?> value="SS">Short Stay</option>
                                        <option <?php if($ActCodeEncounter=="VR"){echo "selected";} ?> value="VR">Virtual</option>
                                    </select>
                                    <a href="http://terminology.hl7.org/CodeSystem/v3-ActCode" class="text-success">
                                        <small>Referensi <i class="ti ti-new-window"></i></small>
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="ParticipationType">Participation Type</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="ParticipationType" id="ParticipationType" class="form-control">
                                        <option <?php if($participant_code==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($participant_code=="ADM"){echo "selected";} ?> value="ADM">Admitter</option>
                                        <option <?php if($participant_code=="ATND"){echo "selected";} ?> value="ATND">Attender</option>
                                        <option <?php if($participant_code=="CALLBCK"){echo "selected";} ?> value="CALLBCK">Callback Contact</option>
                                        <option <?php if($participant_code=="CON"){echo "selected";} ?> value="CON">Consultant</option>
                                        <option <?php if($participant_code=="DIS"){echo "selected";} ?> value="DIS">Discharger</option>
                                        <option <?php if($participant_code=="ESC"){echo "selected";} ?> value="ESC">Escort</option>
                                        <option <?php if($participant_code=="REF"){echo "selected";} ?> value="REF">Referrer</option>
                                    </select>
                                    <a href="https://terminology.hl7.org/5.1.0/CodeSystem-v3-ParticipationType.html" class="text-success">
                                        <small>Referensi <i class="ti ti-new-window"></i></small>
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="IdPractitioner">ID Practitioner</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="IdPractitioner" id="IdPractitioner" class="form-control">
                                        <option value="">Pilih</option>
                                        <?php
                                            $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY nama ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                if(!empty($data['id_ihs_practitioner'])){
                                                    $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                                    $nama= $data['nama'];
                                                    if($IdPractitioner==$id_ihs_practitioner){
                                                        echo '<option selected value="'.$id_ihs_practitioner.'">'.$nama.'</option>';
                                                    }else{
                                                        echo '<option value="'.$id_ihs_practitioner.'">'.$nama.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalMulai">Period Start</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalMulai" id="TanggalMulai" value="<?php echo $TanggalMulai; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamMulai" id="JamMulai" value="<?php echo $JamMulai; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="TanggalSelesai">Period End</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="TanggalSelesai" id="TanggalSelesai" value="<?php echo $TanggalSelesai; ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="JamSelesai" id="JamSelesai" value="<?php echo $JamSelesai; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="IdLocation">Location</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="IdLocation" id="IdLocation" class="form-control">
                                        <option value="">Pilih</option>
                                        <?php
                                            $query = mysqli_query($Conn, "SELECT*FROM referensi_location ORDER BY nama ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                if(!empty($data['id_location'])){
                                                    $id_location= $data['id_location'];
                                                    $nama= $data['nama'];
                                                    if($GetIdLocation==$id_location){
                                                        echo '<option selected value="'.$id_location.'">'.$nama.'</option>';
                                                    }else{
                                                        echo '<option value="'.$id_location.'">'.$nama.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4">
                                    <label for="serviceProvider">Service Provider</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="serviceProvider" id="serviceProvider" class="form-control">
                                        <option value="">Pilih</option>
                                        <?php
                                            $query_organization = mysqli_query($Conn, "SELECT*FROM referensi_organisasi ORDER BY nama ASC");
                                            while ($data_org = mysqli_fetch_array($query_organization)) {
                                                if(!empty($data_org['ID_Org'])){
                                                    $ID_Org= $data_org['ID_Org'];
                                                    $NamaOrganisasi= $data_org['nama'];
                                                    if($GetServiceProvider==$ID_Org){
                                                        echo '<option selected value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                                    }else{
                                                        echo '<option value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-12" id="NotifikasiEditEncounter">
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