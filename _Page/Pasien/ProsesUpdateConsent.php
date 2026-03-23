<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['patient_id'])){
        echo '<span class="text-danger">ID IHS Pasien Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['agent'])){
            echo '<span class="text-danger">Nama Petugas Entry Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['action'])){
                echo '<span class="text-danger">Pilihan Action Tidak Boleh Kosong!</span>';
            }else{
                $patient_id=$_POST['patient_id'];
                $agent=$_POST['agent'];
                $action=$_POST['action'];
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
                        $baseurl_consent_satusehat=getDataDetail($Conn,' setting_satusehat','status','Active','consent_url');
                        $KirimData = array(
                            'patient_id' => $patient_id,
                            'agent' => $agent,
                            'action' => $action
                        );
                        $JsonEncode = json_encode($KirimData);
                        $response=UpdateConsent($baseurl_consent_satusehat,$JsonEncode,$Token);
                        //Apabila Berhasil Tangkap ID nya
                        if(empty($response)){
                            echo '<span class="text-danger">Tidak ada response dari satu sehat</span>';
                        }else{
                            $JsonData =json_decode($response, true);
                            if(empty($JsonData['id'])){
                                echo '<span class="text-danger">Terjadi kesalahan saat mengirim data ke satu sehat</span>';
                                echo '<textarea class="form-control">'.$response.'</textarea>';
                            }else{
                                $id=$JsonData['id'];
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Consent","Pasien",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    echo '<span class="text-success" id="NotifikasiUpdateConsentBerhasil">Success</span>';
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
?>