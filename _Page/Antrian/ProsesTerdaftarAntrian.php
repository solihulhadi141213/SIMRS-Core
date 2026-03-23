<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_antrian
    if(empty($_POST['id_antrian'])){
        $id_antrian=$_POST['id_antrian'];
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Antrian Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_antrian=$_POST['id_antrian'];
        $Update = mysqli_query($Conn,"UPDATE antrian SET 
            status='Terdaftar'
        WHERE id_antrian='$id_antrian'") or die(mysqli_error($Conn)); 
        if($Update){
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Update Pendaftaran Antrian Berhasil";
            $kategori_log="Antrian";
            include "../../_Config/Log.php";
            echo '<span class="text-success" id="NotifikasiTerdaftarAntrianBerhasil">Update Terdaftar Antrian Berhasil</span>';
        }else{
            echo '<span class="text-danger" id="NotifikasiTerdaftarAntrianBerhasil">Update Terdaftar Antrian Gagal</span>';
        }
    }
?>
