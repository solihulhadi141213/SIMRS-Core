<?php
    //koneksi
    include "../../_Config/Connection.php";
    //POST data from form
    if(empty($_POST['poliklinik'])){
        $poliklinik="";
        echo '<option>Isi Poliklinik Terlebih Dulu</option>';
    }else{
        if(empty($_POST['dokter'])){
            $dokter="";
            echo '<option>Isi Dokter Terlebih Dulu</option>';
        }else{
            if(empty($_POST['tanggal'])){
                $tanggal="";
                echo '<option>Isi Tanggal Terlebih Dulu</option>';
            }else{
                $poliklinik=$_POST['poliklinik'];
                $dokter=$_POST['dokter'];
                $tanggal=$_POST['tanggal'];
                $day = date('D', strtotime($tanggal));
                $dayList = array(
                    'Sun' => 'Minggu',
                    'Mon' => 'Senin',
                    'Tue' => 'Selasa',
                    'Wed' => 'Rabu',
                    'Thu' => 'Kamis',
                    'Fri' => 'Jumat',
                    'Sat' => 'Sabtu'
                );
                $NamaHari=$dayList[$day];
                echo '<option value="">Pilih</option>';
                //get data from database jadwal_dokter 
                $sql = "SELECT * FROM jadwal_dokter WHERE id_poliklinik='$poliklinik' AND id_dokter='$dokter' AND hari='$NamaHari'";
                $result = mysqli_query($Conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    $id_jadwal=$row['id_jadwal'];
                    $jam=$row['jam'];
                    echo '<option value="'.$jam.'">'.$NamaHari.', '.$jam.'</option>';
                }
            }
        }

    }
?>