<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['resourceId'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Resource Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-success">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $resourceId=$_POST['resourceId'];
        $id_kunjungan=getDataDetail($Conn,"kunjungan_encounter",'IdSatuSehat',$resourceId,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"kunjungan_encounter",'IdSatuSehat',$resourceId,'id_pasien');
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $Token=GenerateTokenSatuSehat($Conn);
        $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
        if(empty($SettingSatuSehat)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-success">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
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
                echo '      <div class="col-md-12 text-danger text-center">';
                echo '          Gagal Melakukan Generate Token!';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="modal-footer bg-success">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12">';
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
                    echo '      <div class="col-md-12 text-danger text-center">';
                    echo '          Tidak Ada Pengaturan Base URL Satu Sehat!';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="modal-footer bg-success">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12">';
                    echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
                    echo '              <i class="ti-close"></i> Tutup';
                    echo '          </button>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $response=ProcedureById($baseurl_satusehat,$Token,$resourceId);
                    $json_decode =json_decode($response, true);
                    //ID IHS
                    if(!empty($json_decode['subject'])){
                        if(!empty($json_decode['subject']['display'])){
                            $nama=$json_decode['subject']['display'];
                        }else{
                            $nama="";
                        }
                        if(!empty($json_decode['subject']['reference'])){
                            $id_ihs=$json_decode['subject']['reference'];
                            $explode = explode("/" , $id_ihs);
                            if(!empty($explode[1])){
                                $id_ihs=$explode[1];
                            }else{
                                $id_ihs="";
                            }
                        }else{
                            $id_ihs="";
                        }
                    }else{
                        $nama="";
                        $id_ihs="";
                    }
                    //Encounter
                    if(!empty($json_decode['encounter']['reference'])){
                        $id_encounter=$json_decode['encounter']['reference'];
                        $explode = explode("/" , $id_encounter);
                            if(!empty($explode[1])){
                                $id_encounter=$explode[1];
                            }else{
                                $id_encounter="";
                            }
                    }else{
                        $id_encounter="";
                    }
                    //performedPeriod start
                    if(!empty($json_decode['performedPeriod']['start'])){
                        $start=$json_decode['performedPeriod']['start'];
                        $strtotime=strtotime($start);
                        $start_tanggal=date('Y-m-d',$strtotime);
                        $start_jam=date('H:i',$strtotime);
                    }else{
                        $start_tanggal="";
                        $start_jam="";
                    }
                    //performedPeriod end
                    if(!empty($json_decode['performedPeriod']['end'])){
                        $end=$json_decode['performedPeriod']['end'];
                        $strtotime=strtotime($end);
                        $end_tanggal=date('Y-m-d',$strtotime);
                        $end_jam=date('H:i',$strtotime);
                    }else{
                        $end_tanggal="";
                        $end_jam="";
                    }
                    //practitioner
                    if(!empty($json_decode['performer'])){
                        $performer=$json_decode['performer'];
                        foreach($performer as $ValueAuthor){
                            if(!empty($ValueAuthor['actor']['reference'])){
                                $id_practitioner=$ValueAuthor['actor']['reference'];
                                $explode = explode("/" , $id_practitioner);
                                if(!empty($explode[1])){
                                    $id_practitioner=$explode[1];
                                }else{
                                    $id_practitioner="";
                                }
                            }else{
                                $id_practitioner="";
                            }
                        }
                    }else{
                        $id_practitioner="";
                    }
                    //Category
                    if(!empty($json_decode['category']['text'])){
                        $coding=$json_decode['category']['coding'];
                        foreach($coding as $CategoryCoding){
                            if(!empty($CategoryCoding['code'])){
                                $CategoryCode=$CategoryCoding['code'];
                            }else{
                                $CategoryCode="";
                            }
                            if(!empty($CategoryCoding['display'])){
                                $CategoryDisplay=$CategoryCoding['display'];
                            }else{
                                $CategoryDisplay="";
                            }
                        }
                    }else{
                        $CategoryCode="";
                        $CategoryDisplay="";
                    }
                    //Procedure
                    if(!empty($json_decode['code'])){
                        if(!empty($json_decode['code']['coding'])){
                            $codevaluecoding=$json_decode['code']['coding'];
                            foreach($codevaluecoding as $codevaluecodinglist){
                                if(!empty($codevaluecodinglist['code'])){
                                    $ProcedureCode=$codevaluecodinglist['code'];
                                }
                                if(!empty($codevaluecodinglist['display'])){
                                    $ProcedureDisplay=$codevaluecodinglist['display'];
                                }
                            }
                        }else{
                            $ProcedureCode="";
                            $ProcedureDisplay="";
                        }
                    }else{
                        $ProcedureCode="";
                        $ProcedureDisplay="";
                    }
                    //Status
                    if(!empty($json_decode['status'])){
                        $status=$json_decode['status'];
                    }else{
                        $status="";
                    }
                    //Reson
                    if(!empty($json_decode['reasonCode'])){
                        if(!empty($json_decode['reasonCode'])){
                            $reasonCode=$json_decode['reasonCode'];
                            foreach($reasonCode as $reasonCodelist){
                                if(!empty($reasonCodelist['coding'])){
                                    $ResonCodeCoding=$reasonCodelist['coding'];
                                    foreach($ResonCodeCoding as $ResonCodeCodingList){
                                        if(!empty($ResonCodeCodingList['code'])){
                                            $ResonCodeCodingCode=$ResonCodeCodingList['code'];
                                        }else{
                                            $ResonCodeCodingCode="";
                                        }
                                        if(!empty($ResonCodeCodingList['display'])){
                                            $ResonCodeCodingDisplay=$ResonCodeCodingList['display'];
                                        }else{
                                            $ResonCodeCodingDisplay="";
                                        }
                                    }
                                }else{
                                    $ResonCodeCodingCode="";
                                    $ResonCodeCodingDisplay="";
                                }
                            }
                        }else{
                            $ResonCodeCodingCode="";
                            $ResonCodeCodingDisplay="";
                        }
                    }else{
                        $ResonCodeCodingCode="";
                        $ResonCodeCodingDisplay="";
                    }
                    //Body Site
                    if(!empty($json_decode['bodySite'])){
                        $bodySite=$json_decode['bodySite'];
                        foreach($bodySite as $bodySiteValue){
                            if(!empty($bodySiteValue['coding'])){
                                $BodySiteCoding=$bodySiteValue['coding'];
                                foreach($BodySiteCoding as $BodySiteCodingValue){
                                    if(!empty($BodySiteCodingValue['code'])){
                                        $BodySiteValueCode=$BodySiteCodingValue['code'];
                                    }
                                    if(!empty($BodySiteCodingValue['display'])){
                                        $BodySiteValueDisplay=$BodySiteCodingValue['display'];
                                    }
                                }
                            }
                        }
                    }
                    //Note
                    if(!empty($json_decode['note'])){
                        $note=$json_decode['note'];
                        foreach($note as $notelist){
                            $NoteText=$notelist['text'];
                        }
                    }
                    //Status
                    if(!empty($json_decode['status'])){
                        $StatusProcedure=$json_decode['status'];
                    }
?>
    <form action="javascript:void(0);" id="ProsesEditProcedure">
        <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
        <input type="hidden" name="resourceId" id="resourceId" value="<?php echo $resourceId; ?>">
        <div class="modal-body border-0 pb-0 mb-4">
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="id_pasien">No.RM</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="id_pasien" id="id_pasien" value="<?php echo "$id_pasien"; ?>">
                </div>
            </div>
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
                    <label for="id_encounter">ID Encounter</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="id_encounter" id="id_encounter" value="<?php echo "$id_encounter"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="tanggal_mulai">Waktu Mulai</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?php echo $start_tanggal; ?>">
                </div>
                <div class="col-md-4">
                    <input type="time" class="form-control" name="waktu_mulai" id="waktu_mulai" value="<?php echo $start_jam; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="tanggal_mulai">Waktu Selesai</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" value="<?php echo $end_tanggal; ?>">
                </div>
                <div class="col-md-4">
                    <input type="time" class="form-control" name="waktu_selesai" id="waktu_selesai" value="<?php echo $end_jam; ?>">
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
                                    if($id_practitioner==$id_ihs_practitioner){
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
                    <label for="category">Category</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="category" id="category" list="CategoryList" placeholder="Code|Display" value="<?php echo "$CategoryCode|$CategoryDisplay"; ?>">
                    <datalist id="CategoryList">
                        <!-- Category List Disini -->
                    </datalist>
                    <a href="http://snomed.info/sct" target="_blank" class="text-success">
                        <small>http://snomed.info/sct<i class="ti ti-new-window"></i></small>
                    </a>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="code_procedure">Procedure</label><br>
                    <small>
                        <input type="radio" name="ReferensiProcedur" id="ReferensiProcedurBPJS" value="BPJS"> <label for="ReferensiProcedurBPJS">Bridging BPJS</label><br>
                        <input type="radio" checked name="ReferensiProcedur" id="ReferensiProcedurSIMRS" value="SIMRS"> <label for="ReferensiProcedurSIMRS">Simrs</label><br>
                    </small>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="code_procedure" id="code_procedure" list="code_procedure_list" placeholder="Contoh: 87.44|Routine chest x-ray, so described" value="<?php echo "$ProcedureCode|$ProcedureDisplay"; ?>">
                    <datalist id="code_procedure_list">
                        <!-- Kode Procedure Disini -->
                    </datalist>
                    <small>
                        Format: Code|Description
                    </small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="reasonCode">Reason Code</label><br>
                    <small>
                        <input type="radio" name="ReferensiDiagnostic" id="ReferensiDiagnosticBpjs" value="BPJS"> <label for="ReferensiDiagnosticBpjs">Bridging BPJS</label><br>
                        <input type="radio" checked name="ReferensiDiagnostic" id="ReferensiDiagnosticSIMRS" value="SIMRS"> <label for="ReferensiDiagnosticSIMRS">Simrs</label><br>
                    </small>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="reasonCode" id="reasonCode" list="reasonCodeList" placeholder="Contoh: A15.0|Tuberculosis of lung" value="<?php echo "$ResonCodeCodingCode|$ResonCodeCodingDisplay"; ?>">
                    <datalist id="reasonCodeList">
                        <!-- Reson Code Disini -->
                    </datalist>
                    <small>Code ICD-10|Description</small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="bodySite">Body Site</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="bodySite" id="bodySite" list="bodySiteList" placeholder="Code|Display" value="<?php echo "$BodySiteValueCode|$BodySiteValueDisplay"; ?>">
                    <datalist id="bodySiteList">
                        <option value="103693007|Diagnostic procedure">
                    </datalist>
                    <a href="http://snomed.info/sct" target="_blank" class="text-success">
                        <small>http://snomed.info/sct<i class="ti ti-new-window"></i></small>
                    </a>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="status">Procedure Status</label>
                </div>
                <div class="col-md-8">
                    <select name="status" id="status" class="form-control">
                        <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($status=="preparation"){echo "selected";} ?> value="preparation">Persiapan</option>
                        <option <?php if($status=="in-progress"){echo "selected";} ?> value="in-progress">Berlangsung</option>
                        <option <?php if($status=="not-done"){echo "selected";} ?> value="not-done">Tidak dilakukan</option>
                        <option <?php if($status=="on-hold"){echo "selected";} ?> value="on-hold">Tertahan</option>
                        <option <?php if($status=="stopped"){echo "selected";} ?> value="stopped">Berhenti</option>
                        <option <?php if($status=="completed"){echo "selected";} ?> value="completed">Selesai</option>
                        <option <?php if($status=="entered-in-error"){echo "selected";} ?> value="entered-in-error">Salah masuk</option>
                        <option <?php if($status=="unknown"){echo "selected";} ?> value="unknown">Tidak diketahui</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="note">Catatan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="note" id="note" value="<?php echo $NoteText; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-12" id="NotifikasiEditProcedure">
                    <span class="text-primary">Pastikan Data Procedure Sudah Sesuai!</span>
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
?>