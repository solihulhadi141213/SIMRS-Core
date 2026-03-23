<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(empty($_POST['id_item_resep'])){
        $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
        $identifier_use="official";
        $identifier_value="";
        $medicationReference_reference="";
        $medicationReference_display="";
         //Parameter
        $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
        $identifier_use="official";
        $identifier_value="";
        $medicationReference_reference="";
        $medicationReference_display="";
        $IdMedicationRequest="MedicationRequest/";
        $QuantityValue="";
        $QuantityUnit="";
        //Sequence Text
        $MedicationDispenseDosageInstructionSequence="";
        $MedicationDispenseDosageInstructionText="";
        //Timing Repeat
        $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
        $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
        $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
        //Dose And Rate
        $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
        $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
        $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
    }else{
        $id_item_resep=$_POST['id_item_resep'];
        //Explode
        $explode=explode('-',$id_item_resep);
        if(empty($explode['0'])){
            $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
            $identifier_use="official";
            $identifier_value="";
            $medicationReference_reference="";
            $medicationReference_display="";
            //Parameter
            $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
            $identifier_use="official";
            $identifier_value="";
            $medicationReference_reference="";
            $medicationReference_display="";
            $IdMedicationRequest="MedicationRequest/";
            $QuantityValue="";
            $QuantityUnit="";
            $expectedSupplyDurationValue="";
            $expectedSupplyDurationUnit="";
            $expectedSupplyDurationCode="";
            //Sequence Text
            $MedicationDispenseDosageInstructionSequence="";
            $MedicationDispenseDosageInstructionText="";
            //Timing Repeat
            $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
            $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
            $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
            //Dose And Rate
            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
        }else{
            if(empty($explode['1'])){
                $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
                $identifier_use="official";
                $identifier_value="";
                $medicationReference_reference="";
                $medicationReference_display="";
                //Parameter
                $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
                $identifier_use="official";
                $identifier_value="";
                $medicationReference_reference="";
                $medicationReference_display="";
                $IdMedicationRequest="MedicationRequest/";
                $QuantityValue="";
                $QuantityUnit="";
                $expectedSupplyDurationValue="";
                $expectedSupplyDurationUnit="";
                $expectedSupplyDurationCode="";
                //Sequence Text
                $MedicationDispenseDosageInstructionSequence="";
                $MedicationDispenseDosageInstructionText="";
                //Timing Repeat
                $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
                $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
                $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
                //Dose And Rate
                $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
                $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
                $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
            }else{
                if(empty($explode['2'])){
                    $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
                    $identifier_use="official";
                    $identifier_value="";
                    $medicationReference_reference="";
                    $medicationReference_display="";
                    //Parameter
                    $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
                    $identifier_use="official";
                    $identifier_value="";
                    $medicationReference_reference="";
                    $medicationReference_display="";
                    $IdMedicationRequest="MedicationRequest/";
                    $QuantityValue="";
                    $QuantityUnit="";
                    $expectedSupplyDurationValue="";
                    $expectedSupplyDurationUnit="";
                    $expectedSupplyDurationCode="";
                    //Sequence Text
                    $MedicationDispenseDosageInstructionSequence="";
                    $MedicationDispenseDosageInstructionText="";
                    //Timing Repeat
                    $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
                    $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
                    $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
                    //Dose And Rate
                    $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
                    $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
                    $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
                }else{
                    $id_resep=$explode['0'];
                    $id=$explode['1'];
                    $id_obat=$explode['2'];
                    //Buka id medication obat
                    $id_medication=getDataDetail($Conn,'obat_medication','id_obat',$id_obat,'id_medication');
                    $raw_medication=getDataDetail($Conn,'obat_medication','id_obat',$id_obat,'raw_medication');
                    //Buka Data Raw
                    if(!empty($raw_medication)){
                        $JsonData =json_decode($raw_medication, true);
                        $MedicationCodeCoding=$JsonData['code']['coding'];
                        $MedicationCodeCodingSystem=$MedicationCodeCoding['0']['system'];
                        $MedicationCodeCodingCode=$MedicationCodeCoding['0']['code'];
                        $MedicationCodeCodingDisplay=$MedicationCodeCoding['0']['display'];
                        $id_medication_req=getDataDetail($Conn,'kunjungan_med_req','id_resep',$id_resep,'id_medication_req');
                        if(empty($id_medication_req)){
                            $QuantityValue="0";
                            $QuantityUnit="None";
                            $expectedSupplyDurationValue="";
                            $expectedSupplyDurationUnit="";
                            $expectedSupplyDurationCode="";
                            //Sequence Text
                            $MedicationDispenseDosageInstructionSequence="";
                            $MedicationDispenseDosageInstructionText="";
                            //Timing Repeat
                            $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
                            $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
                            $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
                            //Dose And Rate
                            $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
                            $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
                        }else{
                            $raw_med_req=getDataDetail($Conn,'kunjungan_med_req','id_medication_req',$id_medication_req,'raw_med_req');
                            if(empty($raw_med_req)){
                                $QuantityValue="0";
                                $QuantityUnit="None";
                                $expectedSupplyDurationValue="";
                                $expectedSupplyDurationUnit="";
                                $expectedSupplyDurationCode="";
                                //Sequence Text
                                $MedicationDispenseDosageInstructionSequence="";
                                $MedicationDispenseDosageInstructionText="";
                                //Timing Repeat
                                $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
                                $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
                                $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
                                //Dose And Rate
                                $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
                                $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
                                $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
                            }else{
                                $JsonDataMedReq =json_decode($raw_med_req, true);
                                $QuantityValue=$JsonDataMedReq['dispenseRequest']['quantity']['value'];
                                $QuantityUnit=$JsonDataMedReq['dispenseRequest']['quantity']['unit'];
                                //expectedSupplyDuration
                                $expectedSupplyDurationValue=$JsonDataMedReq['dispenseRequest']['expectedSupplyDuration']['value'];
                                $expectedSupplyDurationUnit=$JsonDataMedReq['dispenseRequest']['expectedSupplyDuration']['unit'];
                                $expectedSupplyDurationCode=$JsonDataMedReq['dispenseRequest']['expectedSupplyDuration']['code'];
                                //dosage Instruction
                                $MedicationDispenseDosageInstructionSequence=$JsonDataMedReq['dosageInstruction']['0']['sequence'];
                                $MedicationDispenseDosageInstructionText=$JsonDataMedReq['dosageInstruction']['0']['text'];
                                //Timing Repeat
                                $MedicationDispenseDosageInstructionTimingRepeatFrequency=$JsonDataMedReq['dosageInstruction']['0']['timing']['repeat']['frequency'];
                                $MedicationDispenseDosageInstructionTimingRepeatPeriod=$JsonDataMedReq['dosageInstruction']['0']['timing']['repeat']['period'];
                                $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit=$JsonDataMedReq['dosageInstruction']['0']['timing']['repeat']['periodUnit'];
                                //Dose And Rate
                                $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode=$JsonDataMedReq['dosageInstruction']['0']['doseAndRate']['0']['type']['coding']['0']['code'];
                                $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue=$JsonDataMedReq['dosageInstruction']['0']['doseAndRate']['0']['doseQuantity']['value'];
                                $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit=$JsonDataMedReq['dosageInstruction']['0']['doseAndRate']['0']['doseQuantity']['unit'];
                            }
                            // $QuantityValue="0";
                            // $QuantityUnit=$raw_med_req;
                        }
                        //Parameter
                        $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
                        $identifier_use="official";
                        $identifier_value="$id";
                        $medicationReference_reference="$id_medication";
                        $medicationReference_display="$MedicationCodeCodingDisplay";
                        $IdMedicationRequest="MedicationRequest/$id_medication_req";
                        $QuantityValue=$QuantityValue;
                        $QuantityUnit=$QuantityUnit;
                    }else{
                        $JsonData ="";
                        $MedicationCodeCoding="";
                        $MedicationCodeCodingSystem="";
                        $MedicationCodeCodingCode="";
                        $MedicationCodeCodingDisplay="";
                        //Parameter
                        $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
                        $identifier_use="official";
                        $identifier_value="";
                        $medicationReference_reference="";
                        $medicationReference_display="";
                        $IdMedicationRequest="MedicationRequest/";
                        $QuantityValue="";
                        $QuantityUnit="";
                        $expectedSupplyDurationValue="";
                        $expectedSupplyDurationUnit="";
                        $expectedSupplyDurationCode="";
                       //Sequence Text
                        $MedicationDispenseDosageInstructionSequence="";
                        $MedicationDispenseDosageInstructionText="";
                        //Timing Repeat
                        $MedicationDispenseDosageInstructionTimingRepeatFrequency="";
                        $MedicationDispenseDosageInstructionTimingRepeatPeriod="";
                        $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit="";
                        //Dose And Rate
                        $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode="";
                        $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue="";
                        $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit="";
                    }
                }
            }
        }
    }
    //Membuat json
    $data = array(
        "identifier_system" => $identifier_system,
        "identifier_use" => $identifier_use,
        "identifier_value" => $identifier_value,
        "medicationReference_reference" => $medicationReference_reference,
        "medicationReference_display" => $medicationReference_display,
        "QuantityValue" => $QuantityValue,
        "QuantityUnit" => $QuantityUnit,
        "IdMedicationRequest" => $IdMedicationRequest,
        "expectedSupplyDurationValue" => $expectedSupplyDurationValue,
        "expectedSupplyDurationUnit" => $expectedSupplyDurationUnit,
        "expectedSupplyDurationCode" => $expectedSupplyDurationCode,
        "MedicationDispenseDosageInstructionSequence" => $MedicationDispenseDosageInstructionSequence,
        "MedicationDispenseDosageInstructionText" => $MedicationDispenseDosageInstructionText,
        "MedicationDispenseDosageInstructionTimingRepeatFrequency" => $MedicationDispenseDosageInstructionTimingRepeatFrequency,
        "MedicationDispenseDosageInstructionTimingRepeatPeriod" => $MedicationDispenseDosageInstructionTimingRepeatPeriod,
        "MedicationDispenseDosageInstructionTimingRepeatPeriodUnit" => $MedicationDispenseDosageInstructionTimingRepeatPeriodUnit,
        "MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode" => $MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode,
        "MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue" => $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue,
        "MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit" => $MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit
    );
    $jsonString = json_encode($data);
    echo $jsonString;
?>