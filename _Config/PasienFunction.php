<?php
    function getDataPasien($SearchBy,$Keyword){
        include "Connection.php";
        if(empty($SearchBy)){
            $response="";
        }else{
            if(empty($Keyword)){
                $response="";
            }else{
                //Membuka Membuka Data Pasien
                $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE $SearchBy='$Keyword'")or die(mysqli_error($Conn));
                $response = mysqli_fetch_array($QryPasien);
                return $response;
            }
        }
    }
?>