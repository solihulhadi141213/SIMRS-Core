<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['id_referensi_organisasi'])){
        echo '<span class="text-danger">ID Referensi Organisasi Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama Organisasi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['identifier'])){
                echo '<span class="text-danger">Identifier Organisasi Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tipe'])){
                    echo '<span class="text-danger">Tipe Organmisasi Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['email'])){
                        echo '<span class="text-danger">Email Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['kontak'])){
                            echo '<span class="text-danger">Kontak Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['part_of_ID'])){
                                $part_of_ID="";
                            }else{
                                $part_of_ID=$_POST['part_of_ID'];
                            }
                            if(empty($_POST['ID_Org2'])){
                                $ID_Org2="";
                            }else{
                                $ID_Org2=$_POST['ID_Org2'];
                            }
                            $id_referensi_organisasi=$_POST['id_referensi_organisasi'];
                            $nama=$_POST['nama'];
                            $identifier=$_POST['identifier'];
                            $tipe=$_POST['tipe'];
                            $email=$_POST['email'];
                            $kontak=$_POST['kontak'];
                            //Membuka ID ORG Sebelumnya
                            $ID_Org=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'ID_Org');
                            if($ID_Org2=="Ya"){
                                //Proses Untuk Mendapatkan ID_Org Dari Satu Sehat
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
                                        $display=tipeDisplay($tipe);
                                        $identifierList=Array (
                                            "0" => Array (
                                                "use" => "$identifier",
                                                "value" => "$nama"
                                            )
                                        );
                                        $coding_list=Array (
                                            "0" => Array (
                                                "system" => "http://terminology.hl7.org/CodeSystem/organization-type",
                                                "code" => "$tipe",
                                                "display" => "$display"
                                            )
                                        );
                                        $type_identifier=Array (
                                            "0" => Array (
                                                "coding" => $coding_list
                                            )
                                        );
                                        $telecom=Array (
                                            "0" => Array (
                                                "system" => "phone",
                                                "value" => "$kontak",
                                                "use" => "work"
                                            ),
                                            "1" => Array (
                                                "system" => "email",
                                                "value" => "$email",
                                                "use" => "work"
                                            )
                                        );
                                        
                                        $partOf=Array (
                                            "reference" => "Organization/$part_of_ID"
                                        );
                                        
                                        
                                        if(empty($ID_Org)){
                                            if(!empty($part_of_ID)){
                                                $KirimData = array(
                                                    'resourceType' => 'Organization',
                                                    'active' => true,
                                                    'identifier' => $identifierList,
                                                    'type' => $type_identifier,
                                                    'name' => $nama,
                                                    'telecom' => $telecom,
                                                    'partOf' => $partOf
                                                );
                                            }else{
                                                $KirimData = array(
                                                    'resourceType' => 'Organization',
                                                    'active' => true,
                                                    'identifier' => $identifierList,
                                                    'type' => $type_identifier,
                                                    'name' => $nama,
                                                    'telecom' => $telecom
                                                );
                                            }
                                        }else{
                                            if(!empty($part_of_ID)){
                                                $KirimData = array(
                                                    'resourceType' => 'Organization',
                                                    'id' => "$ID_Org",
                                                    'active' => true,
                                                    'identifier' => $identifierList,
                                                    'type' => $type_identifier,
                                                    'name' => $nama,
                                                    'telecom' => $telecom,
                                                    'partOf' => $partOf
                                                );
                                            }else{
                                                $KirimData = array(
                                                    'resourceType' => 'Organization',
                                                    'id' => "$ID_Org",
                                                    'active' => true,
                                                    'identifier' => $identifierList,
                                                    'type' => $type_identifier,
                                                    'name' => $nama,
                                                    'telecom' => $telecom
                                                );
                                            }
                                        }
                                        $JsonEncode = json_encode($KirimData);
                                        //Tentukan Update Atau Creat
                                        if(empty($ID_Org)){
                                            $response=CreatOrganization($baseurl_satusehat,$JsonEncode,$Token);
                                        }else{
                                            $response=UpdateOrganization($baseurl_satusehat,$ID_Org,$JsonEncode,$Token);
                                        }
                                        //Apabila Berhasil Tangkap ID nya
                                        if(!empty($response)){
                                            $JsonData =json_decode($response, true);
                                            if(!empty($JsonData['id'])){
                                                $IdOrganization=$JsonData['id'];
                                                //Simpan Data Ke Database
                                                $UpdateOrganisasi = mysqli_query($Conn,"UPDATE referensi_organisasi SET 
                                                    nama='$nama',
                                                    identifier='$identifier',
                                                    tipe='$tipe',
                                                    email='$email',
                                                    kontak='$kontak',
                                                    part_of_ID='$part_of_ID',
                                                    ID_Org='$IdOrganization'
                                                WHERE id_referensi_organisasi='$id_referensi_organisasi'") or die(mysqli_error($Conn)); 
                                                if($UpdateOrganisasi){
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Data Organization","Referensi",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        $_SESSION['NotifikasiSwal']="Update Organization Berhasil";
                                                        echo '<span class="text-success" id="NotifikasiEditOrganisasiBerhasil">Success</span>';
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Update Organization Baru Gagal!</span>';
                                                }
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                echo '<span class="text-info">'.$response.'</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                        }
                                    }
                                }
                            }else{
                                if(empty($_POST['id_organization'])){
                                    $id_organization="";
                                }else{
                                    $id_organization=$_POST['id_organization'];
                                }
                                //Update Data Organisai
                                $UpdateOrganisasi = mysqli_query($Conn,"UPDATE referensi_organisasi SET 
                                    nama='$nama',
                                    identifier='$identifier',
                                    tipe='$tipe',
                                    email='$email',
                                    kontak='$kontak',
                                    part_of_ID='$part_of_ID',
                                    ID_Org='$id_organization'
                                WHERE id_referensi_organisasi='$id_referensi_organisasi'") or die(mysqli_error($Conn)); 
                                if($UpdateOrganisasi){
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Data Organization","Referensi",$SessionIdAkses,$LogJsonFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        $_SESSION['NotifikasiSwal']="Update Organization Berhasil";
                                        echo '<span class="text-success" id="NotifikasiEditOrganisasiBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Update Organization Baru Gagal!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>