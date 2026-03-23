<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_ihs'])){
        echo '<span class="text-danger">ID IHS pasien Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_encounter'])){
                echo '<span class="text-danger">ID Encounter Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_kunjungan'])){
                    echo '<span class="text-danger">Tanggal Kunjungan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['ObservationStatus'])){
                        echo '<span class="text-danger">Observation Status Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['category'])){
                            echo '<span class="text-danger">Kategori Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['CodeSystemLoinc'])){
                                echo '<span class="text-danger">Code System Loinc Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['id_pasien'])){
                                    echo '<span class="text-danger">ID pasien Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['GetIdKunjungan'])){
                                        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['tipe_value'])){
                                            echo '<span class="text-danger">Tipe Value Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['IdPractitioner'])){
                                                echo '<span class="text-danger">ID Practitioner Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['GenerateIdObservation'])){
                                                    $GenerateIdObservation="";
                                                }else{
                                                    $GenerateIdObservation=$_POST['GenerateIdObservation'];
                                                }
                                                //Membuat Variabel
                                                $id_kunjungan=$_POST['GetIdKunjungan'];
                                                $id_pasien=$_POST['id_pasien'];
                                                $id_ihs=$_POST['id_ihs'];
                                                $nama=$_POST['nama'];
                                                $id_encounter=$_POST['id_encounter'];
                                                $tanggal_kunjungan=$_POST['tanggal_kunjungan'];
                                                $ObservationStatus=$_POST['ObservationStatus'];
                                                $category=$_POST['category'];
                                                $CodeSystemLoinc=$_POST['CodeSystemLoinc'];
                                                $tipe_value=$_POST['tipe_value'];
                                                $IdPractitioner=$_POST['IdPractitioner'];
                                                //Format Waktu
                                                $strtotime2=strtotime($tanggal_kunjungan);
                                                $issued=date('Y-m-d\TH:i:sP',$strtotime2);
                                                //Variabel Tidak Wajib
                                                if(empty($_POST['interpertasi'])){
                                                    $interpertasi="";
                                                    $interpertasi_display="";
                                                    $InterpertationJson="";
                                                }else{
                                                    $interpertasi=$_POST['interpertasi'];
                                                    //Definisikan Interpertasi
                                                    $interpertasi_list = array(
                                                        'A' => 'Abnormal',
                                                        'AA' => 'Critical abnormal',
                                                        'H' => 'High',
                                                        'H>' => 'Significantly high',
                                                        'HH' => 'Critical high',
                                                        'LL' => 'Critical low',
                                                        'L' => 'Low',
                                                        'L<' => 'Significantly low',
                                                        'N' => 'Normal',
                                                    );
                                                    $interpertasi_display=$interpertasi_list[$interpertasi];
                                                    $InterpertationArray=Array (
                                                        "0" => Array (
                                                            "coding" => Array (
                                                                "0" => Array (
                                                                    "system" => "http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation",
                                                                    "code" => $interpertasi,
                                                                    "display" => $interpertasi_display
                                                                )
                                                            )
                                                        )
                                                    );
                                                    $InterpertationJson= json_encode($InterpertationArray);
                                                }
                                                if(empty($_POST['CodeUnit'])){
                                                    $CodeUnit="";
                                                }else{
                                                    $CodeUnit=$_POST['CodeUnit'];
                                                }
                                                //Pecah Code System
                                                $Explode = explode("|" , $CodeSystemLoinc);
                                                $KodeCodeSystemLoinc=$Explode[0];
                                                $NamaCodeSystemLoinc=$Explode[1];
                                                //Routing tipe_value
                                                if($tipe_value=="valueQuantity"){
                                                    if(empty($_POST['value'])){
                                                        $ValidasiValue="Value Tidak Boleh Kosong!";
                                                    }else{
                                                        if(empty($_POST['unit'])){
                                                            $ValidasiValue="Unit Tidak Boleh Kosong!";
                                                        }else{
                                                            if(empty($_POST['CodeUnit'])){
                                                                $ValidasiValue="Code Unit Tidak Boleh Kosong!";
                                                            }else{
                                                                $value=intval($_POST['value']);
                                                                $unit=$_POST['unit'];
                                                                $CodeUnit=$_POST['CodeUnit'];
                                                                $RawValue = array(
                                                                    'value' => $value,
                                                                    'unit' => $unit,
                                                                    'system' => 'http://unitsofmeasure.org',
                                                                    'code' => $CodeUnit
                                                                );
                                                                $RawValueEncode = json_encode($RawValue);
                                                                $ValidasiValue="Valid";
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    if($tipe_value=="valueCodeableConcept"){
                                                        $value=$_POST['value'];
                                                        //Pecah
                                                        $ExplodeValue = explode("|" , $value);
                                                        $CodeValue=$ExplodeValue[0];
                                                        $DisplayValue=$ExplodeValue[1];
                                                        $RawValuecoding=Array (
                                                            "0" => Array (
                                                                'system' => 'http://terminology.kemkes.go.id/CodeSystem/clinical-term',
                                                                'code' => $CodeValue,
                                                                'display' => $DisplayValue
                                                            )
                                                        );
                                                        $RawValue = array(
                                                            'coding' => $RawValuecoding,
                                                        );
                                                        $RawValueEncode = json_encode($RawValue);
                                                        $ValidasiValue="Valid";
                                                    }else{
                                                        $ValidasiValue="Tipe Value Tidak Diketahui";
                                                    }
                                                }
                                                if($ValidasiValue!=="Valid"){
                                                    echo '<span class="text-danger">'.$ValidasiValue.'</span>';
                                                }else{
                                                    //Apabila Proses Generate ID Condition 
                                                    if($GenerateIdObservation!=="Ya"){
                                                        if(empty($_POST['id_observation'])){
                                                            $id_observation="";
                                                        }else{
                                                            $id_observation=$_POST['id_observation'];
                                                        }
                                                        $entry="INSERT INTO kunjungan_observation (
                                                            id_observation,
                                                            id_pasien,
                                                            id_kunjungan,
                                                            id_ihs,
                                                            id_encounter,
                                                            id_ihs_practitioner,
                                                            status,
                                                            category,
                                                            observation_code,
                                                            observation_display,
                                                            tipe_value,
                                                            raw_value,
                                                            raw_interpertation
                                                        ) VALUES (
                                                            '$id_observation',
                                                            '$id_pasien',
                                                            '$id_kunjungan',
                                                            '$id_ihs',
                                                            '$id_encounter',
                                                            '$IdPractitioner',
                                                            '$ObservationStatus',
                                                            '$category',
                                                            '$KodeCodeSystemLoinc',
                                                            '$NamaCodeSystemLoinc',
                                                            '$tipe_value',
                                                            '$RawValueEncode',
                                                            '$InterpertationJson'
                                                        )";
                                                        $hasil=mysqli_query($Conn, $entry);
                                                        if($hasil){
                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Observation ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                            if($MenyimpanLog=="Berhasil"){
                                                                echo '<span class="text-success" id="NotifikasiTambahObservationBerhasil">Success</span>';
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                            }
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Observation</span>';
                                                        }
                                                    }else{
                                                        //Definisikan category
                                                        $category_list = array(
                                                            'social-history' => 'Social History',
                                                            'vital-signs' => 'Vital Signs',
                                                            'imaging' => 'Imaging',
                                                            'laboratory' => 'Laboratory',
                                                            'procedure' => 'Procedure',
                                                            'survey' => 'Survey',
                                                            'exam' => 'Exam',
                                                            'therapy' => 'Therapy',
                                                            'activity' => 'Activity'
                                                        );
                                                        $categoryDisplay=$category_list[$category];
                                                        //1. Cek pengaturan
                                                        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
                                                        if(empty($SettingSatuSehat)){
                                                            echo '<span class="text-danger">Tidak Ada Pengaturan Satu Sehat Yang Aktiv!</span>';
                                                        }else{
                                                            //2. Generate Token
                                                            $Token=GenerateTokenSatuSehat($Conn);
                                                            if(empty($Token)){
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Generate Token</span>';
                                                            }else{
                                                                //3. base URL
                                                                $baseurl_satusehat=getDataDetail($Conn,' setting_satusehat','status','Active','baseurl');
                                                                //Membentuk Data
                                                                $categoryArray=Array (
                                                                    "0" => Array (
                                                                        "coding" => Array (
                                                                            "0" => Array (
                                                                                "system" => "http://terminology.hl7.org/CodeSystem/observation-category",
                                                                                "code" => $category,
                                                                                "display" => $categoryDisplay
                                                                            )
                                                                        )
                                                                    )
                                                                );
                                                                $codeArray=Array (
                                                                    "coding" => Array (
                                                                        "0" => Array (
                                                                            "system" => "http://loinc.org",
                                                                            "code" => $KodeCodeSystemLoinc,
                                                                            "display" => $NamaCodeSystemLoinc
                                                                        )
                                                                    )
                                                                );
                                                                $subjectArray=Array (
                                                                    "reference" => "Patient/$id_ihs"
                                                                );
                                                                $performerArray=Array (
                                                                    "0" => Array (
                                                                        "reference" => "Practitioner/$IdPractitioner"
                                                                    )
                                                                );
                                                                $encounterArray=Array (
                                                                    "reference" => "Encounter/$id_encounter",
                                                                    "display" => "Pemeriksaan $NamaCodeSystemLoinc $nama di Tanggal, $tanggal_kunjungan"
                                                                );
                                                                $InterpertationArray=Array (
                                                                    "0" => Array (
                                                                        "coding" => Array (
                                                                            "0" => Array (
                                                                                "system" => "http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation",
                                                                                "code" => $interpertasi,
                                                                                "display" => $interpertasi_display
                                                                            )
                                                                        )
                                                                    )
                                                                );
                                                                if(empty($_POST['interpertasi'])){
                                                                    $KirimData = array(
                                                                        'resourceType' => 'Observation',
                                                                        'status' => "$ObservationStatus",
                                                                        'category' => $categoryArray,
                                                                        'code' => $codeArray,
                                                                        'subject' => $subjectArray,
                                                                        'performer' => $performerArray,
                                                                        'encounter' => $encounterArray,
                                                                        'effectiveDateTime' => $tanggal_kunjungan,
                                                                        'issued' => $issued,
                                                                        ''.$tipe_value.'' => $RawValue
                                                                    );
                                                                }else{
                                                                    $KirimData = array(
                                                                        'resourceType' => 'Observation',
                                                                        'status' => "$ObservationStatus",
                                                                        'category' => $categoryArray,
                                                                        'code' => $codeArray,
                                                                        'subject' => $subjectArray,
                                                                        'performer' => $performerArray,
                                                                        'encounter' => $encounterArray,
                                                                        'effectiveDateTime' => $issued,
                                                                        'issued' => $issued,
                                                                        ''.$tipe_value.'' => $RawValue,
                                                                        'interpretation' => $InterpertationArray
                                                                    );
                                                                }
                                                                $JsonEncode = json_encode($KirimData);
                                                                $response=CreatObservation($baseurl_satusehat,$JsonEncode,$Token);
                                                                if(empty($response)){
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                                }else{
                                                                    $JsonData =json_decode($response, true);
                                                                    if(empty($JsonData['id'])){
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                        echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                        echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                    }else{
                                                                        $id_observation=$JsonData['id'];
                                                                        //Simpan Data Ke Database
                                                                        $entry="INSERT INTO kunjungan_observation (
                                                                            id_observation,
                                                                            id_pasien,
                                                                            id_kunjungan,
                                                                            id_ihs,
                                                                            id_encounter,
                                                                            id_ihs_practitioner,
                                                                            status,
                                                                            category,
                                                                            observation_code,
                                                                            observation_display,
                                                                            tipe_value,
                                                                            raw_value,
                                                                            raw_interpertation
                                                                        ) VALUES (
                                                                            '$id_observation',
                                                                            '$id_pasien',
                                                                            '$id_kunjungan',
                                                                            '$id_ihs',
                                                                            '$id_encounter',
                                                                            '$IdPractitioner',
                                                                            '$ObservationStatus',
                                                                            '$category',
                                                                            '$KodeCodeSystemLoinc',
                                                                            '$NamaCodeSystemLoinc',
                                                                            '$tipe_value',
                                                                            '$RawValueEncode',
                                                                            '$InterpertationJson'
                                                                        )";
                                                                        $hasil=mysqli_query($Conn, $entry);
                                                                        if($hasil){
                                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Obsertvation ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                            if($MenyimpanLog=="Berhasil"){
                                                                                echo '<span class="text-success" id="NotifikasiTambahObservationBerhasil">Success</span>';
                                                                            }else{
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                            }
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Observation</span>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>