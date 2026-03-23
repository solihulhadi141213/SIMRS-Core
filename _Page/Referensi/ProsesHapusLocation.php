<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_referensi_location'])){
        echo '<span class="text-danger">ID Location Tidak Boleh Kosong</span>';
    }else{
        $id_referensi_location=$_POST['id_referensi_location'];
        //Buka Detail Data
        $id_location=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'id_location');
        //Apabila Memiliki ID_org maka lakukan update ke satu sehat
        if(!empty($id_location)){
            //Update Data dari Satu sehat
            $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
            if(empty($SettingSatuSehat)){
                echo '<span class="text-danger">Tidak Ada Pengaturan Satu Sehat Yang Aktiv!</span>';
            }else{
                //1. Generate Token
                $Token=GenerateTokenSatuSehat($Conn);
                if(empty($Token)){
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Generate Token</span>';
                }else{
                    //Insert Location Ke Satu Sehat
                    $baseurl_satusehat=getDataDetail($Conn,' setting_satusehat','status','Active','baseurl');
                    $KirimData=Array (
                        "0" => Array (
                            "op" => "replace",
                            "path" => "/status",
                            "value" => "inactive"
                        )
                    );
                    $JsonEncode = json_encode($KirimData);
                    $response=PatchLocation($baseurl_satusehat,$id_location,$JsonEncode,$Token);
                    if(empty($response)){
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                    }else{
                        $JsonData =json_decode($response, true);
                        if(empty($JsonData['id'])){
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                            echo '<span class="text-info">'.$response.'</span><br>';
                            echo '<textarea class="form-control">'.$JsonEncode.'</textarea>';
                        }else{
                            $HapusLocation = mysqli_query($Conn, "DELETE FROM referensi_location WHERE id_referensi_location='$id_referensi_location'") or die(mysqli_error($Conn));
                            if($HapusLocation) {
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Location","Referensi",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Hapus Location Berhasil";
                                    echo '<span class="text-success" id="NotifikasiHapusLocationBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Hapus Location Gagal!</span>';
                            }
                        }
                    }
                }
            }
        }else{
            $HapusLocation = mysqli_query($Conn, "DELETE FROM referensi_location WHERE id_referensi_location='$id_referensi_location'") or die(mysqli_error($Conn));
            if($HapusLocation) {
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Location","Referensi",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    $_SESSION['NotifikasiSwal']="Hapus Location Berhasil";
                    echo '<span class="text-success" id="NotifikasiHapusLocationBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Hapus Location Gagal!</span>';
            }
        }
    }
?>