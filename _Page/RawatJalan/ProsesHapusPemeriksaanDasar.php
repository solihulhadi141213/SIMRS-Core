<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak dapat ditangkap pada saat proses hapus data</span>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $gambar_anatomi=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'gambar_anatomi');
        $JsonGambarAnatomi =json_decode($gambar_anatomi, true);
        if(!empty($JsonGambarAnatomi)){
            if(!empty(count($JsonGambarAnatomi))){
                $JumlahDataLama=count($JsonGambarAnatomi);
                for($i=0; $i<$JumlahDataLama; $i++){
                    if(!empty($JsonGambarAnatomi[$i]["ImageAnatomi"])){
                        $ImageAnatomi=$JsonGambarAnatomi[$i]["ImageAnatomi"];
                        $UrlFile="../../assets/images/Anatomi/Hasil/$ImageAnatomi";
                        unlink($UrlFile);
                    }
                }
            }
        }
        $HapusPemeriksaanDasar = mysqli_query($Conn, "DELETE FROM  pemeriksaan_fisik WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($HapusPemeriksaanDasar){
            echo '<span id="NotifikasiHapusPemeriksaanDasarBerhasil" class="text-success">Success</span>';
        }else{
            echo '<span class="text-danger">Proses hapus gagal!!</span>';
        }
    }
?>