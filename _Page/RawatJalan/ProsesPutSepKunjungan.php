<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi SEP tidak boleh kosong
        if(empty($_POST['sep'])){
            $sep="";
        }else{
            $sep=$_POST['sep'];
        }
        //Variabel Lainnya
        $id_kunjungan=$_POST['id_kunjungan'];
        $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
            sep='$sep'
        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($UpdateKunjungan){
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update SEP","Kunjungan",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiPutSepBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update kunjungan!</span><br>';
        }
    }
?>
