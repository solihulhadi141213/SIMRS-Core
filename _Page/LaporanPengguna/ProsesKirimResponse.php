<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_laporan_pengguna'])){
        echo '<span class="text-danger">ID Laporan Pengguna Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['response'])){
            echo '<span class="text-danger">Isi Pesan Response Tidak Boleh Kosong</span>';
        }else{
            $id_laporan_pengguna=$_POST['id_laporan_pengguna'];
            $response=$_POST['response'];
            //Update Data
            $UpdateLaporanPengguna = mysqli_query($Conn,"UPDATE laporan_pengguna SET 
                response='$response'
            WHERE id_laporan_pengguna='$id_laporan_pengguna'") or die(mysqli_error($Conn)); 
            if($UpdateLaporanPengguna){
                $JsonLogFile="../../_Page/Log/Log.json";
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Kirim Response Laporan Pengguna","Monitoring",$SessionIdAkses,$JsonLogFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiKirimResponseBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update pengguna!</span>';
            }
        }
    }
?>