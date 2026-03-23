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
                                    if(empty($_POST['id_kunjungan_composition'])){
                                        echo '<span class="text-danger">ID Kunjungan Conposition Tidak Boleh Kosong!</span>';
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
                                                        if(empty($_POST['id_kunjungan_composition'])){
                                                            echo '<span class="text-danger">ID Kunjungan Conposition Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['UpdateByComposition'])){
                                                                $UpdateByComposition="";
                                                            }else{
                                                                $UpdateByComposition=$_POST['UpdateByComposition'];
                                                            }
                                                            if(empty($_POST['id_composition'])){
                                                                $id_composition="";
                                                            }else{
                                                                $id_composition=$_POST['id_composition'];
                                                            }
                                                            //Membuat Variabel
                                                            $id_kunjungan_composition=$_POST['id_kunjungan_composition'];
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
                                                            if($UpdateByComposition!=="Ya"){
                                                                $UpdateComposition = mysqli_query($Conn,"UPDATE kunjungan_composition SET 
                                                                    uniqIdComposition='$uniqIdComposition',
                                                                    id_composition='$id_composition',
                                                                    id_pasien='$id_pasien',
                                                                    id_ihs_pasien='$id_ihs',
                                                                    type_code='$typeConpositionCode',
                                                                    type_display='$typeConpositionDisplay',
                                                                    category_code='$categoryConpositionCode',
                                                                    category_display='$categoryConpositionDisplay',
                                                                    tanggal='$tanggal_kunjungan',
                                                                    id_ihs_practitioner='$IdIhsPractitioner',
                                                                    title='$titleComposition',
                                                                    ID_Org='$IdOrg',
                                                                    section_code='$sectionConpositionCode',
                                                                    section_display='$sectionConpositionDisplay',
                                                                    section_div='$sectionTextConposition'
                                                                WHERE id_kunjungan_composition='$id_kunjungan_composition'") or die(mysqli_error($Conn)); 
                                                                if($UpdateComposition){
                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Composition ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                    if($MenyimpanLog=="Berhasil"){
                                                                        echo '<span class="text-success" id="NotifikasiEditCompositionBerhasil">Success</span>';
                                                                    }else{
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                    }
                                                                }else{
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Composition</span>';
                                                                }
                                                            }else{
                                                                if(empty($_POST['id_composition'])){
                                                                    echo '<span class="text-danger">Untuk melakukan update Composition, silahkan isi ID Composition</span>';
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
                                                                                'id' => $id_composition,
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
                                                                            $response=UpdateComposition($baseurl_satusehat,$JsonEncode,$Token,$id_composition);
                                                                            if(empty($response)){
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                                            }else{
                                                                                $JsonData =json_decode($response, true);
                                                                                if(empty($JsonData['id'])){
                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                                    echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                                    echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                                }else{
                                                                                    $UpdateComposition = mysqli_query($Conn,"UPDATE kunjungan_composition SET 
                                                                                        uniqIdComposition='$uniqIdComposition',
                                                                                        id_composition='$id_composition',
                                                                                        id_pasien='$id_pasien',
                                                                                        id_ihs_pasien='$id_ihs',
                                                                                        type_code='$typeConpositionCode',
                                                                                        type_display='$typeConpositionDisplay',
                                                                                        category_code='$categoryConpositionCode',
                                                                                        category_display='$categoryConpositionDisplay',
                                                                                        tanggal='$tanggal_kunjungan',
                                                                                        id_ihs_practitioner='$IdIhsPractitioner',
                                                                                        title='$titleComposition',
                                                                                        ID_Org='$IdOrg',
                                                                                        section_code='$sectionConpositionCode',
                                                                                        section_display='$sectionConpositionDisplay',
                                                                                        section_div='$sectionTextConposition'
                                                                                    WHERE id_kunjungan_composition='$id_kunjungan_composition'") or die(mysqli_error($Conn)); 
                                                                                    if($UpdateComposition){
                                                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Composition ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                        if($MenyimpanLog=="Berhasil"){
                                                                                            echo '<span class="text-success" id="NotifikasiEditCompositionBerhasil">Success</span>';
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
        }
    }
?>