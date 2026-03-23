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
                    if(empty($_POST['typeConposition'])){
                        echo '<span class="text-danger">Type Composition Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['categoryConposition'])){
                            echo '<span class="text-danger">Kategori Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['IdIhsPractitioner'])){
                                echo '<span class="text-danger">Id Ihs Practitioner Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['id_pasien'])){
                                    echo '<span class="text-danger">ID pasien Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['GetIdKunjungan'])){
                                        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['IdOrg'])){
                                            echo '<span class="text-danger">ID Organization Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['sectionConposition'])){
                                                echo '<span class="text-danger">Section Conposition Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['sectionTextConposition'])){
                                                    echo '<span class="text-danger">Section Text Conposition Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['titleComposition'])){
                                                        echo '<span class="text-danger">Title Conposition Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['GenerateIdComposition'])){
                                                            $GenerateIdComposition="";
                                                        }else{
                                                            $GenerateIdComposition=$_POST['GenerateIdComposition'];
                                                        }
                                                        //Membuat Variabel
                                                        $id_kunjungan=$_POST['GetIdKunjungan'];
                                                        $id_pasien=$_POST['id_pasien'];
                                                        $id_ihs=$_POST['id_ihs'];
                                                        $nama=$_POST['nama'];
                                                        $id_encounter=$_POST['id_encounter'];
                                                        $tanggal_kunjungan=$_POST['tanggal_kunjungan'];
                                                        $typeConposition=$_POST['typeConposition'];
                                                        $categoryConposition=$_POST['categoryConposition'];
                                                        $IdOrg=$_POST['IdOrg'];
                                                        $sectionConposition=$_POST['sectionConposition'];
                                                        $sectionTextConposition=$_POST['sectionTextConposition'];
                                                        $IdIhsPractitioner=$_POST['IdIhsPractitioner'];
                                                        $titleComposition=$_POST['titleComposition'];
                                                        //Pecah Karakter typeConposition
                                                        $Explode = explode("|" , $typeConposition);
                                                        $typeConpositionCode=$Explode[0];
                                                        $typeConpositionDisplay=$Explode[1];
                                                        //Pecah Karakter categoryConposition
                                                        $Explode2 = explode("|" , $categoryConposition);
                                                        $categoryConpositionCode=$Explode2[0];
                                                        $categoryConpositionDisplay=$Explode2[1];
                                                        //Pecah Karakter sectionConposition
                                                        $Explode3 = explode("|" , $sectionConposition);
                                                        $sectionConpositionCode=$Explode3[0];
                                                        $sectionConpositionDisplay=$Explode3[1];
                                                        //Membuat Uniq ID
                                                        $uniqIdComposition=strtotime(date('YmdHis'));
                                                        //Buka Nama Practitioner
                                                        $NamaPractitioner=getDataDetail($Conn,'referensi_practitioner','id_ihs_practitioner',$IdIhsPractitioner,'nama');
                                                        //Apabila Proses Generate ID Condition 
                                                        if($GenerateIdComposition!=="Ya"){
                                                            if(empty($_POST['id_composition'])){
                                                                $id_composition="";
                                                            }else{
                                                                $id_composition=$_POST['id_composition'];
                                                            }
                                                            $entry="INSERT INTO kunjungan_composition (
                                                                uniqIdComposition,
                                                                id_kunjungan,
                                                                id_composition,
                                                                id_pasien,
                                                                id_ihs_pasien,
                                                                status,
                                                                type_code,
                                                                type_display,
                                                                category_code,
                                                                category_display,
                                                                tanggal,
                                                                id_ihs_practitioner,
                                                                title,
                                                                ID_Org,
                                                                section_code,
                                                                section_display,
                                                                section_status,
                                                                section_div
                                                            ) VALUES (
                                                                '$uniqIdComposition',
                                                                '$id_kunjungan',
                                                                '$id_composition',
                                                                '$id_pasien',
                                                                '$id_ihs',
                                                                'final',
                                                                '$typeConpositionCode',
                                                                '$typeConpositionDisplay',
                                                                '$categoryConpositionCode',
                                                                '$categoryConpositionDisplay',
                                                                '$tanggal_kunjungan',
                                                                '$IdIhsPractitioner',
                                                                '$titleComposition',
                                                                '$IdOrg',
                                                                '$sectionConpositionCode',
                                                                '$sectionConpositionDisplay',
                                                                'additional',
                                                                '$sectionTextConposition'
                                                            )";
                                                            $hasil=mysqli_query($Conn, $entry);
                                                            if($hasil){
                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Composition ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                if($MenyimpanLog=="Berhasil"){
                                                                    echo '<span class="text-success" id="NotifikasiTambahCompositionBerhasil">Success</span>';
                                                                }else{
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                }
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Composition</span>';
                                                            }
                                                        }else{
                                                            //1. Cek pengaturan
                                                            $SettingSatuSehat=getDataDetail($Conn,'setting_satusehat','status','Active','id_setting_satusehat');
                                                            if(empty($SettingSatuSehat)){
                                                                echo '<span class="text-danger">Tidak Ada Pengaturan Satu Sehat Yang Aktiv!</span>';
                                                            }else{
                                                                //2. Generate Token
                                                                $Token=GenerateTokenSatuSehat($Conn);
                                                                if(empty($Token)){
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Generate Token</span>';
                                                                }else{
                                                                    //3. base URL
                                                                    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
                                                                    $BaseUrlSimrs=getDataDetail($Conn,'setting_profile ','status','Active','base_url');
                                                                    //Membentuk Data
                                                                    $identifier=Array (
                                                                        "system" => "$BaseUrlSimrs/ResourceSatuSehat.php&Category=Composition&id=$uniqIdComposition",
                                                                        "value" => "$uniqIdComposition",
                                                                    );
                                                                    $coding=Array (
                                                                        "0" => Array (
                                                                            "system" => "http://loinc.org",
                                                                            "code" => $typeConpositionCode,
                                                                            "display" => $typeConpositionDisplay
                                                                        )
                                                                    );
                                                                    $typeArray=Array (
                                                                        "coding" => $coding,
                                                                    );
                                                                    $categoryArray=Array (
                                                                        "0" => Array (
                                                                            "coding" => Array (
                                                                                "0" => Array (
                                                                                    "system" => "http://loinc.org",
                                                                                    "code" => "$categoryConpositionCode",
                                                                                    "display" => "$categoryConpositionDisplay"
                                                                                )
                                                                            )
                                                                        )
                                                                    );
                                                                    $subjectArray=Array (
                                                                        "reference" => "Patient/$id_ihs",
                                                                        "display" => "$nama",
                                                                    );
                                                                    $authorArray=Array (
                                                                        "0" => Array (
                                                                            "reference" => "Practitioner/$IdIhsPractitioner",
                                                                            "display" => "$NamaPractitioner",
                                                                        )
                                                                    );
                                                                    $custodianArray=Array (
                                                                        "reference" => "Organization/$IdOrg"
                                                                    );
                                                                    $encounterArray=Array (
                                                                        "reference" => "Encounter/$id_encounter",
                                                                        "display" => "Kunjungan $nama di Tanggal, $tanggal_kunjungan"
                                                                    );
                                                                    $sectionArray=Array (
                                                                        "0" => Array (
                                                                            "code" => Array (
                                                                                "coding" => Array (
                                                                                    "0" => Array (
                                                                                        "system" => "http://loinc.org",
                                                                                        "code" => "$sectionConpositionCode",
                                                                                        "display" => "$sectionConpositionDisplay"
                                                                                    )
                                                                                )
                                                                            ),
                                                                            "text" => Array (
                                                                                "status" => "additional",
                                                                                "div" => $sectionTextConposition
                                                                            )
                                                                        )
                                                                    );
                                                                    $KirimData = array(
                                                                        'resourceType' => 'Composition',
                                                                        'identifier' => $identifier,
                                                                        'status' => "final",
                                                                        'type' => $typeArray,
                                                                        'category' => $categoryArray,
                                                                        'subject' => $subjectArray,
                                                                        'encounter' => $encounterArray,
                                                                        'date' => "$tanggal_kunjungan",
                                                                        'author' => $authorArray,
                                                                        'title' => "$titleComposition",
                                                                        'custodian' => $custodianArray,
                                                                        'section' => $sectionArray
                                                                    );
                                                                    $JsonEncode = json_encode($KirimData);
                                                                    $response=CreatComposition($baseurl_satusehat,$JsonEncode,$Token);
                                                                    if(empty($response)){
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                                    }else{
                                                                        $JsonData =json_decode($response, true);
                                                                        if(empty($JsonData['id'])){
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                            echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                            echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                        }else{
                                                                            $id_composition=$JsonData['id'];
                                                                            //Simpan Data Ke Database
                                                                            $entry="INSERT INTO kunjungan_composition (
                                                                                uniqIdComposition,
                                                                                id_kunjungan,
                                                                                id_composition,
                                                                                id_pasien,
                                                                                id_ihs_pasien,
                                                                                status,
                                                                                type_code,
                                                                                type_display,
                                                                                category_code,
                                                                                category_display,
                                                                                tanggal,
                                                                                id_ihs_practitioner,
                                                                                title,
                                                                                ID_Org,
                                                                                section_code,
                                                                                section_display,
                                                                                section_status,
                                                                                section_div
                                                                            ) VALUES (
                                                                                '$uniqIdComposition',
                                                                                '$id_kunjungan',
                                                                                '$id_composition',
                                                                                '$id_pasien',
                                                                                '$id_ihs',
                                                                                'final',
                                                                                '$typeConpositionCode',
                                                                                '$typeConpositionDisplay',
                                                                                '$categoryConpositionCode',
                                                                                '$categoryConpositionDisplay',
                                                                                '$tanggal_kunjungan',
                                                                                '$IdIhsPractitioner',
                                                                                '$titleComposition',
                                                                                '$IdOrg',
                                                                                '$sectionConpositionCode',
                                                                                '$sectionConpositionDisplay',
                                                                                'additional',
                                                                                '$sectionTextConposition'
                                                                            )";
                                                                            $hasil=mysqli_query($Conn, $entry);
                                                                            if($hasil){
                                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Composition ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                if($MenyimpanLog=="Berhasil"){
                                                                                    echo '<span class="text-success" id="NotifikasiTambahCompositionBerhasil">Success</span>';
                                                                                }else{
                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                }
                                                                            }else{
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Composition</span>';
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
    }
?>