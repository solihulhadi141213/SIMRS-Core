<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Setting
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    $Token=GenerateTokenSatuSehat($Conn);
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    $LogJsonFile="../../_Page/Log/Log.json";
    if(empty($SettingSatuSehat)){
        echo '<span class="text-danger">Tidak ada setting satu sehat yang aktiv</span>';
    }else{
        if(empty($Token)){
            echo '<span class="text-danger">Generate Token Gagal!</span>';
        }else{
            //menangkap Data
            if(empty($_POST['id_obat_medication'])){
                echo '<span class="text-danger">ID Obat Medication Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['id_medication'])){
                    echo '<span class="text-danger">ID Medication Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['identifier_system'])){
                        echo '<span class="text-danger">Identifier System Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['identifier_use'])){
                            echo '<span class="text-danger">Identifier Use Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['identifier_value'])){
                                echo '<span class="text-danger">Identifier value Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['code_coding_system'])){
                                    echo '<span class="text-danger">Coding System Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['code_coding_code'])){
                                        echo '<span class="text-danger">Coding Code Tidak Boleh Kosong</span>';
                                    }else{
                                        if(empty($_POST['code_coding_display'])){
                                            echo '<span class="text-danger">Coding Display Tidak Boleh Kosong</span>';
                                        }else{
                                            if(empty($_POST['status'])){
                                                echo '<span class="text-danger">Status Ketersediaan Tidak Boleh Kosong</span>';
                                            }else{
                                                if(empty($_POST['manufacturer'])){
                                                    echo '<span class="text-danger">Manufacturer Tidak Boleh Kosong</span>';
                                                }else{
                                                    if(empty($_POST['form_coding_system'])){
                                                        echo '<span class="text-danger">Form Coding System Tidak Boleh Kosong</span>';
                                                    }else{
                                                        if(empty($_POST['form_coding_code'])){
                                                            echo '<span class="text-danger">Form Coding Code Tidak Boleh Kosong</span>';
                                                        }else{
                                                            if(empty($_POST['form_coding_display'])){
                                                                echo '<span class="text-danger">Form Coding Display Tidak Boleh Kosong</span>';
                                                            }else{
                                                                if(empty($_POST['extension_type'])){
                                                                    echo '<span class="text-danger">Extension Type Tidak Boleh Kosong</span>';
                                                                }else{
                                                                    if(empty($_POST['extension_url'])){
                                                                        echo '<span class="text-danger">Extension URL Tidak Boleh Kosong</span>';
                                                                    }else{
                                                                        if(empty($_POST['extension_system'])){
                                                                            echo '<span class="text-danger">Extension System Tidak Boleh Kosong</span>';
                                                                        }else{
                                                                            if(empty($_POST['extension_code'])){
                                                                                echo '<span class="text-danger">Extension Code Tidak Boleh Kosong</span>';
                                                                            }else{
                                                                                if(empty($_POST['extension_display'])){
                                                                                    echo '<span class="text-danger">Extension Display Tidak Boleh Kosong</span>';
                                                                                }else{
                                                                                    //Membuat Variabel
                                                                                    $id_obat_medication=$_POST['id_obat_medication'];
                                                                                    $id_medication=$_POST['id_medication'];
                                                                                    $identifier_system=$_POST['identifier_system'];
                                                                                    $identifier_use=$_POST['identifier_use'];
                                                                                    $identifier_value=$_POST['identifier_value'];
                                                                                    $code_coding_system=$_POST['code_coding_system'];
                                                                                    $code_coding_code=$_POST['code_coding_code'];
                                                                                    $code_coding_display=$_POST['code_coding_display'];
                                                                                    $status=$_POST['status'];
                                                                                    $manufacturer=$_POST['manufacturer'];
                                                                                    $form_coding_system=$_POST['form_coding_system'];
                                                                                    $form_coding_code=$_POST['form_coding_code'];
                                                                                    $form_coding_display=$_POST['form_coding_display'];
                                                                                    $extension_type=$_POST['extension_type'];
                                                                                    $extension_url=$_POST['extension_url'];
                                                                                    $extension_system=$_POST['extension_system'];
                                                                                    $extension_code=$_POST['extension_code'];
                                                                                    $extension_display=$_POST['extension_display'];
                                                                                    //Buka id_obat
                                                                                    $id_obat=getDataDetail($Conn,'obat','kode',$identifier_value,'id_obat');
                                                                                    if(empty($id_obat)){
                                                                                        echo '<span class="text-danger">Kode obat yang anda input tidak valid</span>';
                                                                                    }else{
                                                                                        $nama_obat=getDataDetail($Conn,'obat','kode',$identifier_value,'nama');
                                                                                        if(empty($_POST['itemCodeableConceptDisplay'])){
                                                                                            $ingredient=Array();
                                                                                        }else{
                                                                                            if(empty(count($_POST['itemCodeableConceptDisplay']))){
                                                                                                $ingredient=Array();
                                                                                            }else{
                                                                                                $jumlah_ingredient=count($_POST['itemCodeableConceptDisplay']);
                                                                                                $b=$jumlah_ingredient-1;
                                                                                                $ingredient=Array();
                                                                                                for ( $i=0; $i<=$b; $i++ ){
                                                                                                    $itemCodeableConceptDisplay=$_POST['itemCodeableConceptDisplay'][$i];
                                                                                                    $itemCodeableConceptCode=$_POST['itemCodeableConceptCode'][$i];
                                                                                                    $isActive=$_POST['isActive'][$i];
                                                                                                    $strength_numerator_value=$_POST['strength_numerator_value'][$i];
                                                                                                    $strength_numerator_code=$_POST['strength_numerator_code'][$i];
                                                                                                    $strength_denominator_value=$_POST['strength_denominator_value'][$i];
                                                                                                    $strength_denominator_code=$_POST['strength_denominator_code'][$i];
                                                                                                    
                                                                                                    $itemCodeableConcept_coding=array(
                                                                                                        array(
                                                                                                            "system" => "http://sys-ids.kemkes.go.id/kfa",
                                                                                                            "code" => $itemCodeableConceptCode,
                                                                                                            "display" => $itemCodeableConceptDisplay
                                                                                                        )
                                                                                                    );
                                                                                                    $h['itemCodeableConcept']=array(
                                                                                                        "coding" => $itemCodeableConcept_coding,
                                                                                                    );
                                                                                                    //Definisi Active
                                                                                                    if($isActive=="true"){
                                                                                                        $h['isActive']=true;
                                                                                                    }else{
                                                                                                        $h['isActive']=false;
                                                                                                    }
                                                                                                    $strength_numerator_value = intval($strength_numerator_value);
                                                                                                    $strength_denominator_value = intval($strength_denominator_value);
                                                                                                    $strength_numerator=array(
                                                                                                        "value" => $strength_numerator_value,
                                                                                                        "system" => "http://unitsofmeasure.org",
                                                                                                        "code" => $strength_numerator_code
                                                                                                    );
                                                                                                    $strength_denominator=array(
                                                                                                        "value" => $strength_numerator_value,
                                                                                                        "system" => "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                                                                                                        "code" => $strength_denominator_code
                                                                                                    );
                                                                                                    $h['strength']=array(
                                                                                                        "numerator" => $strength_numerator,
                                                                                                        "denominator" => $strength_denominator,
                                                                                                    );
                                                                                                    array_push($ingredient, $h);
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        $meta = array(
                                                                                            "profile" => array(
                                                                                                "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
                                                                                            )
                                                                                        );
                                                                                        $identifier = array(
                                                                                            array(
                                                                                                "system" => "http://sys-ids.kemkes.go.id/medication/$identifier_system",
                                                                                                "use" => $identifier_use,
                                                                                                "value" => $identifier_value
                                                                                            )
                                                                                        );
                                                                                        $code_coding = array(
                                                                                            array(
                                                                                                "system" => $code_coding_system,
                                                                                                "code" => $code_coding_code,
                                                                                                "display" => $code_coding_display
                                                                                            )
                                                                                        );
                                                                                        $code = array(
                                                                                            "coding" => $code_coding,
                                                                                        );
                                                                                        $form_coding = array(
                                                                                            array(
                                                                                                "system" => $form_coding_system,
                                                                                                "code" => $form_coding_code,
                                                                                                "display" => $form_coding_display
                                                                                            )
                                                                                        );
                                                                                        $manufacturer_reference=array(
                                                                                            'reference' => "Organization/$manufacturer",
                                                                                        );
                                                                                        $form=array(
                                                                                            'coding' => $form_coding,
                                                                                        );
                                                                                        $extension=Array (
                                                                                            "0" => Array (
                                                                                                "url" => $extension_url,
                                                                                                "valueCodeableConcept" => Array (
                                                                                                    "coding" => Array (
                                                                                                        "0" => Array (
                                                                                                            "system" => $extension_system,
                                                                                                            "code" => "$extension_code",
                                                                                                            "display" => "$extension_display"
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        );
                                                                                        $KirimData = array(
                                                                                            'resourceType' => 'Medication',
                                                                                            'id' => $id_medication,
                                                                                            'meta' => $meta,
                                                                                            'identifier' => $identifier,
                                                                                            'code' => $code,
                                                                                            'status' => $status,
                                                                                            'manufacturer' => $manufacturer_reference,
                                                                                            'form' => $form,
                                                                                            'ingredient' => $ingredient,
                                                                                            'extension' => $extension,
                                                                                        );
                                                                                        $JsonEncode = json_encode($KirimData);
                                                                                        $response=EditMedication($baseurl_satusehat,$JsonEncode,$Token,$id_medication);
                                                                                        if(empty($response)){
                                                                                            echo '<span class="text-danger">Tidak Ada Response Dari Satu Sehat</span>';
                                                                                        }else{
                                                                                            $JsonData =json_decode($response, true);
                                                                                            if(empty($JsonData['id'])){
                                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                                                                echo 'Response <textarea class="form-control">'.$response.'</textarea><br>';
                                                                                                echo 'Data Yang Dikirim <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                                                            }else{
                                                                                                $id_medication=$JsonData['id'];
                                                                                                //Update Data Ke Database obat_medication
                                                                                                $UpdateMedication = mysqli_query($Conn,"UPDATE obat_medication SET 
                                                                                                    id_obat='$id_obat',
                                                                                                    id_medication='$id_medication',
                                                                                                    kode='$identifier_value',
                                                                                                    nama='$nama_obat',
                                                                                                    raw_medication='$JsonEncode',
                                                                                                    id_akses='$SessionIdAkses',
                                                                                                    updatetime='$updatetime'
                                                                                                WHERE id_obat_medication='$id_obat_medication'") or die(mysqli_error($Conn)); 
                                                                                                if($UpdateMedication){
                                                                                                    //Update Data Obat
                                                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Medication","Medication",$SessionIdAkses,$LogJsonFile);
                                                                                                    if($MenyimpanLog=="Berhasil"){
                                                                                                        $_SESSION['NotifikasiSwal']="Edit Medication Berhasil";
                                                                                                        echo '<span class="text-success" id="NotifikasiEditMedicationBerhasil">Success</span>';
                                                                                                    }else{
                                                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                    }
                                                                                                }else{
                                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Obat Medication</span>';
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
            }
        }
    }
?>