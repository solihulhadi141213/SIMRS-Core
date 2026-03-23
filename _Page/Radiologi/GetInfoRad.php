<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_rincian
    if(!empty($_POST['id_rincian'])){
        if(!empty($_POST['parameter'])){
            $id_rincian=$_POST['id_rincian'];
            $parameter=$_POST['parameter'];
            if(!empty(getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,$parameter))){
                $Hasil=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,$parameter);
                echo "$Hasil";
            }else{
                echo "Response None";
            }
        }else{
            echo "Parameter None";
        }
    }else{
        echo "ID Rincian None";
    }
?>