<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_antrian
    if(empty($_POST['id_operasi'])){
        $id_operasi=$_POST['id_operasi'];
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Operasi Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_operasi=$_POST['id_operasi'];
        $Update = mysqli_query($Conn,"UPDATE jadwal_operasi SET 
            terlaksana='0'
        WHERE id_operasi='$id_operasi'") or die(mysqli_error($Conn)); 
        if($Update){
            //Catat Log Aktivitas
            $WaktuLog=date('Y-m-d H:i');
            $nama_log="Undo Jadwal Operasi Selesai Berhasil";
            $kategori_log="Jadwal Operasi";
            include "../../_Config/Log.php";
            echo '<span class="text-success" id="NotifikasiUndoJadwalOperasiBerhasil">Undo Jadwal Berhasil</span>';
        }else{
            echo '<span class="text-danger" id="NotifikasiUndoJadwalOperasiBerhasil">Undo Jadwal Operasi Gagal</span>';
        }
    }
?>
