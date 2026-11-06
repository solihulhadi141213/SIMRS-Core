<?php
// ==========================================
// Endpoint GetPasien.php untuk Select2 AJAX
// ==========================================

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";

header('Content-Type: application/json');

$keyword = $_REQUEST['keyword'] ?? '';
$page    = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$limit   = 10;
$offset  = ($page - 1) * $limit;

$searchTerm = "%" . trim($keyword) . "%";

// 1. Hitung total data untuk pagination Select2
$countSql = "SELECT COUNT(*) as total FROM pasien WHERE nama LIKE ? OR nik LIKE ? OR no_bpjs LIKE ?";
$stmtCount = mysqli_prepare($Conn, $countSql);
if ($stmtCount) {
    mysqli_stmt_bind_param($stmtCount, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmtCount);
    $totalResult = mysqli_stmt_get_result($stmtCount);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalData = $totalRow['total'] ?? 0;
    mysqli_stmt_close($stmtCount);
} else {
    $totalData = 0;
}

// 2. Ambil data pasien dengan limit dan offset
$dataSql = "SELECT id_pasien, nama, nik, no_bpjs, tanggal_lahir FROM pasien WHERE nama LIKE ? OR nik LIKE ? OR no_bpjs LIKE ? ORDER BY nama ASC LIMIT ? OFFSET ?";
$stmtData = mysqli_prepare($Conn, $dataSql);

if ($stmtData) {
    mysqli_stmt_bind_param($stmtData, "sssii", $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
    mysqli_stmt_execute($stmtData);
    $result = mysqli_stmt_get_result($stmtData);

    $results = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = [
            'id'        => $row['id_pasien'], // Nilai value yang akan tersimpan saat form disubmit
            'id_pasien' => $row['id_pasien'],
            'nama'      => $row['nama'],
            'nik'       => !empty($row['nik']) ? $row['nik'] : '-',
            'no_bpjs'   => !empty($row['no_bpjs']) ? $row['no_bpjs'] : '-'
        ];
    }
    mysqli_stmt_close($stmtData);
} else {
    $results = [];
}

$more = ($offset + $limit) < $totalData;

$response = [
    'results'    => $results,
    'pagination' => [
        'more' => $more
    ]
];

echo json_encode($response);
?>