<?php
include "../../_Config/Connection.php";

// Bersihkan output buffer untuk mencegah whitespace/error PHP merusak JSON
ob_clean(); 
header('Content-Type: application/json');

// Menggunakan $_GET karena menyesuaikan metode AJAX Select2
$search = $_GET['search'] ?? '';
$page   = (int)($_GET['page'] ?? 1);

$limit  = 20;
$offset = ($page - 1) * $limit;

$where = "";

if(!empty($search)){
    $search = mysqli_real_escape_string($Conn, $search);

    $where = "WHERE 
        unit_name LIKE '%$search%' OR
        unit_code LIKE '%$search%' OR
        unit_display LIKE '%$search%'
    ";
}

// Hitung total
$queryCount = mysqli_query($Conn, "
    SELECT COUNT(DISTINCT unit_name) as total
    FROM observation_reference
    $where
");

$dataCount = mysqli_fetch_assoc($queryCount);
$total = $dataCount['total'] ?? 0;

// Ambil data
$query = mysqli_query($Conn, "
    SELECT DISTINCT
        unit_name,
        unit_code,
        unit_display,
        unit_system
    FROM observation_reference
    $where
    ORDER BY unit_name ASC
    LIMIT $limit OFFSET $offset
");

$results = [];

if ($query) {
    while($row = mysqli_fetch_assoc($query)){
        $results[] = [
            'id' => $row['unit_name'],
            'text' => $row['unit_name'],
            'code' => $row['unit_code'],
            'display' => $row['unit_display'],
            'system' => $row['unit_system']
        ];
    }
}

$response = [
    'results' => $results,
    'pagination' => [
        'more' => ($offset + $limit) < $total
    ]
];

echo json_encode($response);
exit();