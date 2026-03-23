<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(empty($_POST['MedicationDispensePerformer'])){
        $MedicationDispensePerformerReferense="Practitioner/";
        $MedicationDispensePerformerDisplay="";
    }else{
        $id_ihs_practitioner=$_POST['MedicationDispensePerformer'];
        //Buka data practitioner
        $NamaPractitioner=getDataDetail($Conn,'referensi_practitioner','id_ihs_practitioner',$id_ihs_practitioner,'nama');
        if(empty($NamaPractitioner)){
            $MedicationDispensePerformerReferense="Practitioner/";
            $MedicationDispensePerformerDisplay="";
        }else{
            $MedicationDispensePerformerReferense="Practitioner/$id_ihs_practitioner";
            $MedicationDispensePerformerDisplay=$NamaPractitioner;
        }
    }
    //Membuat json
    $data = array(
        "MedicationDispensePerformerReferense" => $MedicationDispensePerformerReferense,
        "MedicationDispensePerformerDisplay" => $MedicationDispensePerformerDisplay
    );
    $jsonString = json_encode($data);
    echo $jsonString;
?>