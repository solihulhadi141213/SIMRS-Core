<?php
header('Content-Type: text/html; charset=utf-8');

// Koneksi
include "../../_Config/Connection.php";

// Validasi input
if (empty($_POST['province'])) {
    echo '<option value="">Pilih</option>';
    exit;
}

$province = $_POST['province'];

// Prepared Statement: ambil kabupaten/kota berdasarkan provinsi.
$stmt = mysqli_prepare($Conn, "
    SELECT DISTINCT regency, tipe_level2
    FROM wilayah
    WHERE province = ?
    AND regency IS NOT NULL
    AND regency != ''
    ORDER BY regency ASC
");
mysqli_stmt_bind_param($stmt, "s", $province);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

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