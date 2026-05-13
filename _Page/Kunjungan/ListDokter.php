<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$page   = isset($_POST['page']) ? (int) $_POST['page'] : 1;

$limit  = 10;
$offset = ($page - 1) * $limit;

// Query utama
$sql = "SELECT id_dokter, kode, nama FROM dokter WHERE (nama LIKE CONCAT('%', ?, '%') OR kode LIKE CONCAT('%', ?, '%')) AND status=1 ORDER BY nama ASC LIMIT ?, ?";
$stmt = mysqli_prepare($Conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "ssii",
    $search,
    $search,
    $offset,
    $limit
);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {

    $data[] = [
        "id"    => $row['id_dokter'],
        "text"  => $row['nama'],
        "kode"  => $row['kode'],
        "nama"  => $row['nama']
    ];
}

mysqli_stmt_close($stmt);

// Hitung total
$sql_count = "SELECT COUNT(*) as total FROM dokter WHERE (nama LIKE CONCAT('%', ?, '%') OR kode LIKE CONCAT('%', ?, '%')) AND status=1";

$stmt_count = mysqli_prepare($Conn, $sql_count);

mysqli_stmt_bind_param(
    $stmt_count,
    "ss",
    $search,
    $search
);

mysqli_stmt_execute($stmt_count);

$result_count = mysqli_stmt_get_result($stmt_count);

$row_count = mysqli_fetch_assoc($result_count);

$total = $row_count['total'];

mysqli_stmt_close($stmt_count);

// Response
echo json_encode([
    "results" => $data,
    "pagination" => [
        "more" => ($offset + $limit) < $total
    ]
]);
?>