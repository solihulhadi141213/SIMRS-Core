<?php
    header('Content-Type: text/html; charset=utf-8');

    // Koneksi
    include "../../_Config/Connection.php";

    // Validasi input
    if (empty($_POST['regency'])) {
        echo '<option value="">Pilih</option>';
        exit;
    }

    $regency = $_POST['regency'];

    // Prepared Statement: ambil kecamatan berdasarkan kabupaten/kota.
    $stmt = mysqli_prepare($Conn, "
        SELECT DISTINCT subdistrict
        FROM wilayah
        WHERE regency = ?
        AND subdistrict IS NOT NULL
        AND subdistrict != ''
        ORDER BY subdistrict ASC
    ");
    mysqli_stmt_bind_param($stmt, "s", $regency);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    // Default option
    echo '<option value="">Pilih</option>';

    // Loop hasil
    while ($row = mysqli_fetch_assoc($query)) {

        $subdistrict = htmlspecialchars($row['subdistrict'], ENT_QUOTES, 'UTF-8');

        echo '<option value="'.$subdistrict.'">'.$subdistrict.'</option>';
    }
?>