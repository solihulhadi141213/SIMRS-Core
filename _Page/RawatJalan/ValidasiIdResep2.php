<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(!empty($_POST['id_item_resep'])){
        $id_item_resep=$_POST['id_item_resep'];
        //Explode
        $explode=explode('-',$id_item_resep);
        if(empty($explode['0'])){
            echo '  <div class="row mb-3">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Resep Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
        }else{
            if(empty($explode['1'])){
                echo '  <div class="row mb-3">';
                echo '      <div class="col-md-12 text-center text-danger">';
                echo '          ID Item Tidak Boleh Kosong!';
                echo '      </div>';
                echo '  </div>';
            }else{
                if(empty($explode['2'])){
                    echo '  <div class="row mb-3">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          ID Obat Tidak Boleh Kosong!';
                    echo '      </div>';
                    echo '  </div>';
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
                    }else{
                        $JsonData ="";
                        $MedicationCodeCoding="";
                        $MedicationCodeCodingSystem="";
                        $MedicationCodeCodingCode="";
                        $MedicationCodeCodingDisplay="";
                    }
                    
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_system2">C.1.1.Identifier System (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_system2" id="identifier_system2" class="form-control" value="http://sys-ids.kemkes.go.id/prescription/'.$organization_id.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_use2">C.1.2.Identifier Use (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_use2" id="identifier_use2" class="form-control" value="official">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_value2">C.1.2.Identifier Value (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_value2" id="identifier_value2" class="form-control" value="'.$id.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="medicationReference_reference">C.2.Medication Reference</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="medicationReference_reference" id="medicationReference_reference" class="form-control" value="'.$id_medication.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="medicationReference_display">C.3.Medication Display</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="medicationReference_display" id="medicationReference_display" class="form-control" value="'.$MedicationCodeCodingDisplay.'">';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>