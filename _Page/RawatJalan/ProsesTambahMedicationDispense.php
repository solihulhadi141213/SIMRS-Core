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
                                if(empty($_POST['MedicationDispenseSubjectReference'])){
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
                                        $id_ihs=$_POST['MedicationDispenseSubjectReference'];
                                        //Identifier
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
                                        //Status
                                        if(empty($_POST['status'])){
                                            $status="";
                                        }else{
                                            $status=$_POST['status'];
                                        }
                                        //Category
                                        if(empty($_POST['MedicationDismpenseCategory'])){
                                            $MedicationDismpenseCategory="";
                                        }else{
                                            $MedicationDismpenseCategory=$_POST['MedicationDismpenseCategory'];
                                        }
                                        if(empty($_POST['MedicationDispenseCategoryCode'])){
                                            $MedicationDispenseCategoryCode="";
                                        }else{
                                            $MedicationDispenseCategoryCode=$_POST['MedicationDispenseCategoryCode'];
                                        }
                                        if(empty($_POST['MedicationDispenseCategoryDisplay'])){
                                            $MedicationDispenseCategoryDisplay="";
                                        }else{
                                            $MedicationDispenseCategoryDisplay=$_POST['MedicationDispenseCategoryDisplay'];
                                        }
                                        //Medication Referense
                                        if(empty($_POST['medicationReference_reference'])){
                                            $medicationReference_reference="";
                                        }else{
                                            $medicationReference_reference=$_POST['medicationReference_reference'];
                                        }
                                        if(empty($_POST['medicationReference_display'])){
                                            $medicationReference_display="";
                                        }else{
                                            $medicationReference_display=$_POST['medicationReference_display'];
                                        }
                                        //Subject
                                        if(empty($_POST['MedicationDispenseSubjectReference'])){
                                            $MedicationDispenseSubjectReference="";
                                        }else{
                                            $MedicationDispenseSubjectReference=$_POST['MedicationDispenseSubjectReference'];
                                        }
                                        if(empty($_POST['MedicationDispenseSubjectDisplay'])){
                                            $MedicationDispenseSubjectDisplay="";
                                        }else{
                                            $MedicationDispenseSubjectDisplay=$_POST['MedicationDispenseSubjectDisplay'];
                                        }
                                        //Performaer
                                        if(empty($_POST['MedicationDispensePerformer'])){
                                            $MedicationDispensePerformer="";
                                        }else{
                                            $MedicationDispensePerformer=$_POST['MedicationDispensePerformer'];
                                        }
                                        if(empty($_POST['MedicationDispensePerformerReferense'])){
                                            $MedicationDispensePerformerReferense="";
                                        }else{
                                            $MedicationDispensePerformerReferense=$_POST['MedicationDispensePerformerReferense'];
                                        }
                                        if(empty($_POST['MedicationDispensePerformerDisplay'])){
                                            $MedicationDispensePerformerDisplay="";
                                        }else{
                                            $MedicationDispensePerformerDisplay=$_POST['MedicationDispensePerformerDisplay'];
                                        }
                                        //Location
                                        if(empty($_POST['MedicationDispenseLocation'])){
                                            $MedicationDispenseLocation="";
                                        }else{
                                            $MedicationDispenseLocation=$_POST['MedicationDispenseLocation'];
                                        }
                                        if(empty($_POST['MedicationDispenseLocationReferense'])){
                                            $MedicationDispenseLocationReferense="";
                                        }else{
                                            $MedicationDispenseLocationReferense=$_POST['MedicationDispenseLocationReferense'];
                                        }
                                        if(empty($_POST['MedicationDispenseLocationDisplay'])){
                                            $MedicationDispenseLocationDisplay="";
                                        }else{
                                            $MedicationDispenseLocationDisplay=$_POST['MedicationDispenseLocationDisplay'];
                                        }
                                        //Authorizing Prescription
                                        if(empty($_POST['MedicationDispenseAuthorizingPrescription'])){
                                            $MedicationDispenseAuthorizingPrescription="";
                                        }else{
                                            $MedicationDispenseAuthorizingPrescription=$_POST['MedicationDispenseAuthorizingPrescription'];
                                        }
                                        //quantity
                                        if(empty($_POST['MedicationDispenseQuantitySystem'])){
                                            $MedicationDispenseQuantitySystem="";
                                        }else{
                                            $MedicationDispenseQuantitySystem=$_POST['MedicationDispenseQuantitySystem'];
                                        }
                                        if(empty($_POST['MedicationDispenseQuantityValue'])){
                                            $MedicationDispenseQuantityValue=0;
                                        }else{
                                            $MedicationDispenseQuantityValue=$_POST['MedicationDispenseQuantityValue'];
                                            $MedicationDispenseQuantityValue = intval($MedicationDispenseQuantityValue);
                                        }
                                        if(empty($_POST['MedicationDispenseQuantityCode'])){
                                            $MedicationDispenseQuantityCode="";
                                        }else{
                                            $MedicationDispenseQuantityCode=$_POST['MedicationDispenseQuantityCode'];
                                        }
                                        //daysSupply
                                        if(empty($_POST['MedicationDispenseDaysSupplySystem'])){
                                            $MedicationDispenseDaysSupplySystem="";
                                        }else{
                                            $MedicationDispenseDaysSupplySystem=$_POST['MedicationDispenseDaysSupplySystem'];
                                        }
                                        if(empty($_POST['MedicationDispenseDaysSupplyValue'])){
                                            $MedicationDispenseDaysSupplyValue=0;
                                        }else{
                                            $MedicationDispenseDaysSupplyValue=$_POST['MedicationDispenseDaysSupplyValue'];
                                            $MedicationDispenseDaysSupplyValue = intval($MedicationDispenseDaysSupplyValue);
                                        }
                                        if(empty($_POST['MedicationDispenseDaysSupplyUnit'])){
                                            $MedicationDispenseDaysSupplyUnit="";
                                        }else{
                                            $MedicationDispenseDaysSupplyUnit=$_POST['MedicationDispenseDaysSupplyUnit'];
                                            $UnitList = array(
                                                'ms' => 'milliseconds',
                                                's' => 'second',
                                                'min' => 'minutes',
                                                'h' => 'hours',
                                                'd' => 'days',
                                                'w' => 'weeks',
                                                'm' => 'months',
                                                'a' => 'years',
                                            );
                                            $MedicationDispenseDaysSupplyUnitDisplay=$UnitList[$MedicationDispenseDaysSupplyUnit];
                                        }
                                        //whenPrepared
                                        if(empty($_POST['MedicationDispenseWhenPreparedTanggal'])){
                                            $MedicationDispenseWhenPreparedTanggal="";
                                        }else{
                                            $MedicationDispenseWhenPreparedTanggal=$_POST['MedicationDispenseWhenPreparedTanggal'];
                                        }
                                        if(empty($_POST['MedicationDispenseWhenPreparedJam'])){
                                            $MedicationDispenseWhenPreparedJam="";
                                        }else{
                                            $MedicationDispenseWhenPreparedJam=$_POST['MedicationDispenseWhenPreparedJam'];
                                        }
                                        $whenPrepared="$MedicationDispenseWhenPreparedTanggal $MedicationDispenseWhenPreparedJam";
                                        $strtotime1=strtotime($whenPrepared);
                                        $whenPrepared=date("Y-m-d\TH:i:s\Z", $strtotime1);
                                        //whenHandedOver
                                        if(empty($_POST['MedicationDispenseWhenHandedOverTanggal'])){
                                            $MedicationDispenseWhenHandedOverTanggal="";
                                        }else{
                                            $MedicationDispenseWhenHandedOverTanggal=$_POST['MedicationDispenseWhenHandedOverTanggal'];
                                        }
                                        if(empty($_POST['MedicationDispenseWhenHandedOverJam'])){
                                            $MedicationDispenseWhenHandedOverJam="";
                                        }else{
                                            $MedicationDispenseWhenHandedOverJam=$_POST['MedicationDispenseWhenHandedOverJam'];
                                        }
                                        $whenHandedOver="$MedicationDispenseWhenHandedOverTanggal $MedicationDispenseWhenHandedOverJam";
                                        $strtotime2=strtotime($whenHandedOver);
                                        $whenHandedOver=date("Y-m-d\TH:i:s\Z", $strtotime2);
                                        //dosageInstruction
                                        if(empty($_POST['MedicationDispenseDosageInstructionSequence'])){
                                            $MedicationDispenseDosageInstructionSequence=0;
                                        }else{
                                            $MedicationDispenseDosageInstructionSequence=$_POST['MedicationDispenseDosageInstructionSequence'];
                                            $MedicationDispenseDosageInstructionSequence = intval($MedicationDispenseDosageInstructionSequence);
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionText'])){
                                            $MedicationDispenseDosageInstructionText="";
                                        }else{
                                            $MedicationDispenseDosageInstructionText=$_POST['MedicationDispenseDosageInstructionText'];
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionTimingRepeatFrequency'])){
                                            $MedicationDispenseDosageInstructionTimingRepeatFrequency=0;
                                        }else{
                                            $MedicationDispenseDosageInstructionTimingRepeatFrequency=$_POST['MedicationDispenseDosageInstructionTimingRepeatFrequency'];
                                            $MedicationDispenseDosageInstructionTimingRepeatFrequency = intval($MedicationDispenseDosageInstructionTimingRepeatFrequency);
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionTimingRepeatPeriod'])){
                                            $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
                                        }else{
                                            $MedicationDispenseDosageInstructionTimingRepeatPeriod=$_POST['MedicationDispenseDosageInstructionTimingRepeatPeriod'];
                                            $MedicationDispenseDosageInstructionTimingRepeatPeriod = intval($MedicationDispenseDosageInstructionTimingRepeatPeriod);
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionTimingRepeatPeriodUnit'])){
                                            $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
                                        }else{
                                            $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit=$_POST['MedicationDispenseDosageInstructionTimingRepeatPeriodUnit'];
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem'])){
                                            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem="";
                                        }else{
                                            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem=$_POST['MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem'];
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode'])){
                                            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
                                            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingDisplay="";
                                        }else{
                                            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode=$_POST['MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode'];
                                            if($MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode=="calculated"){
                                                $MedicationDispenseDosageInstructionDoseAndRateTypeCodingDisplay="Calculated";
                                            }else{
                                                if($MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode=="ordered"){
                                                    $MedicationDispenseDosageInstructionDoseAndRateTypeCodingDisplay="Ordered";
                                                }else{
                                                    $MedicationDispenseDosageInstructionDoseAndRateTypeCodingDisplay="";
                                                }
                                            }
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem'])){
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem="";
                                        }else{
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem=$_POST['MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem'];
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue'])){
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue=0;
                                        }else{
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue=$_POST['MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue'];
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue = intval($MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue);
                                        }
                                        if(empty($_POST['MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit'])){
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
                                        }else{
                                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit=$_POST['MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit'];
                                        }
                                        //Json Arrar
                                        $KirimData = array(
                                            "resourceType" => "MedicationDispense",
                                            "identifier" => array(
                                                array(
                                                    "system" => $identifier_system1,
                                                    "use" =>  $identifier_use1,
                                                    "value" => $identifier_value1
                                                ),
                                                array(
                                                    "system" => $identifier_system2,
                                                    "use" => $identifier_use2,
                                                    "value" => $identifier_value2
                                                )
                                            ),
                                            "status" => $status,
                                            "category" => array(
                                                "coding" => array(
                                                    array(
                                                        "system" => "http://terminology.hl7.org/fhir/CodeSystem/medicationdispense-category",
                                                        "code" => $MedicationDispenseCategoryCode,
                                                        "display" => $MedicationDispenseCategoryDisplay
                                                    )
                                                )
                                            ),
                                            "medicationReference" => array(
                                                "reference" => "Medication/$medicationReference_reference",
                                                "display" => $medicationReference_display
                                            ),
                                            "subject" => array(
                                                "reference" => $MedicationDispenseSubjectReference,
                                                "display" => $MedicationDispenseSubjectDisplay
                                            ),
                                            "context" => array(
                                                "reference" => $encounter_reference
                                            ),
                                            "performer" => array(
                                                array(
                                                    "actor" => array(
                                                        "reference" => $MedicationDispensePerformerReferense,
                                                        "display" => $MedicationDispensePerformerDisplay
                                                    )
                                                )
                                            ),
                                            "location" => array(
                                                "reference" => $MedicationDispenseLocationReferense,
                                                "display" => $MedicationDispenseLocationDisplay
                                            ),
                                            "authorizingPrescription" => array(
                                                array(
                                                    "reference" => $MedicationDispenseAuthorizingPrescription
                                                )
                                            ),
                                            "quantity" => array(
                                                "system" => $MedicationDispenseQuantitySystem,
                                                "code" => $MedicationDispenseQuantityCode,
                                                "value" => $MedicationDispenseQuantityValue
                                            ),
                                            "daysSupply" => array(
                                                "value" => $MedicationDispenseDaysSupplyValue,
                                                "unit" => $MedicationDispenseDaysSupplyUnitDisplay,
                                                "system" => $MedicationDispenseDaysSupplySystem,
                                                "code" => $MedicationDispenseDaysSupplyUnit
                                            ),
                                            "whenPrepared" => $whenPrepared,
                                            "whenHandedOver" => $whenHandedOver,
                                            "dosageInstruction" => array(
                                                array(
                                                    "sequence" => $MedicationDispenseDosageInstructionSequence,
                                                    "text" => $MedicationDispenseDosageInstructionText,
                                                    "timing" => array(
                                                        "repeat" => array(
                                                            "frequency" => $MedicationDispenseDosageInstructionTimingRepeatFrequency,
                                                            "period" => $MedicationDispenseDosageInstructionTimingRepeatPeriod,
                                                            "periodUnit" => $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit
                                                        )
                                                    ),
                                                    "doseAndRate" => array(
                                                        array(
                                                            "type" => array(
                                                                "coding" => array(
                                                                    array(
                                                                        "system" => $MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem,
                                                                        "code" => $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode,
                                                                        "display" => $MedicationDispenseDosageInstructionDoseAndRateTypeCodingDisplay
                                                                    )
                                                                )
                                                            ),
                                                            "doseQuantity" => array(
                                                                "value" => $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue,
                                                                "unit" => $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit,
                                                                "system" => "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                                                                "code" => $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        );
                                        $JsonEncode = json_encode($KirimData);
                                        $response=CreatMedicationDispense($baseurl_satusehat,$JsonEncode,$Token);
                                        if(empty($response)){
                                            echo '<span class="text-danger">Tidak Ada Response Dari Platform Satu Sehat</span>';
                                        }else{
                                            $JsonData =json_decode($response, true);
                                            if(empty($JsonData['id'])){
                                                $RawDikirim = json_encode($KirimData, JSON_PRETTY_PRINT);
                                                // Decode JSON
                                                $RawDiterima = json_decode($response, true);
                                                // Encode kembali dengan opsi JSON_PRETTY_PRINT
                                                $RawDiterima = json_encode($RawDiterima, JSON_PRETTY_PRINT);
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mengirim Data Ke Satu Sehat</span><br>';
                                                echo 'Data Yang Dikirim <textarea class="form-control">'.$RawDikirim.'</textarea><br>';
                                                echo 'Response Yang Diterima <textarea class="form-control">'.$RawDiterima.'</textarea><br>';
                                            }else{
                                                $id_medication_dis=$JsonData['id'];
                                                //Simpan Data Ke Database
                                                $entry="INSERT INTO kunjungan_med_dis (
                                                    id_kunjungan,
                                                    id_pasien,
                                                    id_resep,
                                                    id_item_resep,
                                                    id_medication_dis,
                                                    raw_med_dis,
                                                    id_akses,
                                                    updatetime
                                                ) VALUES (
                                                    '$id_kunjungan',
                                                    '$id_pasien',
                                                    '$id_resep',
                                                    '$id_item_resep',
                                                    '$id_medication_dis',
                                                    '$JsonEncode',
                                                    '$SessionIdAkses',
                                                    '$updatetime'
                                                )";
                                                $hasil=mysqli_query($Conn, $entry);
                                                if($hasil){
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Creat Medication Dispense","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        echo '<span class="text-success" id="NotifikasiTambahMedicationDispenseBerhasil">Success</span>';
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