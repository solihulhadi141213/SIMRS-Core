<?php
    // Koneksi
    include "../../_Config/Connection.php";

    if(empty($_POST['id_kelas_rawat'])){
        echo '<option value="">Pilih</option>';
        exit;
    }

    // Form Default
    echo '<option value="">Pilih</option>';
    
    // Buat Variabel id_kelas_rawat
    $id_kelas_rawat = $_POST['id_kelas_rawat'];

    // Tampilkan List Ruangan
    $sql_ruang = "SELECT * FROM rr_ruang_rawat WHERE id_kelas_rawat='$id_kelas_rawat' AND status=1 ORDER BY ruang_rawat ASC";
    $stmt_ruang = mysqli_prepare($Conn, $sql_ruang);
    if ($stmt_ruang) {
        mysqli_stmt_execute($stmt_ruang);
        $result_ruangan = mysqli_stmt_get_result($stmt_ruang);
        while ($data_ruangan = mysqli_fetch_assoc($result_ruangan)) {
            $id_ruang_rawat_list = $data_ruangan['id_ruang_rawat'];
            $ruang_rawat_list    = $data_ruangan['ruang_rawat'];
            
            echo '<option value="'.$id_ruang_rawat_list.'">'.$ruang_rawat_list.'</option>';
        }
        mysqli_stmt_close($stmt_ruang);
    } else {
        echo '<option value="">Gagal memuat data</option>';
    }
?>