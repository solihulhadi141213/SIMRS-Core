<?php
    header('Content-Type: text/html; charset=utf-8');

    // Koneksi
    include "../../_Config/Connection.php";

    // Validasi input
    if (empty($_POST['subdistrict'])) {
        echo '<option value="">Pilih</option>';
        exit;
    }

    // Ambil kecamatan
    $subdistrict = mysqli_real_escape_string($Conn, $_POST['subdistrict']);

    // Query desa / kelurahan unik
    $query = mysqli_query($Conn, "
        SELECT DISTINCT village, tipe_level4
        FROM wilayah
        WHERE subdistrict = '$subdistrict'
        AND village IS NOT NULL
        AND village != ''
        ORDER BY village ASC
    ");

    // Default option
    echo '<option value="">Pilih</option>';

    // Loop hasil
    while ($row = mysqli_fetch_assoc($query)) {

        $village = htmlspecialchars($row['village'], ENT_QUOTES, 'UTF-8');
        $tipe    = htmlspecialchars($row['tipe_level4'], ENT_QUOTES, 'UTF-8');

        // Label tampil
        $label = $village;

        if (!empty($tipe)) {
            $label = $tipe . ' ' . $village;
        }

        echo '<option value="'.$village.'">'.$village.'</option>';
    }
?>