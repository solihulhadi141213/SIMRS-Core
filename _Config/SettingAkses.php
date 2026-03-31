<?php
    function GetStatusAccess($Conn,$id_akses,$kode_fitur){
        //Cari id_akses_ref
        $QryRef= mysqli_query($Conn,"SELECT * FROM akses_ref WHERE kode='$kode_fitur'")or die(mysqli_error($Conn));
        $DataRef = mysqli_fetch_array($QryRef);
        if(empty($DataRef['id_akses_ref'])){
            $Response="";
        }else{
            $id_akses_ref=$DataRef['id_akses_ref'];
            //Buka Akses ACC
            $QryAcc= mysqli_query($Conn,"SELECT * FROM akses_acc WHERE id_akses_ref='$id_akses_ref' AND id_akses='$id_akses'")or die(mysqli_error($Conn));
            $DataAcc = mysqli_fetch_array($QryAcc);
            if(empty($DataAcc['status'])){
                $Response="";
            }else{
                $Response=$DataAcc['status'];
            }
        }
        return $Response;
    }
?>