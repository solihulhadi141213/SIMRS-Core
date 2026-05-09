<?php
    header('Content-Type: text/html; charset=utf-8');

    // Koneksi
    include "../../_Config/Connection.php";

    // Validasi input
    if (empty($_POST['regency'])) {
        echo '<option value="">Pilih</option>';
        exit;
    }

    // Ambil data regency
    $regency = mysqli_real_escape_string($Conn, $_POST['regency']);

    // Query kecamatan unik
    $query = mysqli_query($Conn, "
        SELECT DISTINCT subdistrict
        FROM wilayah
        WHERE regency = '$regency'
        AND subdistrict IS NOT NULL
        AND subdistrict != ''
        ORDER BY subdistrict ASC
    ");

    // Default option
    echo '<option value="">Pilih</option>';

    // Loop hasil
    while ($row = mysqli_fetch_assoc($query)) {

        $subdistrict = htmlspecialchars($row['subdistrict'], ENT_QUOTES, 'UTF-8');

        echo '<option value="'.$subdistrict.'">'.$subdistrict.'</option>';
    }
?>