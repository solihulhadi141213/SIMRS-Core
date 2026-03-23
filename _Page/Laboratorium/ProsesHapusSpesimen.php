<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_laboratorium_sample'])){
        echo '<span class="text-danger">ID Spesimen Tidak Boleh Kosong</span>';
    }else{
        $id_laboratorium_sample=$_POST['id_laboratorium_sample'];
        $HapusSpesimen = mysqli_query($Conn, "DELETE FROM laboratorium_sample WHERE id_laboratorium_sample='$id_laboratorium_sample'") or die(mysqli_error($Conn));
        if ($HapusSpesimen) {
            $HapusHasilPemeriksaan = mysqli_query($Conn, "DELETE FROM laboratorium_rincian WHERE id_laboratorium_sample='$id_laboratorium_sample'") or die(mysqli_error($Conn));
            if($HapusHasilPemeriksaan) {
                $_SESSION['NotifikasiSwal']="Hapus Spesimen Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusSpesiemenBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Parameter!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Parameter!</span>';
        }
    }
?>