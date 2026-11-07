<?php
header('Content-Type: text/html; charset=utf-8');

// Koneksi
include "../../_Config/Connection.php";

// Prepared Statement: ambil daftar provinsi unik.
$stmt = mysqli_prepare($Conn, "
    SELECT DISTINCT province 
    FROM wilayah 
    WHERE province IS NOT NULL 
    AND province != ''
    ORDER BY province ASC
");
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

// Default option
echo '<option value="">Pilih</option>';

// Loop data
while ($row = mysqli_fetch_assoc($query)) {
    $province = htmlspecialchars($row['province'], ENT_QUOTES, 'UTF-8');
    echo '<option value="'.$province.'">'.$province.'</option>';
}
?>