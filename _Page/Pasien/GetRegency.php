<?php
header('Content-Type: text/html; charset=utf-8');

// Koneksi
include "../../_Config/Connection.php";

// Validasi input
if (empty($_POST['province'])) {
    echo '<option value="">Pilih</option>';
    exit;
}

// Ambil province
$province = mysqli_real_escape_string($Conn, $_POST['province']);

// Query kabupaten/kota unik
$query = mysqli_query($Conn, "
    SELECT DISTINCT regency, tipe_level2
    FROM wilayah
    WHERE province = '$province'
    AND regency IS NOT NULL
    AND regency != ''
    ORDER BY regency ASC
");

// Default option
echo '<option value="">Pilih</option>';

// Loop hasil
while ($row = mysqli_fetch_assoc($query)) {

    $regency = htmlspecialchars($row['regency'], ENT_QUOTES, 'UTF-8');
    $tipe    = htmlspecialchars($row['tipe_level2'], ENT_QUOTES, 'UTF-8');

    // Format label
    $label = $regency;

    echo '<option value="'.$regency.'">'.$regency.'</option>';
}
?>