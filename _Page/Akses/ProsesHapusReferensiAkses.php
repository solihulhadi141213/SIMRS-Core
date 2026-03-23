<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_akses_ref'])){
        echo '<i id="Notifikasi">ID Referensi Tidak Boleh Kosong!</i>';
    }else{
        $id_akses_ref=$_POST['id_akses_ref'];
        //Proses hapus data
        $HapusReferensi = mysqli_query($Conn, "DELETE FROM akses_ref WHERE id_akses_ref='$id_akses_ref'") or die(mysqli_error($Conn));
        if($HapusReferensi) {
            $HapusAcc = mysqli_query($Conn, "DELETE FROM akses_acc WHERE id_akses_ref='$id_akses_ref'") or die(mysqli_error($Conn));
            if($HapusAcc) {
                $JsonLogFile="../../_Page/Log/Log.json";
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Referensi Fitur","Akses",$SessionIdAkses,$JsonLogFile);
                if($MenyimpanLog=="Berhasil"){
                    // $_SESSION['NotifikasiSwal']="Hapus Referensi Berhasil";
                    echo '<span class="text-success" id="NotifikasiHapusReferensiBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Hapus ACC Akses Gagal!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Referensi Akses Gagal!</span>';
        }
    }
?>