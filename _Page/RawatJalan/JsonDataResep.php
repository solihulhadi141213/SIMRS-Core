<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(empty($_POST['id_resep'])){
        $id_dokter="";
        $identifier_system="http://sys-ids.kemkes.go.id/prescription/";
        $identifier_use="official";
        $identifier_value="";
    }else{
        $GetIdResep=$_POST['id_resep'];
        //Buka Detail Resep
        $id_resep=getDataDetail($Conn,"resep",'id_resep',$GetIdResep,'id_resep');
        if(empty($id_resep)){
            $id_dokter="";
            $identifier_system="http://sys-ids.kemkes.go.id/prescription/";
            $identifier_use="official";
            $identifier_value="";
        }else{
            $id_dokter=getDataDetail($Conn,"resep",'id_resep',$GetIdResep,'id_dokter');
            $identifier_system="http://sys-ids.kemkes.go.id/prescription/$organization_id";
            $identifier_use="official";
            $identifier_value=$id_resep;
        }
    }
    //Membuat json
    $data = array(
        "id_dokter" => $id_dokter,
        "identifier_system" => $identifier_system,
        "identifier_use" => $identifier_use,
        "identifier_value" => $identifier_value
    );
    $jsonString = json_encode($data);
    echo $jsonString;
?>