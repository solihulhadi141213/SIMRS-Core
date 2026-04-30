<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    // Parameter
    $keyword     = $_POST['keyword'] ?? '';
    $page        = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $province    = $_POST['province'] ?? '';
    $regency     = $_POST['regency'] ?? '';
    $subdistrict = $_POST['subdistrict'] ?? '';

    $limit  = 10;
    $offset = ($page - 1) * $limit;

    $keyword = trim($keyword);
    $search  = "%$keyword%";

    // Query
    $query = "
        SELECT DISTINCT village AS nama, kode_mendagri_4 AS kode
        FROM wilayah
        WHERE province = ?
        AND regency = ?
        AND subdistrict = ?
        AND village LIKE ?
        ORDER BY village ASC
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("ssssii", $province, $regency, $subdistrict, $search, $offset, $limit);
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

    // Hitung total
    $countQuery = "
        SELECT COUNT(DISTINCT village) as total
        FROM wilayah
        WHERE province = ?
        AND regency = ?
        AND subdistrict = ?
        AND village LIKE ?
    ";

    $stmtCount = $Conn->prepare($countQuery);
    $stmtCount->bind_param("ssss", $province, $regency, $subdistrict, $search);
    $stmtCount->execute();
    $total = $stmtCount->get_result()->fetch_assoc()['total'];

    // Response
    echo json_encode([
        "results" => $data,
        "pagination" => [
            "more" => ($offset + $limit) < $total
        ]
    ]);