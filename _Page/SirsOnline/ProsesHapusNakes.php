<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['id_nakes'])){
        echo '<span class="text-danger">ID PCR Nakes Tidak Boleh Kosong</span>';
    }else{
        $id_nakes=$_POST['id_nakes'];
        //Hapus Di database
        $HapusNakes = mysqli_query($Conn, "DELETE FROM nakes WHERE id_nakes='$id_nakes'") or die(mysqli_error($Conn));
        if($HapusNakes) {
            //Hapus Data PCR Nakes
            $HapusPcrNakes = mysqli_query($Conn, "DELETE FROM nakes_pcr WHERE id_nakes='$id_nakes'") or die(mysqli_error($Conn));
            if($HapusPcrNakes){
                //Hapus Data Nakes Terinfeksi
                $HapusNakesTerinfeksi = mysqli_query($Conn, "DELETE FROM nakes_terinfeksi WHERE id_nakes='$id_nakes'") or die(mysqli_error($Conn));
                if($HapusNakesTerinfeksi){
                    echo '<span class="text-success" id="NotifikasiHapusNakesBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Nakes Terinfeksi</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Hasil Pemeriksaan PCR Nakes</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Nakes</span>';
        }
    }
?>