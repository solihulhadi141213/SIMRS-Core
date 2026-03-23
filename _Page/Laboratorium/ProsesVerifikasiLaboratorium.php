<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_permintaan'])){
        echo '<span class="text-danger">ID Permintaan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['signature'])){
            echo '<span class="text-danger">Tanda Tangan Tidak Boleh Kosong</span>';
        }else{
            $id_permintaan=$_POST['id_permintaan'];
            if(empty($_POST['SignatureName'])){
                $SignatureName="";
            }else{
                $SignatureName=$_POST['SignatureName'];
            }
            $signature=$_POST['signature'];
            $encoded_image = explode(",", $signature)[1];
            $UpdatePermintaan= mysqli_query($Conn,"UPDATE laboratorium_pemeriksaan SET 
                $SignatureName='$encoded_image'
            WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
            if($UpdatePermintaan){
                //menyimpan Log
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Verifikasi Permintaan Laboratorium","Laboratorium",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    $_SESSION['NotifikasiSwal']="Verifikasi Permintaan Laboratorium Berhasil";
                    echo '<span class="text-success" id="NotifikasiVerifikasiLaboratoriumBerhasil">Success</span>';
                    echo 'Back To " <span class="text-success" id="UrlBack">index.php?Page=Laboratorium&Sub=DetailPermintaanLab&id='.$id_permintaan.'</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
            }
        }
    }
?>