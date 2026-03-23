<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_akses_entitas'])){
        echo '<i id="Notifikasi">ID Entitas Tidak Boleh Kosong!</i>';
    }else{
        $id_akses_entitas=$_POST['id_akses_entitas'];
        //Proses hapus data
        $HapusEntitas = mysqli_query($Conn, "DELETE FROM akses_entitas WHERE id_akses_entitas='$id_akses_entitas'") or die(mysqli_error($Conn));
        if($HapusEntitas) {
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Entitas Akses","Akses",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusEntitasBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Referensi Akses Gagal!</span>';
        }
    }
?>