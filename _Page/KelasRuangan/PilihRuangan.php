<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //menangkpa kelas dan ruangan
    if(!empty($_POST['PilihKelas'])){
        $kelas=$_POST['PilihKelas'];
        //Menampilkan opsi ruangan
        echo '<option value="">Pilih</option>';
        $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas' ORDER BY kelas ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_ruang_rawat = $data['id_ruang_rawat'];
            $kelas = $data['kelas'];
            $ruangan = $data['ruangan'];
            $updatetime = $data['updatetime'];
            echo '<option value="'.$ruangan.'">'.$ruangan.'</option>';
        }
    }else{
        echo '<option>None</option>';
    }
?>