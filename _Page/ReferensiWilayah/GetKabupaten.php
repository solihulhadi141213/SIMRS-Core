<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    // Parameter
    $keyword  = $_POST['keyword'] ?? '';
    $page     = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $province = $_POST['province'] ?? '';

    $limit  = 10;
    $offset = ($page - 1) * $limit;

    $keyword = trim($keyword);
    $search  = "%$keyword%";

    // Query
    $query = "
        SELECT DISTINCT regency AS nama, kode_mendagri_2 AS kode
        FROM wilayah
        WHERE province = ?
        AND regency LIKE ?
        ORDER BY regency ASC
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("ssii", $province, $search, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    // Format hasil
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id"   => $row['nama'],
            "text" => $row['nama'],
            "kode" => $row['kode']
        ];
    }

    // Hitung total (untuk pagination)
    $countQuery = "
        SELECT COUNT(DISTINCT regency) as total
        FROM wilayah
        WHERE province = ?
        AND regency LIKE ?
    ";

    $stmtCount = $Conn->prepare($countQuery);
    $stmtCount->bind_param("ss", $province, $search);
    $stmtCount->execute();
    $total = $stmtCount->get_result()->fetch_assoc()['total'];

    // Response
    echo json_encode([
        "results" => $data,
        "pagination" => [
            "more" => ($offset + $limit) < $total
        ]
    ]);