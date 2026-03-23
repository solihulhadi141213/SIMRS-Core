<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //id_pasien
    if(!empty($_POST['id_pasien'])){
        $id_pasien=$_POST['id_pasien'];
        $id_operasi=getDataDetail($Conn,'jadwal_operasi','id_pasien',$id_pasien,'id_operasi');
        if(empty($id_operasi)){
            echo '<li class="list-group-item">';
            echo '  <span class="text-danger">Tidak Ada Jadwal Yang Ditemukan Untuk Pasien Ini</span>';
            echo '</li>';
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM jadwal_operasi WHERE id_pasien='$id_pasien'");
            while ($data = mysqli_fetch_array($query)) {
                $id_operasi= $data['id_operasi'];
                $jenistindakan= $data['jenistindakan'];
                $tanggaloperasi= $data['tanggaloperasi'];
                $jamoperasi= $data['jamoperasi'];
                echo '<li class="list-group-item">';
                echo '  <input type="radio" class="form-check-input ml-1" name="PilihIdJadwalOperasi" id="PilihIdJadwalOperasi'.$id_operasi.'" value="'.$id_operasi.'">';
                echo '  <label class="form-check-label" for="PilihIdJadwalOperasi'.$id_operasi.'"> '.$jenistindakan.'<br><small>'.$tanggaloperasi.' '.$jamoperasi.'</small></label>';
                echo '</li>';
            }
        }
    }
?>