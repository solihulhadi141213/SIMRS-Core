<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Buka pengaturan
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['GetIdPasien'])){
        echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['GetIdKunjungan'])){
            echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_ihs'])){
                echo '<span class="text-danger">ID IHS Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['nama'])){
                    echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['ActCode'])){
                        echo '<span class="text-danger">Action Code Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['ParticipationType'])){
                            echo '<span class="text-danger">Participation Type Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['IdPractitioner'])){
                                echo '<span class="text-danger">Id Practitioner Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['TanggalMulai'])){
                                    echo '<span class="text-danger">Tanggal Mulai Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['JamMulai'])){
                                        echo '<span class="text-danger">Jam Mulai Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['TanggalSelesai'])){
                                            echo '<span class="text-danger">Tanggal Selesai Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['JamSelesai'])){
                                                echo '<span class="text-danger">Jam Selesai Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['IdLocation'])){
                                                    echo '<span class="text-danger">ID Location Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['serviceProvider'])){
                                                        echo '<span class="text-danger">service Provider Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        //Membuat Variabel
                                                        $id_pasien=$_POST['GetIdPasien'];
                                                        $id_kunjungan=$_POST['GetIdKunjungan'];
                                                        $id_ihs=$_POST['id_ihs'];
                                                        $nama=$_POST['nama'];
                                                        $ActCode=$_POST['ActCode'];
                                                        $ParticipationType=$_POST['ParticipationType'];
                                                        $IdPractitioner=$_POST['IdPractitioner'];
                                                        $TanggalMulai=$_POST['TanggalMulai'];
                                                        $JamMulai=$_POST['JamMulai'];
                                                        $TanggalSelesai=$_POST['TanggalSelesai'];
                                                        $JamSelesai=$_POST['JamSelesai'];
                                                        $IdLocation=$_POST['IdLocation'];
                                                        $serviceProvider=$_POST['serviceProvider'];
                                                        $WaktuMulai="$TanggalMulai $JamMulai";
                                                        $WaktuSelesai="$TanggalSelesai $JamSelesai";
                                                        $strtotime1=strtotime($WaktuMulai);
                                                        $strtotime2=strtotime($WaktuSelesai);
                                                        $WaktuMulai=date('Y-m-d\TH:i:sP',$strtotime1);
                                                        $WaktuSelesai=date('Y-m-d\TH:i:sP',$strtotime2);
                                                        //Mencari Nama Practitioner
                                                        $NamaPractitioner=getDataDetail($Conn,"referensi_practitioner",'id_ihs_practitioner',$IdPractitioner,'nama');
                                                        $NamaLocation=getDataDetail($Conn,"referensi_location",'id_location',$IdLocation,'nama');
                                                        //Inisiasi ActCode
                                                        $ActCodeList = array(
                                                            'AMB' => 'ambulatory',
                                                            'EMER' => 'emergency',
                                                            'FLD' => 'field',
                                                            'HH' => 'home health',
                                                            'IMP' => 'inpatient encounter',
                                                            'ACUTE' => 'inpatient acute',
                                                            'OBSENC' => 'observation encounter',
                                                            'PRENC' => 'pre-admission',
                                                            'SS' => 'short stay',
                                                            'VR' => 'virtual'
                                                        );
                                                        $ActDisplay=$ActCodeList[$ActCode];
                                                        //Inisiasi Participation Type
                                                        $ParticipationTypeList = array(
                                                            'ADM' => 'admitter',
                                                            'ATND' => 'attender',
                                                            'CALLBCK' => 'callback contact',
                                                            'CON' => 'consultant',
                                                            'DIS' => 'discharger',
                                                            'ESC' => 'escort',
                                                            'REF' => 'referrer'
                                                        );
                                                        $ParticipationTypeDisplay=$ParticipationTypeList[$ParticipationType];
                                                        //Buka ID Organization
                                                        //1. Cek pengaturan
                                                        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
                                                        if(empty($SettingSatuSehat)){
                                                            echo '<span class="text-danger">Tidak Ada Pengaturan Satu Sehat Yang Aktiv!</span>';
                                                        }else{
                                                            //1. Generate Token
                                                            $Token=GenerateTokenSatuSehat($Conn);
                                                            if(empty($Token)){
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Generate Token</span>';
                                                            }else{
                                                                //Insert Organization Ke Satu Sehat
                                                                $baseurl_satusehat=getDataDetail($Conn,' setting_satusehat','status','Active','baseurl');
                                                                $class = Array(
                                                                    'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                                                                    'code' => ''.$ActCode.'',
                                                                    'display' => ''.$ActDisplay.''
                                                                );
                                                                $subject = Array(
                                                                    'reference' => 'Patient/'.$id_ihs.'',
                                                                    'display' => ''.$nama.'',
                                                                );
                                                                $participantTypecoding=Array (
                                                                    "0" => Array (
                                                                        "system" => "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                                                        "code" => "$ParticipationType",
                                                                        "display" => "$ParticipationTypeDisplay",
                                                                    )
                                                                );
                                                                $participantType=Array (
                                                                    "0" => Array (
                                                                        "coding" => $participantTypecoding
                                                                    )
                                                                );
                                                                $participantIndividual=Array (
                                                                    "reference" => "Practitioner/$IdPractitioner",
                                                                    "display" => "$NamaPractitioner",
                                                                );
                                                                $participant=Array (
                                                                    "0" => Array (
                                                                        "type" => $participantType,
                                                                        "individual" => $participantIndividual,
                                                                    )
                                                                );
                                                                $period=Array (
                                                                    "start" => "$WaktuMulai",
                                                                    "end" => "$WaktuSelesai",
                                                                );
                                                                $location=Array (
                                                                    "reference" => "Location/$IdLocation",
                                                                    "display" => "$NamaLocation",
                                                                );
                                                                $location=Array (
                                                                    "0" => Array (
                                                                        "location" => $location
                                                                    )
                                                                );
                                                                $statusHistoryperiod=Array (
                                                                    "start" => "$WaktuMulai",
                                                                    "end" => "$WaktuSelesai",
                                                                );
                                                                $statusHistory=Array (
                                                                    "0" => Array (
                                                                        "status" => "arrived",
                                                                        "period" => $statusHistoryperiod
                                                                    )
                                                                );
                                                                $serviceProvider2=Array (
                                                                    "reference" => "Organization/$organization_id"
                                                                );
                                                                $identifier=Array (
                                                                    "0" => Array (
                                                                        "system" => "http://sys-ids.kemkes.go.id/organization/$organization_id",
                                                                        "value" => "$id_kunjungan"
                                                                    )
                                                                );
                                                                $KirimData = array(
                                                                    'resourceType' => 'Encounter',
                                                                    'status' => 'arrived',
                                                                    'class' => $class,
                                                                    'subject' => $subject,
                                                                    'participant' => $participant,
                                                                    'period' => $period,
                                                                    'location' => $location,
                                                                    'statusHistory' => $statusHistory,
                                                                    'serviceProvider' => $serviceProvider2,
                                                                    'identifier' => $identifier
                                                                );
                                                                $JsonEncode = json_encode($KirimData);
                                                                $response=CreatEncounter($baseurl_satusehat,$JsonEncode,$Token);
                                                                if(empty($response)){
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                                }else{
                                                                    $JsonData =json_decode($response, true);
                                                                    if(empty($JsonData['id'])){
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                        echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                        echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                    }else{
                                                                        $id_encounter=$JsonData['id'];
                                                                        //Simpan Data Ke Database
                                                                        $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
                                                                            id_encounter='$id_encounter',
                                                                            updatetime='$updatetime'
                                                                        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn)); 
                                                                        if($UpdateKunjungan){
                                                                            $LogJsonFile="../../_Page/Log/Log.json";
                                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Encounter ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                            if($MenyimpanLog=="Berhasil"){
                                                                                $_SESSION['NotifikasiSwal']="Creat Encounter Berhasil";
                                                                                echo '<span class="text-success" id="NotifikasiTambahEncounterBerhasil">Success</span>';
                                                                            }else{
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                            }
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Data pasien</span>';
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