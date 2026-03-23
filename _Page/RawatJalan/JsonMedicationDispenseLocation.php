<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['MedicationDispenseLocation'])){
        $MedicationDispenseLocationReferense="Location/";
        $MedicationDispenseLocationDisplay="";
    }else{
        $MedicationDispenseLocation=$_POST['MedicationDispenseLocation'];
        //Buka data location
        $NamaLocation=getDataDetail($Conn,'referensi_location','id_location',$MedicationDispenseLocation,'nama');
        if(empty($NamaLocation)){
            $MedicationDispenseLocationReferense="Location/";
            $MedicationDispenseLocationDisplay="";
        }else{
            $MedicationDispenseLocationReferense="Location/$MedicationDispenseLocation";
            $MedicationDispenseLocationDisplay="$NamaLocation";
        }
    }
    //Membuat json
    $data = array(
        "MedicationDispenseLocationReferense" => $MedicationDispenseLocationReferense,
        "MedicationDispenseLocationDisplay" => $MedicationDispenseLocationDisplay
    );
    $jsonString = json_encode($data);
    echo $jsonString;
?>