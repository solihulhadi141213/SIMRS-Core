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
    if(empty($_POST['id_encounter'])){
        echo '<span class="text-danger">ID Encounter Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['GetIdKunjungan'])){
            echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['StatusEncounter'])){
                echo '<span class="text-danger">Status Encounter Tidak Boleh Kosong!</span>';
            }else{
                //Membuat Variabel
                $id_encounter=$_POST['id_encounter'];
                $id_kunjungan=$_POST['GetIdKunjungan'];
                $StatusEncounter=$_POST['StatusEncounter'];
                //Buka Variabel Yang Tidak Wajib
                //Validasi Arrive
                if(!empty($_POST['TanggalMulaiArrive'])){
                    if(!empty($_POST['JamMulaiArrive'])){
                        if(!empty($_POST['TanggalSelesaiArrive'])){
                            if(!empty($_POST['JamSelesaiArrive'])){
                                $TanggalMulaiArrive=$_POST['TanggalMulaiArrive'];
                                $JamMulaiArrive=$_POST['JamMulaiArrive'];
                                $TanggalSelesaiArrive=$_POST['TanggalSelesaiArrive'];
                                $JamSelesaiArrive=$_POST['JamSelesaiArrive'];
                                $ValidasiArrive="Valid";
                                $WaktuMulaiArrive="$TanggalMulaiArrive $JamMulaiArrive";
                                $WaktuSelesaiArrive="$TanggalSelesaiArrive $JamSelesaiArrive";
                                $strtotime1=strtotime($WaktuMulaiArrive);
                                $strtotime2=strtotime($WaktuSelesaiArrive);
                                $WaktuMulaiArrive=date('Y-m-d\TH:i:sP',$strtotime1);
                                $WaktuSelesaiArrive=date('Y-m-d\TH:i:sP',$strtotime2);
                                $status_history_arrived=Array (
                                    "start" => "$WaktuMulaiArrive",
                                    "end" => "$WaktuSelesaiArrive",
                                );
                                $status_history_arrived=Array (
                                    "status" => "arrived",
                                    "period" => $status_history_arrived,
                                );
                            }else{
                                $status_history_arrived="";
                                $ValidasiArrive="Jam Selesai Arrive Tidak Boleh Kosong!";
                            }
                        }else{
                            $status_history_arrived="";
                            $ValidasiArrive="Tanggal Selesai Arrive Tidak Boleh Kosong!";
                        }
                    }else{
                        $status_history_arrived="";
                        $ValidasiArrive="Jam Mulai Arrive Tidak Boleh Kosong!";
                    }
                }else{
                    $status_history_arrived="";
                    $ValidasiArrive="Valid";
                }
                //Validasi Progress
                if(!empty($_POST['TanggalMulaiProgress'])){
                    if(!empty($_POST['JamMulaiProgress'])){
                        if(!empty($_POST['TanggalSelesaiProgress'])){
                            if(!empty($_POST['JamSelesaiProgress'])){
                                $TanggalMulaiProgress=$_POST['TanggalMulaiProgress'];
                                $JamMulaiProgress=$_POST['JamMulaiProgress'];
                                $TanggalSelesaiProgress=$_POST['TanggalSelesaiProgress'];
                                $JamSelesaiProgress=$_POST['JamSelesaiProgress'];
                                $ValidasiProgress="Valid";
                                $WaktuMulaiProgress="$TanggalMulaiProgress $JamMulaiProgress";
                                $WaktuSelesaiProgress="$TanggalSelesaiProgress $JamSelesaiProgress";
                                $strtotime1=strtotime($WaktuMulaiProgress);
                                $strtotime2=strtotime($WaktuSelesaiProgress);
                                $WaktuMulaiProgress=date('Y-m-d\TH:i:sP',$strtotime1);
                                $WaktuSelesaiProgress=date('Y-m-d\TH:i:sP',$strtotime2);
                                $status_history_progress=Array (
                                    "start" => "$WaktuMulaiProgress",
                                    "end" => "$WaktuSelesaiProgress",
                                );
                                $status_history_progress=Array (
                                    "status" => "in-progress",
                                    "period" => $status_history_progress,
                                );
                            }else{
                                $status_history_progress="";
                                $ValidasiProgress="Jam Selesai Progress Tidak Boleh Kosong!";
                            }
                        }else{
                            $status_history_progress="";
                            $ValidasiProgress="Tanggal Selesai Progress Tidak Boleh Kosong!";
                        }
                    }else{
                        $status_history_progress="";
                        $ValidasiProgress="Jam Mulai Progress Tidak Boleh Kosong!";
                    }
                }else{
                    $status_history_progress="";
                    $ValidasiProgress="Valid";
                }
                //Validasi Finish
                if(!empty($_POST['TanggalMulaiFinish'])){
                    if(!empty($_POST['JamMulaiFinish'])){
                        if(!empty($_POST['TanggalSelesaiFinish'])){
                            if(!empty($_POST['JamSelesaiFinish'])){
                                $TanggalMulaiFinish=$_POST['TanggalMulaiFinish'];
                                $JamMulaiFinish=$_POST['JamMulaiFinish'];
                                $TanggalSelesaiFinish=$_POST['TanggalSelesaiFinish'];
                                $JamSelesaiFinish=$_POST['JamSelesaiFinish'];
                                $ValidasiFinish="Valid";
                                $WaktuMulaiFinish="$TanggalMulaiFinish $JamMulaiFinish";
                                $WaktuSelesaiFinish="$TanggalSelesaiFinish $JamSelesaiFinish";
                                $strtotime1=strtotime($WaktuMulaiFinish);
                                $strtotime2=strtotime($WaktuSelesaiFinish);
                                $WaktuMulaiFinish=date('Y-m-d\TH:i:sP',$strtotime1);
                                $WaktuSelesaiFinish=date('Y-m-d\TH:i:sP',$strtotime2);
                                $status_history_finish=Array (
                                    "start" => "$WaktuMulaiFinish",
                                    "end" => "$WaktuSelesaiFinish",
                                );
                                $status_history_finish=Array (
                                    "status" => "finished",
                                    "period" => $status_history_finish,
                                );
                            }else{
                                $status_history_finish="";
                                $ValidasiFinish="Jam Selesai Progress Tidak Boleh Kosong!";
                            }
                        }else{
                            $status_history_finish="";
                            $ValidasiFinish="Tanggal Selesai Progress Tidak Boleh Kosong!";
                        }
                    }else{
                        $status_history_finish="";
                        $ValidasiFinish="Jam Mulai Progress Tidak Boleh Kosong!";
                    }
                }else{
                    $status_history_finish="";
                    $ValidasiFinish="Valid";
                }
                //Validasi Disposition
                if(!empty($_POST['dischargeDispositionStatus'])){
                    if(!empty($_POST['dischargeDispositionText'])){
                        $dischargeDispositionStatus=$_POST['dischargeDispositionStatus'];
                        $dischargeDispositionText=$_POST['dischargeDispositionText'];
                        $ValidasiDisposition="Valid";
                        $DispositionStatusList = array(
                            'home' => 'Home',
                            'alt-home' => 'Alternative home',
                            'other-hcf' => 'Other healthcare facility',
                            'hosp' => 'Hospice',
                            'long' => 'Long-term care',
                            'aadvice' => 'Left against advice',
                            'exp' => 'Expired',
                            'psy' => 'Psychiatric hospital',
                            'rehab' => 'Rehabilitation',
                            'snf' => 'Skilled nursing facility',
                            'oth' => 'Other'
                        );
                        $dischargeDispositionStatusDisplay=$DispositionStatusList[$dischargeDispositionStatus];
                    }else{
                        $ValidasiDisposition="Keterangan Disposition Tidak Boleh Kosong!";
                    }
                }else{
                    $ValidasiDisposition="Valid";
                }
                if($ValidasiArrive!=="Valid"){
                    echo '<span class="text-danger">'.$ValidasiArrive.'</span>';
                }else{
                    if($ValidasiProgress!=="Valid"){
                        echo '<span class="text-danger">'.$ValidasiProgress.'</span>';
                    }else{
                        if($ValidasiFinish!=="Valid"){
                            echo '<span class="text-danger">'.$ValidasiFinish.'</span>';
                        }else{
                            if($ValidasiDisposition!=="Valid"){
                                echo '<span class="text-danger">'.$ValidasiDisposition.'</span>';
                            }else{
                                if(empty($status_history_arrived)){
                                    echo '<span class="text-danger">History Arrive Tidak Boleh Kosong!</span>';
                                }else{
                                    //Membuka Detai Encounter
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
                                            if(empty($baseurl_satusehat)){
                                                echo '<span class="text-danger">Tidak ada pengaturan base URL satu sehat!</span>';
                                            }else{
                                                //Membuka Data Detail Encounter Lama
                                                $response=EncounterById($baseurl_satusehat,$Token,$id_encounter);
                                                $json_decode =json_decode($response, true);
                                                $identifier=$json_decode['identifier'];
                                                $class=$json_decode['class'];
                                                $subject=$json_decode['subject'];
                                                $participant=$json_decode['participant'];
                                                if(!empty($_POST['TanggalMulaiArrive'])){
                                                    if(!empty($_POST['JamMulaiArrive'])){
                                                        if(!empty($_POST['TanggalSelesaiFinish'])){
                                                            if(!empty($_POST['JamSelesaiFinish'])){
                                                                $period=Array (
                                                                    "start" => "$WaktuMulaiArrive",
                                                                    "end" => "$WaktuSelesaiFinish",
                                                                );
                                                            }else{
                                                                $period=$json_decode['period'];
                                                            }
                                                        }else{
                                                            $period=$json_decode['period'];
                                                        }
                                                    }else{
                                                        $period=$json_decode['period'];
                                                    }
                                                }else{
                                                    $period=$json_decode['period'];
                                                }
                                                $location=$json_decode['location'];
                                                if(!empty($status_history_finish)){
                                                    if(!empty($status_history_progress)){
                                                        $statusHistory=Array (
                                                            "0" => $status_history_arrived,
                                                            "1" => $status_history_progress,
                                                            "2" => $status_history_finish
                                                        );
                                                    }else{
                                                        $statusHistory=Array (
                                                            "0" => $status_history_arrived
                                                        );
                                                    }
                                                }else{
                                                    if(!empty($status_history_progress)){
                                                        $statusHistory=Array (
                                                            "0" => $status_history_arrived,
                                                            "1" => $status_history_progress
                                                        );
                                                    }else{
                                                        $statusHistory=Array (
                                                            "0" => $status_history_arrived
                                                        );
                                                    }
                                                }
                                                $serviceProvider=$json_decode['serviceProvider'];
                                                if(empty($_POST['dischargeDispositionStatus'])){
                                                    $KirimData = array(
                                                        'resourceType' => 'Encounter',
                                                        'id' => "$id_encounter",
                                                        'identifier' => $identifier,
                                                        'status' => $StatusEncounter,
                                                        'class' => $class,
                                                        'subject' => $subject,
                                                        'participant' => $participant,
                                                        'period' => $period,
                                                        'location' => $location,
                                                        'statusHistory' => $statusHistory,
                                                        'serviceProvider' => $serviceProvider
                                                    );
                                                }else{
                                                    $dischargeDispositioncoding=Array (
                                                        "0" => Array (
                                                            "system" => "http://terminology.hl7.org/CodeSystem/discharge-disposition",
                                                            "code" => "$dischargeDispositionStatus",
                                                            "display" => "$dischargeDispositionStatusDisplay"
                                                        )
                                                    );
                                                    $dischargeDisposition=Array (
                                                        "coding" => $dischargeDispositioncoding,
                                                        "text" => "$dischargeDispositionText",
                                                    );
                                                    $hospitalization=Array (
                                                        "dischargeDisposition" => $dischargeDisposition
                                                    );
                                                    $KirimData = array(
                                                        'resourceType' => 'Encounter',
                                                        'id' => "$id_encounter",
                                                        'identifier' => $identifier,
                                                        'status' => $StatusEncounter,
                                                        'class' => $class,
                                                        'subject' => $subject,
                                                        'participant' => $participant,
                                                        'period' => $period,
                                                        'location' => $location,
                                                        'statusHistory' => $statusHistory,
                                                        'hospitalization' => $hospitalization,
                                                        'serviceProvider' => $serviceProvider
                                                    );
                                                }
                                                $JsonEncode = json_encode($KirimData);
                                                $response=UpdateEncounter($baseurl_satusehat,$JsonEncode,$Token,$id_encounter);
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
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Encounter ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            $_SESSION['NotifikasiSwal']="Update Encounter Berhasil";
                                                            echo '<span class="text-success" id="NotifikasiUpdateEncounterBerhasil">Success</span>';
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
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