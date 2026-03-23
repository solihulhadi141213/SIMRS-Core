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
        if(empty($_POST['kode'])){
            echo '<span class="text-danger">Kode Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['deskripsi'])){
                echo '<span class="text-danger">Deskripsi Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['status'])){
                    echo '<span class="text-danger">Status Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['mode'])){
                        echo '<span class="text-danger">Mode Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['address_use'])){
                            echo '<span class="text-danger">Address Use Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['physicalType_code'])){
                                echo '<span class="text-danger">Physical Type Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['managingOrganization'])){
                                    echo '<span class="text-danger">Organization Tidak Boleh Kosong!</span>';
                                }else{
                                    $nama=$_POST['nama'];
                                    $kode=$_POST['kode'];
                                    $deskripsi=$_POST['deskripsi'];
                                    $status=$_POST['status'];
                                    $mode=$_POST['mode'];
                                    $address_use=$_POST['address_use'];
                                    $physicalType_code=$_POST['physicalType_code'];
                                    $managingOrganization=$_POST['managingOrganization'];
                                    if(empty($_POST['email'])){
                                        $email="";
                                    }else{
                                        $email=$_POST['email'];
                                    }
                                    if(empty($_POST['kontak'])){
                                        $kontak="";
                                    }else{
                                        $kontak=$_POST['kontak'];
                                    }
                                    if(empty($_POST['fax'])){
                                        $fax="";
                                    }else{
                                        $fax=$_POST['fax'];
                                    }
                                    if(empty($_POST['url'])){
                                        $url="";
                                    }else{
                                        $url=$_POST['url'];
                                    }
                                    if(empty($_POST['address_line'])){
                                        $address_line="";
                                    }else{
                                        $address_line=$_POST['address_line'];
                                    }
                                    if(empty($_POST['address_city'])){
                                        $address_city="";
                                    }else{
                                        $address_city=$_POST['address_city'];
                                    }
                                    if(empty($_POST['address_postalCode'])){
                                        $address_postalCode="";
                                    }else{
                                        $address_postalCode=$_POST['address_postalCode'];
                                    }
                                    $PisikalName = array(
                                        'si' => 'Site',
                                        'bu' => 'Building',
                                        'wi' => 'Wing',
                                        'wa' => 'Ward',
                                        'lvl' => 'Level',
                                        'co' => 'Corridor',
                                        'ro' => 'Room',
                                        'bd' => 'Bed',
                                        've' => 'Vehicle',
                                        'ho' => 'House',
                                        'ca' => 'Cabinet',
                                        'rd' => 'Road',
                                        'area' => 'Area',
                                        'jdn' => 'Jurisdiction',
                                        'vi' => 'Virtual',
                                    );
                                    $physicalType_display=$PisikalName[$physicalType_code];
                                    if(empty($_POST['longitude'])){
                                        $longitude="0";
                                    }else{
                                        $longitude=$_POST['longitude'];
                                    }
                                    if(empty($_POST['latitude'])){
                                        $latitude="0";
                                    }else{
                                        $latitude=$_POST['latitude'];
                                    }
                                    if(empty($_POST['altitude'])){
                                        $altitude="0";
                                    }else{
                                        $altitude=$_POST['altitude'];
                                    }
                                    if(empty($_POST['ID_Org'])){
                                        $ID_Org="";
                                    }else{
                                        $ID_Org=$_POST['ID_Org'];
                                    }
                                    if($ID_Org=="Ya"){
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
                                                $id_org_utama=getDataDetail($Conn,' setting_satusehat','status','Active','organization_id');
                                                $identifierList=Array (
                                                    "0" => Array (
                                                        "system" => "http://sys-ids.kemkes.go.id/location/$id_org_utama",
                                                        "value" => "$kode"
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
                                                    ),
                                                    "2" => Array (
                                                        "system" => "fax",
                                                        "value" => "$fax",
                                                        "use" => "work"
                                                    ),
                                                    "3" => Array (
                                                        "system" => "url",
                                                        "value" => "$url",
                                                        "use" => "work"
                                                    )
                                                );
                                                $address_line_list=Array (
                                                    $address_line
                                                );
                                                $address=Array (
                                                    "use" => $address_use,
                                                    "line" => $address_line_list,
                                                    "city" => $address_city,
                                                    "postalCode" => $address_postalCode,
                                                    "country" => "ID"
                                                );
                                                $codingphysicalType=Array (
                                                    "0" => Array (
                                                        "system" => "http://terminology.hl7.org/CodeSystem/location-physical-type",
                                                        "code" => $physicalType_code,
                                                        "display" => $physicalType_display
                                                    )
                                                );
                                                $physicalType=Array (
                                                    "coding" => $codingphysicalType
                                                );
                                                $managingOrganization2=Array (
                                                    "reference" => "Organization/$managingOrganization",
                                                );
                                                $KirimData = array(
                                                    'resourceType' => 'Location',
                                                    'identifier' => $identifierList,
                                                    'status' => $status,
                                                    'name' => $nama,
                                                    'description' => $deskripsi,
                                                    'mode' => $mode,
                                                    'telecom' => $telecom,
                                                    'address' => $address,
                                                    'physicalType' => $physicalType,
                                                    'managingOrganization' => $managingOrganization2
                                                );
                                                $JsonEncode = json_encode($KirimData);
                                                $response=CreatLocation($baseurl_satusehat,$JsonEncode,$Token);
                                                //Apabila Berhasil Tangkap ID nya
                                                if(!empty($response)){
                                                    $JsonData =json_decode($response, true);
                                                    if(!empty($JsonData['id'])){
                                                        $IdLocation=$JsonData['id'];
                                                        //Simpan Data Ke Database
                                                        $entry="INSERT INTO referensi_location (
                                                            id_location,
                                                            nama,
                                                            kode,
                                                            deskripsi,
                                                            status,
                                                            mode,
                                                            kontak,
                                                            fax,
                                                            email,
                                                            url,
                                                            address_use,
                                                            address_line,
                                                            address_city,
                                                            address_postalCode,
                                                            physicalType_code,
                                                            physicalType_display,
                                                            longitude,
                                                            latitude,
                                                            altitude,
                                                            managingOrganization
                                                        ) VALUES (
                                                            '$IdLocation',
                                                            '$nama',
                                                            '$kode',
                                                            '$deskripsi',
                                                            '$status',
                                                            '$mode',
                                                            '$kontak',
                                                            '$fax',
                                                            '$email',
                                                            '$url',
                                                            '$address_use',
                                                            '$address_line',
                                                            '$address_city',
                                                            '$address_postalCode',
                                                            '$physicalType_code',
                                                            '$physicalType_display',
                                                            '$longitude',
                                                            '$latitude',
                                                            '$altitude',
                                                            '$managingOrganization'
                                                        )";
                                                        $Input=mysqli_query($Conn, $entry);
                                                        if($Input){
                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tabah Location Baru","Referensi",$SessionIdAkses,$LogJsonFile);
                                                            if($MenyimpanLog=="Berhasil"){
                                                                $_SESSION['NotifikasiSwal']="Tabah Location Berhasil";
                                                                echo '<span class="text-success" id="NotifikasiTambahLocationBerhasil">Success</span>';
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                            }
                                                        }else{
                                                            echo '<span class="text-danger">Tabah Location Baru Gagal!</span>';
                                                        }
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                        echo '<span class="text-info">'.$response.'</span><br>';
                                                        echo '<dt class="text-info">'.$JsonEncode.'</dt>';
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                }
                                            }
                                        }
                                    }else{
                                        //Simpan Data Ke Database
                                        $entry="INSERT INTO referensi_location (
                                            id_location,
                                            nama,
                                            kode,
                                            deskripsi,
                                            status,
                                            mode,
                                            kontak,
                                            fax,
                                            email,
                                            url,
                                            address_use,
                                            address_line,
                                            address_city,
                                            address_postalCode,
                                            physicalType_code,
                                            physicalType_display,
                                            longitude,
                                            latitude,
                                            altitude,
                                            managingOrganization
                                        ) VALUES (
                                            '',
                                            '$nama',
                                            '$kode',
                                            '$deskripsi',
                                            '$status',
                                            '$mode',
                                            '$kontak',
                                            '$fax',
                                            '$email',
                                            '$url',
                                            '$address_use',
                                            '$address_line',
                                            '$address_city',
                                            '$address_postalCode',
                                            '$physicalType_code',
                                            '$physicalType_display',
                                            '$longitude',
                                            '$latitude',
                                            '$altitude',
                                            '$managingOrganization'
                                        )";
                                        $Input=mysqli_query($Conn, $entry);
                                        if($Input){
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tabah Location Baru","Referensi",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                $_SESSION['NotifikasiSwal']="Tabah Location Berhasil";
                                                echo '<span class="text-success" id="NotifikasiTambahLocationBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Tabah Location Baru Gagal!</span>';
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