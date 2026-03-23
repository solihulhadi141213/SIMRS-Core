<?php
    //Koneksi
    include "../../_Config/Connection.php";

    //tangkap data
    if(empty($_POST['kelas'])){
        $kelas    = "";
    }else{
        $kelas    = $_POST['kelas'];
    }
    echo '<option value="">Pilih</option>';
    // Ambil data kelas
    $sql = "SELECT ruangan FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas' ORDER BY ruangan ASC";
    $result = $Conn->query($sql);

    // Loop hasil query dan tambahkan ke variabel
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ruangan = htmlspecialchars($row['ruangan'], ENT_QUOTES, 'UTF-8');
            echo '<option value="'.$ruangan.'">'.$ruangan.'</option>';
        }
    }
?>