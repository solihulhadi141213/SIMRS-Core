<?php
include "../../_Config/Connection.php";

$search = $_POST['search'] ?? '';
$page   = $_POST['page'] ?? 1;

$limit = 20;
$offset = ($page - 1) * $limit;

// Query ambil data +1 untuk cek ada halaman berikutnya
$query = mysqli_query($Conn, "
    SELECT * FROM diagnosa 
    WHERE versi='ICD10'
    AND (
        kode LIKE '%$search%' 
        OR long_des LIKE '%$search%' 
        OR short_des LIKE '%$search%'
    )
    LIMIT $offset, " . ($limit + 1)
);

$result = [];
$count = 0;

while($row = mysqli_fetch_assoc($query)){
    if($count < $limit){
        $kode = $row['kode'];
        $deskripsi = $row['short_des'];

        $result[] = [
            'id' => "$kode|$deskripsi",
            'text' => "$kode | $deskripsi"
        ];
    }
    $count++;
}

// cek apakah masih ada data berikutnya
$more = $count > $limit;

echo json_encode([
    "results" => $result,
    "more" => $more
]);