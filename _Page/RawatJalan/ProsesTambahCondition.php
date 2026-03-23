<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    $LogJsonFile="../../_Page/Log/Log.json";
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
                    if(empty($_POST['clinicalStatus'])){
                        echo '<span class="text-danger">Clinical Status Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['category'])){
                            echo '<span class="text-danger">Kategori Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['coding_system'])){
                                echo '<span class="text-danger">Code System Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['id_pasien'])){
                                    echo '<span class="text-danger">ID pasien Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['GetIdKunjungan'])){
                                        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['GenerateIdCondition'])){
                                            $GenerateIdCondition="";
                                        }else{
                                            $GenerateIdCondition=$_POST['GenerateIdCondition'];
                                        }
                                        //Membuat Variabel
                                        $id_kunjungan=$_POST['GetIdKunjungan'];
                                        $id_pasien=$_POST['id_pasien'];
                                        $id_ihs=$_POST['id_ihs'];
                                        $nama=$_POST['nama'];
                                        $id_encounter=$_POST['id_encounter'];
                                        $tanggal_kunjungan=$_POST['tanggal_kunjungan'];
                                        $clinicalStatus=$_POST['clinicalStatus'];
                                        $clinicalStatus2=$_POST['clinicalStatus'];
                                        $category=$_POST['category'];
                                        $category2=$_POST['category'];
                                        $coding_system=$_POST['coding_system'];
                                        //Pecah Diagnosa
                                        $Explode = explode("-" , $coding_system);
                                        $KodeDiagnosa=$Explode[0];
                                        $NamaDiagnosa=$Explode[1];
                                        //Apabila Proses Generate ID Condition 
                                        if($GenerateIdCondition!=="Ya"){
                                            if(empty($_POST['id_condition'])){
                                                echo '<span class="text-danger">ID Condition Tidak Boleh Kosong!</span>';
                                            }else{
                                                $id_condition=$_POST['id_condition'];
                                                $entry="INSERT INTO kunjungan_condition (
                                                    id_kunjungan,
                                                    id_pasien,
                                                    id_ihs,
                                                    id_encounter,
                                                    id_condition,
                                                    category,
                                                    clinicalStatus,
                                                    code_system
                                                ) VALUES (
                                                    '$id_kunjungan',
                                                    '$id_pasien',
                                                    '$id_ihs',
                                                    '$id_encounter',
                                                    '$id_condition',
                                                    '$category2',
                                                    '$clinicalStatus2',
                                                    '$coding_system'
                                                )";
                                                $hasil=mysqli_query($Conn, $entry);
                                                if($hasil){
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Condition ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        $_SESSION['NotifikasiSwal']="Creat Condition Berhasil";
                                                        echo '<span class="text-success" id="NotifikasiTambahConditionBerhasil">Success</span>';
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Condition</span>';
                                                }
                                            }
                                        }else{
                                            //Definisikan clinicalStatus
                                            $clinicalStatus_list = array(
                                                'active' => 'Active',
                                                'recurrence' => 'Recurrence',
                                                'relapse' => 'Relapse',
                                                'inactive' => 'Inactive',
                                                'remission' => 'Remission',
                                                'resolved' => 'Resolved',
                                                'unknown' => 'Unknown'
                                            );
                                            $clinicalStatusDisplay=$clinicalStatus_list[$clinicalStatus];
                                            //Definisikan Kategori
                                            $category_list = array(
                                                'problem-list-item' => 'Problem List Item',
                                                'encounter-diagnosis' => 'Encounter Diagnosis'
                                            );
                                            $category_display=$category_list[$category];
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
                                                    $clinicalStatusCoding=Array (
                                                        "0" => Array (
                                                            "system" => "http://terminology.hl7.org/CodeSystem/condition-clinical",
                                                            "code" => "$clinicalStatus",
                                                            "display" => "$clinicalStatusDisplay"
                                                        )
                                                    );
                                                    $clinicalStatus=Array (
                                                        "coding" => $clinicalStatusCoding
                                                    );
                                                    $category_coding=Array (
                                                        "0" => Array (
                                                            "system" => "http://terminology.hl7.org/CodeSystem/condition-category",
                                                            "code" => "$category",
                                                            "display" => "$category_display"
                                                        )
                                                    );
                                                    $category=Array (
                                                        "0" => Array (
                                                            "coding" => $category_coding
                                                        )
                                                    );
                                                    $CodeCoding=Array (
                                                        "0" => Array (
                                                            "system" => "http://hl7.org/fhir/sid/icd-10",
                                                            "code" => "$KodeDiagnosa",
                                                            "display" => "$NamaDiagnosa"
                                                        )
                                                    );
                                                    $code=Array (
                                                        "coding" => $CodeCoding
                                                    );
                                                    $subject=Array (
                                                        "reference" => "Patient/$id_ihs",
                                                        "display" => "$nama",
                                                    );
                                                    $encounter=Array (
                                                        "reference" => "Encounter/$id_encounter",
                                                        "display" => "Kunjungan $nama pada Tanggal $tanggal_kunjungan"
                                                    );
                                                    $KirimData = array(
                                                        'resourceType' => 'Condition',
                                                        'clinicalStatus' => $clinicalStatus,
                                                        'category' => $category,
                                                        'code' => $code,
                                                        'subject' => $subject,
                                                        'encounter' => $encounter
                                                    );
                                                    $JsonEncode = json_encode($KirimData);
                                                    $response=CreatCondition($baseurl_satusehat,$JsonEncode,$Token);
                                                    if(empty($response)){
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                    }else{
                                                        $JsonData =json_decode($response, true);
                                                        if(empty($JsonData['id'])){
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                            echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                            echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                        }else{
                                                            $id_condition=$JsonData['id'];
                                                            //Simpan Data Ke Database
                                                            $entry="INSERT INTO kunjungan_condition (
                                                                id_kunjungan,
                                                                id_pasien,
                                                                id_ihs,
                                                                id_encounter,
                                                                id_condition,
                                                                category,
                                                                clinicalStatus,
                                                                code_system
                                                            ) VALUES (
                                                                '$id_kunjungan',
                                                                '$id_pasien',
                                                                '$id_ihs',
                                                                '$id_encounter',
                                                                '$id_condition',
                                                                '$category2',
                                                                '$clinicalStatus2',
                                                                '$coding_system'
                                                            )";
                                                            $hasil=mysqli_query($Conn, $entry);
                                                            if($hasil){
                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Condition ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                if($MenyimpanLog=="Berhasil"){
                                                                    $_SESSION['NotifikasiSwal']="Creat Condition Berhasil";
                                                                    echo '<span class="text-success" id="NotifikasiTambahConditionBerhasil">Success</span>';
                                                                }else{
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                }
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Condition</span>';
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