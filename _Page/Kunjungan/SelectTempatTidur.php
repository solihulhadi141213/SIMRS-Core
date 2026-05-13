<?php
    // Koneksi
    include "../../_Config/Connection.php";

    if(empty($_POST['id_ruang_rawat'])){
        echo '<option value="">Pilih</option>';
        exit;
    }

    // Form Default
    echo '<option value="">Pilih</option>';
    
    // Buat Variabel id_ruang_rawat
    $id_ruang_rawat = $_POST['id_ruang_rawat'];

    // Tampilkan List Ruangan
    $sql_tt = "SELECT * FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND status=1 ORDER BY tempat_tidur ASC";
    $stmt_tt = mysqli_prepare($Conn, $sql_tt);
    if ($stmt_tt) {
        mysqli_stmt_execute($stmt_tt);
        $result_tt = mysqli_stmt_get_result($stmt_tt);
        while ($data_tt = mysqli_fetch_assoc($result_tt)) {
            $id_tempat_tidur_list = $data_tt['id_tempat_tidur'];
            $tempat_tidur_list    = $data_tt['tempat_tidur'];
            
            echo '<option value="'.$id_tempat_tidur_list.'">'.$tempat_tidur_list.'</option>';
        }
        mysqli_stmt_close($stmt_tt);
    } else {
        echo '<option value="">Gagal memuat data</option>';
    }
?>