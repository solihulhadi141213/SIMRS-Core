<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";

// Default response
$response = [
    'status' => 'error',
    'message' => 'Gagal mengambil data',
    'metadata' => []
];

try {

    $query = "
        SELECT hari, COUNT(*) as total 
        FROM jadwal_dokter 
        GROUP BY hari
    ";

    // Prepared Statement: hitung jadwal per hari.
    $stmt = mysqli_prepare($Conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Default semua 0
    $metadata = [
        'Senin'  => 0,
        'Selasa' => 0,
        'Rabu'   => 0,
        'Kamis'  => 0,
        'Jumat'  => 0,
        'Sabtu'  => 0,
        'Minggu' => 0,
    ];

    while ($row = mysqli_fetch_assoc($result)) {
        $metadata[$row['hari']] = (int)$row['total'];
    }

    $response = [
        'status' => 'success',
        'message' => 'OK',
        'metadata' => $metadata
    ];

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);