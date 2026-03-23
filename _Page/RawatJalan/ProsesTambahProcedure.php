<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['GetIdKunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">ID/No.RM Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_ihs'])){
                echo '<span class="text-danger">ID IHS Pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['nama'])){
                    echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['id_encounter'])){
                        echo '<span class="text-danger">ID Encounter Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['tanggal_mulai'])){
                            echo '<span class="text-danger">Tanggal Mulai Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['waktu_mulai'])){
                                echo '<span class="text-danger">Waktu Mulai Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['tanggal_selesai'])){
                                    echo '<span class="text-danger">Tanggal Selesai Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['waktu_selesai'])){
                                        echo '<span class="text-danger">WaktuSelesai Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['IdPractitioner'])){
                                            echo '<span class="text-danger">ID Practitioner Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['category'])){
                                                echo '<span class="text-danger">Category Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['code_procedure'])){
                                                    echo '<span class="text-danger">Code Procedur Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['reasonCode'])){
                                                        echo '<span class="text-danger">Reson Code Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['bodySite'])){
                                                            echo '<span class="text-danger">Body Site Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['status'])){
                                                                echo '<span class="text-danger">Status Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                if(empty($_POST['note'])){
                                                                    $note="";
                                                                }else{
                                                                    $note=$_POST['note'];
                                                                }
                                                                //Membuat Variabel
                                                                $id_kunjungan=$_POST['GetIdKunjungan'];
                                                                $id_pasien=$_POST['id_pasien'];
                                                                $id_ihs=$_POST['id_ihs'];
                                                                $nama=$_POST['nama'];
                                                                $id_encounter=$_POST['id_encounter'];
                                                                $tanggal_mulai=$_POST['tanggal_mulai'];
                                                                $waktu_mulai=$_POST['waktu_mulai'];
                                                                $tanggal_selesai=$_POST['tanggal_selesai'];
                                                                $waktu_selesai=$_POST['waktu_selesai'];
                                                                $IdPractitioner=$_POST['IdPractitioner'];
                                                                $category=$_POST['category'];
                                                                $code_procedure=$_POST['code_procedure'];
                                                                $reasonCode=$_POST['reasonCode'];
                                                                $bodySite=$_POST['bodySite'];
                                                                $status=$_POST['status'];
                                                                //Gabungkan Tanggal
                                                                $tanggal_mulai="$tanggal_mulai $waktu_mulai";
                                                                $tanggal_selesai="$tanggal_selesai $waktu_selesai";
                                                                $strtotime1=strtotime($tanggal_mulai);
                                                                $strtotime2=strtotime($tanggal_selesai);
                                                                $performedPeriodStart=date('Y-m-d\TH:i:sP',$strtotime1);
                                                                $performedPeriodEnd=date('Y-m-d\TH:i:sP',$strtotime2);
                                                                //Pecah Karakter category
                                                                $Explode = explode("|" , $category);
                                                                $category_code=$Explode[0];
                                                                $category_display=$Explode[1];
                                                                //Pecah Karakter code_procedure
                                                                $Explode2 = explode("|" , $code_procedure);
                                                                $procedure_code=$Explode2[0];
                                                                $procedure_display=$Explode2[1];
                                                                //Pecah Karakter reasonCode
                                                                $Explode3 = explode("|" , $reasonCode);
                                                                $reason_code=$Explode3[0];
                                                                $reson_display=$Explode3[1];
                                                                //Pecah Karakter bodySite
                                                                $Explode4 = explode("|" , $bodySite);
                                                                $bodySiteCode=$Explode4[0];
                                                                $bodySiteDisplay=$Explode4[1];
                                                                //Buka Nama Practitioner
                                                                $NamaPractitioner=getDataDetail($Conn,'referensi_practitioner','id_ihs_practitioner',$IdPractitioner,'nama');
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
                                                                        $category_coding=Array (
                                                                            "0" => Array (
                                                                                "system" => "http://snomed.info/sct",
                                                                                "code" => "$category_code",
                                                                                "display" => "$category_display"
                                                                            )
                                                                        );
                                                                        $categoryArray=Array (
                                                                            "coding" => $category_coding,
                                                                            "text" => $category_display
                                                                        );
                                                                        $coding=Array (
                                                                            "0" => Array (
                                                                                "system" => "http://hl7.org/fhir/sid/icd-9-cm",
                                                                                "code" => $procedure_code,
                                                                                "display" => $procedure_display
                                                                            )
                                                                        );
                                                                        $codeArray=Array (
                                                                            "coding" => $coding,
                                                                        );
                                                                        $subjectArray=Array (
                                                                            "reference" => "Patient/$id_ihs",
                                                                            "display" => "$nama",
                                                                        );
                                                                        $encounterArray=Array (
                                                                            "reference" => "Encounter/$id_encounter",
                                                                            "display" => "Tindakan Untuk Kunjungan $nama"
                                                                        );
                                                                        $performedPeriodArray=Array (
                                                                            "start" => "$performedPeriodStart",
                                                                            "end" => "$performedPeriodEnd",
                                                                        );
                                                                        $actor_performer=Array (
                                                                            "reference" => "Practitioner/$IdPractitioner",
                                                                            "display" => "$NamaPractitioner",
                                                                        );
                                                                        $performerArray=Array (
                                                                            "0" => Array (
                                                                                "actor" => $actor_performer
                                                                            )
                                                                        );
                                                                        $reasonCodecoding=Array (
                                                                            "0" => Array (
                                                                                "system" => "http://hl7.org/fhir/sid/icd-10",
                                                                                "code" => $reason_code,
                                                                                "display" => $reson_display,
                                                                            )
                                                                        );
                                                                        $reasonCodeArray=Array (
                                                                            "0" => Array (
                                                                                "coding" => $reasonCodecoding
                                                                            )
                                                                        );
                                                                        $bodySiteCoding=Array (
                                                                            "0" => Array (
                                                                                "system" => "http://snomed.info/sct",
                                                                                "code" => $bodySiteCode,
                                                                                "display" => $bodySiteDisplay,
                                                                            )
                                                                        );
                                                                        $bodySiteArray=Array (
                                                                            "0" => Array (
                                                                                "coding" => $bodySiteCoding
                                                                            )
                                                                        );
                                                                        $noteArray=Array (
                                                                            "0" => Array (
                                                                                "text" => $note
                                                                            )
                                                                        );
                                                                        $KirimData = array(
                                                                            'resourceType' => 'Procedure',
                                                                            'status' => $status,
                                                                            'category' => $categoryArray,
                                                                            'code' => $codeArray,
                                                                            'subject' => $subjectArray,
                                                                            'encounter' => $encounterArray,
                                                                            'performedPeriod' => $performedPeriodArray,
                                                                            'performer' => $performerArray,
                                                                            'reasonCode' => $reasonCodeArray,
                                                                            'bodySite' => $bodySiteArray,
                                                                            'note' => $noteArray,
                                                                        );
                                                                        $JsonEncode = json_encode($KirimData);
                                                                        $response=CreatProcedur($baseurl_satusehat,$JsonEncode,$Token);
                                                                        if(empty($response)){
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span>';
                                                                        }else{
                                                                            $JsonData =json_decode($response, true);
                                                                            if(empty($JsonData['id'])){
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                                echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                                echo 'Send Data <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                            }else{
                                                                                $id_procedur=$JsonData['id'];
                                                                                //Simpan Data Ke Database
                                                                                $entry="INSERT INTO kunjungan_encounter (
                                                                                    id_kunjungan,
                                                                                    id_encounter,
                                                                                    id_pasien,
                                                                                    id_ihs,
                                                                                    resource_name,
                                                                                    IdSatuSehat
                                                                                ) VALUES (
                                                                                    '$id_kunjungan',
                                                                                    '$id_encounter',
                                                                                    '$id_pasien',
                                                                                    '$id_ihs',
                                                                                    'Procedure',
                                                                                    '$id_procedur'
                                                                                )";
                                                                                $hasil=mysqli_query($Conn, $entry);
                                                                                if($hasil){
                                                                                    $LogJsonFile="../../_Page/Log/Log.json";
                                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Procedur ID","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                    if($MenyimpanLog=="Berhasil"){
                                                                                        echo '<span class="text-success" id="NotifikasiTambahProcedureBerhasil">Success</span>';
                                                                                    }else{
                                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                    }
                                                                                }else{
                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Procedur</span>';
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