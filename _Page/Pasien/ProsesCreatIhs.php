<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nik'])){
            echo '<span class="text-danger">NIK Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['gender'])){
                echo '<span class="text-danger">Gender Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_lahir'])){
                    echo '<span class="text-danger">Tanggal Lahir Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['kontak'])){
                        echo '<span class="text-danger">Kontak Pasien Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['kontak_darurat'])){
                            echo '<span class="text-danger">Kontak Darurat Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['nama_kerabat'])){
                                echo '<span class="text-danger">Nama Kerabat Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['propinsi_ihs'])){
                                    echo '<span class="text-danger">Propinsi Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['kabupaten_ihs'])){
                                        echo '<span class="text-danger">Kabupaten Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['kecamatan_ihs'])){
                                            echo '<span class="text-danger">Kecamatan Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['desa_ihs'])){
                                                echo '<span class="text-danger">Desa Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['alamat'])){
                                                    echo '<span class="text-danger">Alamat Jalan Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['kode_pos'])){
                                                        echo '<span class="text-danger">Kode POS Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['perkawinan'])){
                                                            echo '<span class="text-danger">Status Pernikahan Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['id_pasien'])){
                                                                echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                $nama=$_POST['nama'];
                                                                $nik=$_POST['nik'];
                                                                $gender=$_POST['gender'];
                                                                $tanggal_lahir=$_POST['tanggal_lahir'];
                                                                $kontak=$_POST['kontak'];
                                                                $kontak_darurat=$_POST['kontak_darurat'];
                                                                $nama_kerabat=$_POST['nama_kerabat'];
                                                                $propinsi_ihs=$_POST['propinsi_ihs'];
                                                                $kabupaten_ihs=$_POST['kabupaten_ihs'];
                                                                $kecamatan_ihs=$_POST['kecamatan_ihs'];
                                                                $desa_ihs=$_POST['desa_ihs'];
                                                                $alamat=$_POST['alamat'];
                                                                $kode_pos=$_POST['kode_pos'];
                                                                $perkawinan=$_POST['perkawinan'];
                                                                $StatusPernikahanList = array(
                                                                    'A' => 'Site',
                                                                    'D' => 'Building',
                                                                    'I' => 'Wing',
                                                                    'L' => 'Ward',
                                                                    'M' => 'Level',
                                                                    'C' => 'Corridor',
                                                                    'P' => 'Room',
                                                                    'T' => 'Bed',
                                                                    'U' => 'Vehicle',
                                                                    'S' => 'House',
                                                                    'W' => 'Cabinet',
                                                                );
                                                                $maritalStatus_display=$StatusPernikahanList[$perkawinan];
                                                                //Nama City
                                                                $City=getDataDetail($Conn,'wilayah_mendagri','kode','$kabupaten_ihs','nama');
                                                                if(empty($_POST['email'])){
                                                                    $email="";
                                                                }else{
                                                                    $email=$_POST['email'];
                                                                }
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
                                                                        $meta=Array (
                                                                            "profile" => Array (
                                                                                "https://fhir.kemkes.go.id/r4/StructureDefinition/Patient"
                                                                            )
                                                                        );
                                                                        $identifier=Array (
                                                                            "0" => Array (
                                                                                "use" => "official",
                                                                                "system" => "https://fhir.kemkes.go.id/id/nik",
                                                                                "value" => "$nik"
                                                                            )
                                                                        );
                                                                        $active=true;
                                                                        $name=Array (
                                                                            "0" => Array (
                                                                                "use" => "official",
                                                                                "text" => "$nama"
                                                                            )
                                                                        );
                                                                        if(empty($_POST['email'])){
                                                                            $telecom=Array (
                                                                                "0" => Array (
                                                                                    "system" => "phone",
                                                                                    "value" => "$kontak",
                                                                                    "use" => "mobile"
                                                                                )
                                                                            );
                                                                        }else{
                                                                            $telecom=Array (
                                                                                "0" => Array (
                                                                                    "system" => "phone",
                                                                                    "value" => "$kontak",
                                                                                    "use" => "mobile"
                                                                                ),
                                                                                "1" => Array (
                                                                                    "system" => "email",
                                                                                    "value" => "$email",
                                                                                    "use" => "home"
                                                                                )
                                                                            );
                                                                        }
                                                                        $deceasedBoolean=false;
                                                                        $line=Array (
                                                                            "0" => Array (
                                                                                "$alamat"
                                                                            )
                                                                        );
                                                                        $extension=Array (
                                                                            "0" => Array (
                                                                                "url" => "province",
                                                                                "valueCode" => "$propinsi_ihs"
                                                                            ),
                                                                            "1" => Array (
                                                                                "url" => "city",
                                                                                "valueCode" => "$kabupaten_ihs"
                                                                            ),
                                                                            "2" => Array (
                                                                                "url" => "district",
                                                                                "valueCode" => "$kecamatan_ihs"
                                                                            ),
                                                                            "3" => Array (
                                                                                "url" => "village",
                                                                                "valueCode" => "$desa_ihs"
                                                                            )
                                                                        );
                                                                        $extension=Array (
                                                                            "0" => Array (
                                                                                "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                                                                                "extension" => $extension
                                                                            )
                                                                        );
                                                                        $address=Array (
                                                                            "0" => Array (
                                                                                "use" => "home",
                                                                                "line" => $line,
                                                                                "city" => "$City",
                                                                                "postalCode" => "$kode_pos",
                                                                                "country" => "ID",
                                                                                "extension" => $extension
                                                                            )
                                                                        );
                                                                        $maritalStatus=Array (
                                                                            "0" => Array (
                                                                                "system" => "http://terminology.hl7.org/CodeSystem/v3-MaritalStatus",
                                                                                "code" => "$perkawinan",
                                                                                "display" => "$maritalStatus_display",
                                                                            )
                                                                        );
                                                                        $maritalStatus=Array (
                                                                            "0" => Array (
                                                                                "coding" => $maritalStatus,
                                                                                "text" => "$maritalStatus_display",
                                                                            )
                                                                        );
                                                                        $relationship_coding=Array (
                                                                            "0" => Array (
                                                                                "system" => "http://terminology.hl7.org/CodeSystem/v2-0131",
                                                                                "code" => "C"
                                                                            )
                                                                        );
                                                                        $contact_relationship=Array (
                                                                            "0" => Array (
                                                                                "coding" => $relationship_coding
                                                                            )
                                                                        );
                                                                        $contact_name=Array (
                                                                            "use" => "official",
                                                                            "text" => "$nama_kerabat"
                                                                        );
                                                                        $contact_telcom=Array (
                                                                            "0" => Array (
                                                                                "system" => "phone",
                                                                                "value" => "$kontak_darurat",
                                                                                "use" => "mobile",
                                                                            )
                                                                        );
                                                                        $contact=Array (
                                                                            "0" => Array (
                                                                                "relationship" => $contact_relationship,
                                                                                "name" => $contact_name,
                                                                                "telecom" => $contact_telcom
                                                                            )
                                                                        );
                                                                        $language_coding=Array (
                                                                            "0" => Array (
                                                                                "system" => "urn:ietf:bcp:47",
                                                                                "code" => "id-ID",
                                                                                "display" => "Indonesian"
                                                                            )
                                                                        );
                                                                        $language=Array (
                                                                            "coding" => $language_coding,
                                                                            "text" => "Indonesia",
                                                                        );
                                                                        $communication=Array (
                                                                            "0" => Array (
                                                                                "language" => $language,
                                                                                "preferred" => true
                                                                            )
                                                                        );
                                                                        $valueAddress=Array (
                                                                            "city" => "$City",
                                                                            "country" => "Indonesia",
                                                                        );
                                                                        $extension2=Array (
                                                                            "0" => Array (
                                                                                "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/birthPlace",
                                                                                "valueAddress" => $valueAddress
                                                                            ),
                                                                            "1" => Array (
                                                                                "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/citizenshipStatus",
                                                                                "valueCode" => "WNI"
                                                                            )
                                                                        );
                                                                        $KirimData = array(
                                                                            'resourceType' => 'Patient',
                                                                            'meta' => $meta,
                                                                            'identifier' => $identifier,
                                                                            'active' => true,
                                                                            'name' => $name,
                                                                            'telecom' => $telecom,
                                                                            'gender' => "$gender",
                                                                            'birthDate' => "$tanggal_lahir",
                                                                            'deceasedBoolean' => false,
                                                                            'deceasedaddressBoolean' => $address,
                                                                            'maritalStatus' => $maritalStatus,
                                                                            'multipleBirthInteger' => 0,
                                                                            'contact' => $contact,
                                                                            'communication' => $communication,
                                                                            'extension' => $extension2
                                                                        );
                                                                        $JsonEncode = json_encode($KirimData);
                                                                        $response=CreatPatient($baseurl_satusehat,$JsonEncode,$Token);
                                                                        //Apabila Berhasil Tangkap ID nya
                                                                        if(!empty($response)){
                                                                            $JsonData =json_decode($response, true);
                                                                            if(!empty($JsonData['data']['Patient ID'])){
                                                                                $IdPatient=$JsonData['data']['Patient ID'];
                                                                                //Simpan Data Ke Database
                                                                                $UpdatePasien= mysqli_query($Conn,"UPDATE pasien SET 
                                                                                    id_ihs='$IdPatient',
                                                                                    updatetime='$updatetime'
                                                                                WHERE id_pasien='$id_pasien'") or die(mysqli_error($Conn)); 
                                                                                if($UpdatePasien){
                                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update ID Pasien","Pasien",$SessionIdAkses,$LogJsonFile);
                                                                                    if($MenyimpanLog=="Berhasil"){
                                                                                        $_SESSION['NotifikasiSwal']="Update ID Pasien Berhasil";
                                                                                        echo '<span class="text-success" id="NotifikasiCreatIhsPasienBerhasil">Success</span>';
                                                                                    }else{
                                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                    }
                                                                                }else{
                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Data pasien</span>';
                                                                                }
                                                                            }else{
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                                echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                                echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                            }
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
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