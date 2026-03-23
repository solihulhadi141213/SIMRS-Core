<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i:s');
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $Token=GenerateTokenSatuSehat($Conn);
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    if(empty($SettingSatuSehat)){
        echo '<span class="text-danger">Tidak Ada Setting Satu Sehat Yang Aktiv!</span>';
    }else{
        if(empty($Token)){
            echo '<span class="text-danger">Terjadi kesalahan pada saat membuat token!</span>';
        }else{
            //Validasi kelengkapan data
            if(empty($_POST['id_pasien'])){
                echo '<span class="text-danger">ID pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['id_kunjungan'])){
                    echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['encounter_reference'])){
                        echo '<span class="text-danger">ID Encounter Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['id_resep'])){
                            echo '<span class="text-danger">ID Resep Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['id_item_resep'])){
                                echo '<span class="text-danger">ID Item Resep Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['MedicationRequestSubjectReference'])){
                                    echo '<span class="text-danger">ID IHS Pasien Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($SessionIdAkses)){
                                        echo '<span class="text-danger">Session Akses Sudah Berakhir, Silahkan Login Ulang Terlebih Dulu!</span>';
                                    }else{
                                        $id_pasien=$_POST['id_pasien'];
                                        $id_kunjungan=$_POST['id_kunjungan'];
                                        $encounter_reference=$_POST['encounter_reference'];
                                        $id_resep=$_POST['id_resep'];
                                        $id_item_resep=$_POST['id_item_resep'];
                                        $id_ihs=$_POST['MedicationRequestSubjectReference'];
                                        //Variabel Tidak Wajib
                                        if(empty($_POST['identifier_system1'])){
                                            $identifier_system1="";
                                        }else{
                                            $identifier_system1=$_POST['identifier_system1'];
                                        }
                                        if(empty($_POST['identifier_use1'])){
                                            $identifier_use1="";
                                        }else{
                                            $identifier_use1=$_POST['identifier_use1'];
                                        }
                                        if(empty($_POST['identifier_value1'])){
                                            $identifier_value1="";
                                        }else{
                                            $identifier_value1=$_POST['identifier_value1'];
                                        }
                                        if(empty($_POST['identifier_system2'])){
                                            $identifier_system2="";
                                        }else{
                                            $identifier_system2=$_POST['identifier_system2'];
                                        }
                                        if(empty($_POST['identifier_use2'])){
                                            $identifier_use2="";
                                        }else{
                                            $identifier_use2=$_POST['identifier_use2'];
                                        }
                                        if(empty($_POST['identifier_value2'])){
                                            $identifier_value2="";
                                        }else{
                                            $identifier_value2=$_POST['identifier_value2'];
                                        }
                                        if(empty($_POST['medicationReference_reference'])){
                                            $medicationReference_reference="";
                                        }else{
                                            $medicationReference_reference=$_POST['medicationReference_reference'];
                                            $medicationReference_reference="Medication/$medicationReference_reference";
                                        }
                                        if(empty($_POST['medicationReference_display'])){
                                            $medicationReference_display="";
                                        }else{
                                            $medicationReference_display=$_POST['medicationReference_display'];
                                        }
                                        if(empty($_POST['status'])){
                                            $status="";
                                        }else{
                                            $status=$_POST['status'];
                                        }
                                        if(empty($_POST['intent'])){
                                            $intent="";
                                        }else{
                                            $intent=$_POST['intent'];
                                        }
                                        if(empty($_POST['priority'])){
                                            $priority="";
                                        }else{
                                            $priority=$_POST['priority'];
                                        }
                                        if(empty($_POST['authoredOn'])){
                                            $authoredOn="";
                                        }else{
                                            $authoredOn=$_POST['authoredOn'];
                                            $strtotime1=strtotime($authoredOn);
                                            $authoredOn=date('Y-m-d\TH:i:sP',$strtotime1);
                                        }
                                        if(empty($_POST['numberOfRepeatsAllowed'])){
                                            $numberOfRepeatsAllowed="0";
                                            $numberOfRepeatsAllowed = intval($numberOfRepeatsAllowed);
                                        }else{
                                            $numberOfRepeatsAllowed=$_POST['numberOfRepeatsAllowed'];
                                            $numberOfRepeatsAllowed = intval($numberOfRepeatsAllowed);
                                        }
                                        if(empty($_POST['MedicationRequestCategory'])){
                                            $MedicationRequestCategory="";
                                        }else{
                                            $MedicationRequestCategory=$_POST['MedicationRequestCategory'];
                                        }
                                        if(empty($_POST['MedicationRequestCategorySystem'])){
                                            $MedicationRequestCategorySystem="";
                                        }else{
                                            $MedicationRequestCategorySystem=$_POST['MedicationRequestCategorySystem'];
                                        }
                                        if(empty($_POST['MedicationRequestCategoryCode'])){
                                            $MedicationRequestCategoryCode="";
                                        }else{
                                            $MedicationRequestCategoryCode=$_POST['MedicationRequestCategoryCode'];
                                        }
                                        if(empty($_POST['MedicationRequestCategoryDisplay'])){
                                            $MedicationRequestCategoryDisplay="";
                                        }else{
                                            $MedicationRequestCategoryDisplay=$_POST['MedicationRequestCategoryDisplay'];
                                        }
                                        if(empty($_POST['MedicationRequestSubjectReference'])){
                                            $MedicationRequestSubjectReference="";
                                        }else{
                                            $MedicationRequestSubjectReference=$_POST['MedicationRequestSubjectReference'];
                                        }
                                        if(empty($_POST['MedicationRequestSubjectDisplay'])){
                                            $MedicationRequestSubjectDisplay="";
                                        }else{
                                            $MedicationRequestSubjectDisplay=$_POST['MedicationRequestSubjectDisplay'];
                                        }
                                        if(empty($_POST['MedicationRequestRequester'])){
                                            $MedicationRequestRequester="";
                                        }else{
                                            $MedicationRequestRequester=$_POST['MedicationRequestRequester'];
                                        }
                                        if(empty($_POST['requester_referense'])){
                                            $requester_referense="";
                                        }else{
                                            $requester_referense=$_POST['requester_referense'];
                                        }
                                        if(empty($_POST['requester_display'])){
                                            $requester_display="";
                                        }else{
                                            $requester_display=$_POST['requester_display'];
                                        }
                                        if(empty($_POST['MedicationRequestreasonCode_system'])){
                                            $MedicationRequestreasonCode_system="";
                                        }else{
                                            $MedicationRequestreasonCode_system=$_POST['MedicationRequestreasonCode_system'];
                                        }
                                        if(empty($_POST['MedicationRequestreasonCode_code'])){
                                            $MedicationRequestreasonCode_code="";
                                        }else{
                                            $MedicationRequestreasonCode_code=$_POST['MedicationRequestreasonCode_code'];
                                        }
                                        if(empty($_POST['MedicationRequestreasonCode_display'])){
                                            $MedicationRequestreasonCode_display="";
                                        }else{
                                            $MedicationRequestreasonCode_display=$_POST['MedicationRequestreasonCode_display'];
                                        }
                                        if(empty($_POST['MedicationRequestCourseOfTherapyType'])){
                                            $MedicationRequestCourseOfTherapyType="";
                                        }else{
                                            $MedicationRequestCourseOfTherapyType=$_POST['MedicationRequestCourseOfTherapyType'];
                                        }
                                        if(empty($_POST['courseOfTherapyType_system'])){
                                            $courseOfTherapyType_system="";
                                        }else{
                                            $courseOfTherapyType_system=$_POST['courseOfTherapyType_system'];
                                        }
                                        if(empty($_POST['courseOfTherapyType_code'])){
                                            $courseOfTherapyType_code="";
                                        }else{
                                            $courseOfTherapyType_code=$_POST['courseOfTherapyType_code'];
                                        }
                                        if(empty($_POST['courseOfTherapyType_display'])){
                                            $courseOfTherapyType_display="";
                                        }else{
                                            $courseOfTherapyType_display=$_POST['courseOfTherapyType_display'];
                                        }
                                        if(empty($_POST['dosageInstruction_sequence'])){
                                            $dosageInstruction_sequence="";
                                        }else{
                                            $dosageInstruction_sequence=$_POST['dosageInstruction_sequence'];
                                            $dosageInstruction_sequence = intval($dosageInstruction_sequence);
                                        }
                                        if(empty($_POST['dosageInstruction_text'])){
                                            $dosageInstruction_text="";
                                        }else{
                                            $dosageInstruction_text=$_POST['dosageInstruction_text'];
                                        }
                                        if(empty($_POST['dosageInstruction_additionalInstruction'])){
                                            $dosageInstruction_additionalInstruction="";
                                        }else{
                                            $dosageInstruction_additionalInstruction=$_POST['dosageInstruction_additionalInstruction'];
                                        }
                                        if(empty($_POST['patientInstruction'])){
                                            $patientInstruction="";
                                        }else{
                                            $patientInstruction=$_POST['patientInstruction'];
                                        }
                                        if(empty($_POST['timing_repeat_frequency'])){
                                            $timing_repeat_frequency="";
                                        }else{
                                            $timing_repeat_frequency=$_POST['timing_repeat_frequency'];
                                            $timing_repeat_frequency = intval($timing_repeat_frequency);
                                        }
                                        if(empty($_POST['timing_repeat_period'])){
                                            $timing_repeat_period="";
                                        }else{
                                            $timing_repeat_period=$_POST['timing_repeat_period'];
                                            $timing_repeat_period = intval($timing_repeat_period);
                                        }
                                        if(empty($_POST['timing_repeat_periodUnit'])){
                                            $timing_repeat_periodUnit="";
                                        }else{
                                            $timing_repeat_periodUnit=$_POST['timing_repeat_periodUnit'];
                                        }
                                        if(empty($_POST['PilihDosageInstructionRout'])){
                                            $PilihDosageInstructionRout="";
                                        }else{
                                            $PilihDosageInstructionRout=$_POST['PilihDosageInstructionRout'];
                                        }
                                        if(empty($_POST['DosageInstructionRoutSystem'])){
                                            $DosageInstructionRoutSystem="";
                                        }else{
                                            $DosageInstructionRoutSystem=$_POST['DosageInstructionRoutSystem'];
                                        }
                                        if(empty($_POST['DosageInstructionRoutCode'])){
                                            $DosageInstructionRoutCode="";
                                        }else{
                                            $DosageInstructionRoutCode=$_POST['DosageInstructionRoutCode'];
                                        }
                                        if(empty($_POST['DosageInstructionRoutDisplay'])){
                                            $DosageInstructionRoutDisplay="";
                                        }else{
                                            $DosageInstructionRoutDisplay=$_POST['DosageInstructionRoutDisplay'];
                                        }
                                        if(empty($_POST['DoseAndRateType'])){
                                            $DoseAndRateType="";
                                        }else{
                                            $DoseAndRateType=$_POST['DoseAndRateType'];
                                        }
                                        if(empty($_POST['DoseAndRateTypeSystem'])){
                                            $DoseAndRateTypeSystem="";
                                        }else{
                                            $DoseAndRateTypeSystem=$_POST['DoseAndRateTypeSystem'];
                                        }
                                        if(empty($_POST['DoseAndRateTypeCode'])){
                                            $DoseAndRateTypeCode="";
                                        }else{
                                            $DoseAndRateTypeCode=$_POST['DoseAndRateTypeCode'];
                                        }
                                        if(empty($_POST['DoseAndRateTypeDisplay'])){
                                            $DoseAndRateTypeDisplay="";
                                        }else{
                                            $DoseAndRateTypeDisplay=$_POST['DoseAndRateTypeDisplay'];
                                        }
                                        if(empty($_POST['DoseQuantityValue'])){
                                            $DoseQuantityValue="";
                                        }else{
                                            $DoseQuantityValue=$_POST['DoseQuantityValue'];
                                            $DoseQuantityValue = intval($DoseQuantityValue);
                                        }
                                        if(empty($_POST['DoseQuantityUnit'])){
                                            $DoseQuantityUnit="";
                                        }else{
                                            $DoseQuantityUnit=$_POST['DoseQuantityUnit'];
                                        }
                                        if(empty($_POST['DoseQuantitySystem'])){
                                            $DoseQuantitySystem="";
                                        }else{
                                            $DoseQuantitySystem=$_POST['DoseQuantitySystem'];
                                        }
                                        if(empty($_POST['DoseQuantityCode'])){
                                            $DoseQuantityCode="";
                                        }else{
                                            $DoseQuantityCode=$_POST['DoseQuantityCode'];
                                        }
                                        if(empty($_POST['DoseQuantityDisplay'])){
                                            $DoseQuantityDisplay="";
                                        }else{
                                            $DoseQuantityDisplay=$_POST['DoseQuantityDisplay'];
                                        }
                                        if(empty($_POST['dispenseIntervalValue'])){
                                            $dispenseIntervalValue="";
                                        }else{
                                            $dispenseIntervalValue=$_POST['dispenseIntervalValue'];
                                            $dispenseIntervalValue = intval($dispenseIntervalValue);
                                        }
                                        if(empty($_POST['dispenseIntervalUnit'])){
                                            $dispenseIntervalUnit="";
                                        }else{
                                            $dispenseIntervalUnit=$_POST['dispenseIntervalUnit'];
                                        }
                                        if(empty($_POST['dispenseIntervalSystem'])){
                                            $dispenseIntervalSystem="";
                                        }else{
                                            $dispenseIntervalSystem=$_POST['dispenseIntervalSystem'];
                                        }
                                        if(empty($_POST['dispenseIntervalCode'])){
                                            $dispenseIntervalCode="";
                                        }else{
                                            $dispenseIntervalCode=$_POST['dispenseIntervalCode'];
                                        }
                                        if(empty($_POST['dispenseIntervalDisplay'])){
                                            $dispenseIntervalDisplay="";
                                        }else{
                                            $dispenseIntervalDisplay=$_POST['dispenseIntervalDisplay'];
                                        }
                                        if(empty($_POST['validityPeriod_start'])){
                                            $validityPeriod_start="";
                                        }else{
                                            $validityPeriod_start=$_POST['validityPeriod_start'];
                                            $strtotime2=strtotime($validityPeriod_start);
                                            $validityPeriod_start=date('Y-m-d\TH:i:sP',$strtotime2);
                                        }
                                        if(empty($_POST['validityPeriod_end'])){
                                            $validityPeriod_end="";
                                        }else{
                                            $validityPeriod_end=$_POST['validityPeriod_end'];
                                            $strtotime3=strtotime($validityPeriod_end);
                                            $validityPeriod_end=date('Y-m-d\TH:i:sP',$strtotime3);
                                        }
                                        if(empty($_POST['quantity_value'])){
                                            $quantity_value="";
                                        }else{
                                            $quantity_value=$_POST['quantity_value'];
                                            $quantity_value = intval($quantity_value);
                                        }
                                        if(empty($_POST['pilih_quantity_unit'])){
                                            $pilih_quantity_unit="";
                                        }else{
                                            $pilih_quantity_unit=$_POST['pilih_quantity_unit'];
                                        }
                                        if(empty($_POST['quantity_system'])){
                                            $quantity_system="";
                                        }else{
                                            $quantity_system=$_POST['quantity_system'];
                                        }
                                        if(empty($_POST['quantity_code'])){
                                            $quantity_code="";
                                        }else{
                                            $quantity_code=$_POST['quantity_code'];
                                        }
                                        if(empty($_POST['quantity_display'])){
                                            $quantity_display="";
                                        }else{
                                            $quantity_display=$_POST['quantity_display'];
                                        }
                                        if(empty($_POST['expectedSupplyDurationValue'])){
                                            $expectedSupplyDurationValue="";
                                        }else{
                                            $expectedSupplyDurationValue=$_POST['expectedSupplyDurationValue'];
                                            $expectedSupplyDurationValue = intval($expectedSupplyDurationValue);
                                        }
                                        if(empty($_POST['expectedSupplyDurationUnit'])){
                                            $expectedSupplyDurationUnit="";
                                        }else{
                                            $expectedSupplyDurationUnit=$_POST['expectedSupplyDurationUnit'];
                                        }
                                        if(empty($_POST['expectedSupplyDurationSystem'])){
                                            $expectedSupplyDurationSystem="";
                                        }else{
                                            $expectedSupplyDurationSystem=$_POST['expectedSupplyDurationSystem'];
                                        }
                                        if(empty($_POST['expectedSupplyDurationCode'])){
                                            $expectedSupplyDurationCode="";
                                        }else{
                                            $expectedSupplyDurationCode=$_POST['expectedSupplyDurationCode'];
                                        }
                                        if(empty($_POST['expectedSupplyDurationDisplay'])){
                                            $expectedSupplyDurationDisplay="";
                                        }else{
                                            $expectedSupplyDurationDisplay=$_POST['expectedSupplyDurationDisplay'];
                                        }
                                        if(empty($_POST['performer_reference'])){
                                            $performer_reference="";
                                        }else{
                                            $performer_reference=$_POST['performer_reference'];
                                        }
                                        //$identifier
                                        $identifier = array(
                                            array(
                                                "system" => $identifier_system1,
                                                "use" => $identifier_use1,
                                                "value" => $identifier_value1
                                            ),
                                            array(
                                                "system" => $identifier_system2,
                                                "use" => $identifier_use2,
                                                "value" => $identifier_value2
                                            )
                                        );
                                        //$category
                                        $category = array(
                                            array(
                                                "coding" => array(
                                                    array(
                                                        "system" => $MedicationRequestCategorySystem,
                                                        "code" => $MedicationRequestCategoryCode,
                                                        "display" => $MedicationRequestCategoryDisplay
                                                    )
                                                )
                                            )
                                        );
                                        //medicationReference
                                        $medicationReference = array(
                                            "reference" => $medicationReference_reference,
                                            "display" => $medicationReference_display
                                        );         
                                        //subject
                                        $subject = array(
                                            "reference" => $MedicationRequestSubjectReference,
                                            "display" => $MedicationRequestSubjectDisplay
                                        );    
                                        //encounter
                                        $encounter = array(
                                            "reference" => $encounter_reference
                                        );    
                                        //requester
                                        $requester = array(
                                            "reference" => $requester_referense,
                                            "display" => $requester_display
                                        );
                                        //reasonCode
                                        $reasonCode = array(
                                            array(
                                                "coding" => array(
                                                    array(
                                                        "system" => $MedicationRequestreasonCode_system,
                                                        "code" => $MedicationRequestreasonCode_code,
                                                        "display" => $MedicationRequestreasonCode_display
                                                    )
                                                )
                                            )
                                        );
                                        //courseOfTherapyType
                                        $courseOfTherapyType = array(
                                            "coding" => array(
                                                array(
                                                    "system" => $courseOfTherapyType_system,
                                                    "code" => $courseOfTherapyType_code,
                                                    "display" => $courseOfTherapyType_display
                                                )
                                            )
                                        );  
                                        //dosageInstruction
                                        $dosageInstruction = [
                                            [
                                                "sequence" => $dosageInstruction_sequence,
                                                "text" => $dosageInstruction_text,
                                                "additionalInstruction" => [
                                                    [
                                                        "text" => $dosageInstruction_additionalInstruction
                                                    ]
                                                ],
                                                "patientInstruction" => $patientInstruction,
                                                "timing" => [
                                                    "repeat" => [
                                                        "frequency" => $timing_repeat_frequency,
                                                        "period" => $timing_repeat_period,
                                                        "periodUnit" => $timing_repeat_periodUnit
                                                    ]
                                                ],
                                                "route" => [
                                                    "coding" => [
                                                        [
                                                            "system" => $DosageInstructionRoutSystem,
                                                            "code" => $DosageInstructionRoutCode,
                                                            "display" => $DosageInstructionRoutDisplay
                                                        ]
                                                    ]
                                                ],
                                                "doseAndRate" => [
                                                    [
                                                        "type" => [
                                                            "coding" => [
                                                                [
                                                                    "system" => $DoseAndRateTypeSystem,
                                                                    "code" => $DoseAndRateTypeCode,
                                                                    "display" => $DoseAndRateTypeDisplay
                                                                ]
                                                            ]
                                                        ],
                                                        "doseQuantity" => [
                                                            "value" => $DoseQuantityValue,
                                                            "unit" => $DoseQuantityUnit,
                                                            "system" => $DoseQuantitySystem,
                                                            "code" => $DoseQuantityCode
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ];
                                        //dispenseRequest
                                        $dispenseRequest = [
                                            "dispenseInterval" => [
                                                "value" => $dispenseIntervalValue,
                                                "unit" => $dispenseIntervalUnit,
                                                "system" => $dispenseIntervalSystem,
                                                "code" => $dispenseIntervalCode
                                            ],
                                            "validityPeriod" => [
                                                "start" =>  $validityPeriod_start,
                                                "end" => $validityPeriod_end
                                            ],
                                            "numberOfRepeatsAllowed" => $numberOfRepeatsAllowed,
                                            "quantity" => [
                                                "value" => $quantity_value,
                                                "unit" =>  $quantity_display,
                                                "system" => $quantity_system,
                                                "code" => $quantity_code
                                            ],
                                            "expectedSupplyDuration" => [
                                                "value" => $expectedSupplyDurationValue,
                                                "unit" => $expectedSupplyDurationDisplay,
                                                "system" => $expectedSupplyDurationSystem,
                                                "code" => $expectedSupplyDurationCode
                                            ],
                                            "performer" => [
                                                "reference" => "Organization/$performer_reference"
                                            ]
                                        ];
                                        $KirimData = array(
                                            'resourceType' => 'MedicationRequest',
                                            'identifier' => $identifier,
                                            'status' => $status,
                                            'intent' => $intent,
                                            'category' => $category,
                                            'priority' => $priority,
                                            'medicationReference' => $medicationReference,
                                            'subject' => $subject,
                                            'encounter' => $encounter,
                                            'authoredOn' => $authoredOn,
                                            'requester' => $requester,
                                            'reasonCode' => $reasonCode,
                                            'courseOfTherapyType' => $courseOfTherapyType,
                                            'dosageInstruction' => $dosageInstruction,
                                            'dispenseRequest' => $dispenseRequest
                                        );
                                        $JsonEncode = json_encode($KirimData);
                                        $response=CreatMedicationRequest($baseurl_satusehat,$JsonEncode,$Token);
                                        if(empty($response)){
                                            echo '<span class="text-danger">Tidak Ada Response Dari Platform Satu Sehat</span>';
                                        }else{
                                            $JsonData =json_decode($response, true);
                                            if(empty($JsonData['id'])){
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                echo 'Data Yang Dikirim <textarea class="form-control">'.$JsonEncode.'</textarea><br>';
                                                echo 'Response Yang Diterima <textarea class="form-control">'.$response.'</textarea><br>';
                                            }else{
                                                $id_medication_req=$JsonData['id'];
                                                //Simpan Data Ke Database
                                                $entry="INSERT INTO kunjungan_med_req (
                                                    id_kunjungan,
                                                    id_pasien,
                                                    id_resep,
                                                    id_item_resep,
                                                    id_medication_req,
                                                    raw_med_req,
                                                    id_akses,
                                                    updatetime
                                                ) VALUES (
                                                    '$id_kunjungan',
                                                    '$id_pasien',
                                                    '$id_resep',
                                                    '$id_item_resep',
                                                    '$id_medication_req',
                                                    '$JsonEncode',
                                                    '$SessionIdAkses',
                                                    '$updatetime'
                                                )";
                                                $hasil=mysqli_query($Conn, $entry);
                                                if($hasil){
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Medication Request","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        echo '<span class="text-success" id="NotifikasiTambahMedicationRequestBerhasil">Success</span>';
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Medication Request</span>';
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