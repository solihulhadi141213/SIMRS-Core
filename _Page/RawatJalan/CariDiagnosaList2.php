<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //keyword
    if(!empty($_POST['reasonCode'])){
        $keyword=$_POST['reasonCode'];
        if(!empty($_POST['ReferensiDiagnostic'])){
            $ReferensiDiagnostic=$_POST['ReferensiDiagnostic'];
            if($ReferensiDiagnostic=="BPJS"){
                $IdSettingBridging=getDataDetail($Conn,'bridging','status','Aktiv','id_bridging');
                $consid=getDataDetail($Conn,'bridging','status','Aktiv','consid');
                $user_key=getDataDetail($Conn,'bridging','status','Aktiv','user_key');
                $secret_key=getDataDetail($Conn,'bridging','status','Aktiv','secret_key');
                $kode_ppk=getDataDetail($Conn,'bridging','status','Aktiv','kode_ppk');
                $url_vclaim=getDataDetail($Conn,'bridging','status','Aktiv','url_vclaim');
                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                $key="$consid$secret_key$timestamp";
                $ResponseData=referensiDiagnosaVclaim($url_vclaim,$consid,$secret_key,$user_key,$keyword);
                if(!empty($ResponseData)){
                    $ambil_json =json_decode($ResponseData, true);
                    if(!empty($ambil_json["metaData"]["code"])){
                        if($ambil_json["metaData"]["code"]=="200"){
                            if(!empty($ambil_json["response"])){
                                $string=$ambil_json["response"];
                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                $key="$consid$secret_key$timestamp";
                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                $FileDekompresi=decompress("$FileDeskripsi");
                                $FileDekompresiJson =json_decode($FileDekompresi, true);
                                if(empty($FileDekompresiJson['diagnosa'])){
                                    $diagnosa="";
                                }else{
                                    $diagnosa=$FileDekompresiJson['diagnosa'];
                                }
                                if(!empty($diagnosa)){
                                    $JumlahDiagnosa=count($diagnosa);
                                    if(!empty($JumlahDiagnosa)){
                                        foreach($diagnosa as $data_list){
                                            $kode= $data_list['kode'];
                                            $nama= $data_list['nama'];
                                            $Explode = explode("-" , $nama);
                                            $DiagnosaNama=$Explode[1];
                                            $Explode2 = explode(" " , $DiagnosaNama);
                                            $DiagnosaNama=$Explode2[1];
                                            echo '<option value="'.$kode.'|'.$DiagnosaNama.'">';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM diagnosa WHERE (versi='ICD10') AND (kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%')");
                while ($data = mysqli_fetch_array($query)) {
                    $id_diagnosa= $data['id_diagnosa'];
                    $kode= $data['kode'];
                    $long_des= $data['long_des'];
                    $short_des= $data['short_des'];
                    $versi= $data['versi'];
                    echo '<option value="'.$kode.'|'.$short_des.'">';
                }
            }
        }
    }
?>