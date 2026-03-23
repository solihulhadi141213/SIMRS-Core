<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_referensi_organisasi'])){
        echo '<span class="text-danger">ID Organisasi Tidak Boleh Kosong</span>';
    }else{
        $id_referensi_organisasi=$_POST['id_referensi_organisasi'];
        //Buka Data Organisasi
        //Buka Detail Data
        $nama=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'nama');
        $identifier=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'identifier');
        $tipe=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'tipe');
        $email=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'email');
        $kontak=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'kontak');
        $part_of_ID=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'part_of_ID');
        $ID_Org=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'ID_Org');
        //Cek apakah memiliki anak
        if(empty($ID_Org)){
            $JumlahOrganisasiAnak=0;
        }else{
            $JumlahOrganisasiAnak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE part_of_ID='$ID_Org'"));
        }
        if(!empty($JumlahOrganisasiAnak)){
            echo '<span class="text-danger">Organisasi Tidak Bisa Dihapus Karena Memiliki Sub Organisasi, Silahkan Hapus Sub Organisasi Tersebut</span>';
        }else{
            //Apabila Memiliki ID_org maka lakukan update ke satu sehat
            if(!empty($ID_Org)){
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
                        //Insert Organization Ke Satu Sehat
                        $baseurl_satusehat=getDataDetail($Conn,' setting_satusehat','status','Active','baseurl');
                        $KirimData=Array (
                            "0" => Array (
                                "op" => "replace",
                                "path" => "/active",
                                "value" => false
                            )
                        );
                        $JsonEncode = json_encode($KirimData);
                        $response=PatchOrganization($baseurl_satusehat,$ID_Org,$JsonEncode,$Token);
                        if(empty($response)){
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                        }else{
                            $JsonData =json_decode($response, true);
                            if(empty($JsonData['id'])){
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                echo '<span class="text-info">'.$response.'</span><br>';
                                echo '<textarea class="form-control">'.$JsonEncode.'</textarea>';
                            }else{
                                $IdOrganization=$JsonData['id'];
                                $HapusOrganisasi = mysqli_query($Conn, "DELETE FROM referensi_organisasi WHERE id_referensi_organisasi='$id_referensi_organisasi'") or die(mysqli_error($Conn));
                                if($HapusOrganisasi) {
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Organisasi","Referensi",$SessionIdAkses,$LogJsonFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        $_SESSION['NotifikasiSwal']="Hapus Organisasi Berhasil";
                                        echo '<span class="text-success" id="NotifikasiHapusOrganisasiBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Hapus Organisasi Gagal!</span>';
                                }
                            }
                        }
                    }
                }
            }else{
                $HapusOrganisasi = mysqli_query($Conn, "DELETE FROM referensi_organisasi WHERE id_referensi_organisasi='$id_referensi_organisasi'") or die(mysqli_error($Conn));
                if($HapusOrganisasi) {
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Organisasi","Referensi",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        $_SESSION['NotifikasiSwal']="Hapus Organisasi Berhasil";
                        echo '<span class="text-success" id="NotifikasiHapusOrganisasiBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Hapus Organisasi Gagal!</span>';
                }
            }
        }
    }
?>