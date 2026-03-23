<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['id_nakes_pcr'])){
        echo '<span class="text-danger">ID PCR Nakes Tidak Boleh Kosong</span>';
    }else{
        $id_nakes_pcr=$_POST['id_nakes_pcr'];
        //Hapus Di database
        $HapusPcrNakes = mysqli_query($Conn, "DELETE FROM nakes_pcr WHERE id_nakes_pcr='$id_nakes_pcr'") or die(mysqli_error($Conn));
        if($HapusPcrNakes) {
            //Hapus Nakes Terinfeksi
            $HapusNakesTerinfeksi = mysqli_query($Conn, "DELETE FROM nakes_terinfeksi WHERE id_nakes_pcr='$id_nakes_pcr'") or die(mysqli_error($Conn));
            if($HapusNakesTerinfeksi){
                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Hapus Hasil PCR nakes","PCR Nakes",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiHapusHasilPcrNakesBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Nakes Terinfeksi</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus PCR Nakes</span>';
        }
    }
?>