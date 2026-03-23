<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_resep'])){
        echo '<span class="text-danger">ID Resep Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['StatusResep'])){
            echo '<span class="text-danger">Status Resep Tidak Boleh Kosong!</span>';
        }else{
            //Membuat Variabel
            $id_resep=$_POST['id_resep'];
            $StatusResep=$_POST['StatusResep'];
            //Simpan Data Ke Database
            $Update= mysqli_query($Conn,"UPDATE resep SET 
                status='$StatusResep'
            WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
            if($Update){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Ubah Status Resep","Kunjungan",$SessionIdAkses);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiStatusResepBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Status Resep</span>';
            }
        }
    }
?>