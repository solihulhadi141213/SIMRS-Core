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

$searchPattern = '%' . $search . '%';
$where = !empty($search)
    ? "WHERE unit_name LIKE ? OR unit_code LIKE ? OR unit_display LIKE ?"
    : "";

// Prepared Statement: count matching distinct units.
$stmtCount = mysqli_prepare($Conn, "
    SELECT COUNT(DISTINCT unit_name) as total
    FROM observation_reference
    $where
");
if (!empty($search)) {
    mysqli_stmt_bind_param($stmtCount, 'sss', $searchPattern, $searchPattern, $searchPattern);
}
mysqli_stmt_execute($stmtCount);
$queryCount = mysqli_stmt_get_result($stmtCount);
$dataCount = mysqli_fetch_assoc($queryCount);
$total = $dataCount['total'] ?? 0;
mysqli_stmt_close($stmtCount);

// Prepared Statement: fetch the requested unit page.
$stmt = mysqli_prepare($Conn, "
    SELECT DISTINCT
        unit_name,
        unit_code,
        unit_display,
        unit_system
    FROM observation_reference
    $where
    ORDER BY unit_name ASC
    LIMIT ? OFFSET ?
");
if (!empty($search)) {
    mysqli_stmt_bind_param($stmt, 'sssii', $searchPattern, $searchPattern, $searchPattern, $limit, $offset);
} else {
    mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
}
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

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
mysqli_stmt_close($stmt);

$response = [
    'results' => $results,
    'pagination' => [
        'more' => ($offset + $limit) < $total
    ]
];

echo json_encode($response);
exit();