<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";

// Validasi session
if (empty($SessionIdAkses)) {
    echo json_encode([
        "results" => [],
        "pagination" => ["more" => false]
    ]);
    exit;
}

// =========================
// INPUT
// =========================
$search = $_POST['search'] ?? '';
$page   = (int) ($_POST['page'] ?? 1);

$limit  = 10;
$offset = ($page - 1) * $limit;

// =========================
// WHERE
// =========================
$where = "";
$params = [];
$types = "";

if (!empty($search)) {
    $where = "WHERE nama LIKE ? OR email LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types = "ss";
}

// =========================
// COUNT
// =========================
$sql_count = "SELECT COUNT(*) as total FROM akses $where";
$stmt_count = $Conn->prepare($sql_count);

if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}

$stmt_count->execute();
$total = $stmt_count->get_result()->fetch_assoc()['total'];

// =========================
// DATA
// =========================
$sql = "SELECT id_akses, nama, email 
        FROM akses 
        $where 
        ORDER BY nama ASC 
        LIMIT ?, ?";

$stmt = $Conn->prepare($sql);

if (!empty($params)) {
    $params[] = $offset;
    $params[] = $limit;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $offset, $limit);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id"   => $row['id_akses'],
        "text" => $row['nama'] . " - " . $row['email']
    ];
}

// =========================
// RESPONSE
// =========================
echo json_encode([
    "results" => $data,
    "pagination" => [
        "more" => ($offset + $limit) < $total
    ]
]);