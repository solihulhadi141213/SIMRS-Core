<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_resep tidak boleh kosong
    if(empty($_POST['id_resep'])){
        echo '<small class="text-danger">ID Resep tidak boleh kosong</small>';
    }else{
        //Validasi signature tidak boleh kosong
        if(empty($_POST['signature'])){
            echo '<small class="text-danger">Tanda Tangan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_resep=$_POST['id_resep'];
            $data_uri=$_POST['signature'];
            $encoded_image = explode(",", $data_uri)[1];
            $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
                ttd_dokter='$encoded_image'
            WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
            if($UpdateResep){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Tanda Tangan Resep","Kunjungan",$SessionIdAkses);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiTtdDokterResepBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update tanda tangan resep!</span><br>';
            }
        }
    }
?>
