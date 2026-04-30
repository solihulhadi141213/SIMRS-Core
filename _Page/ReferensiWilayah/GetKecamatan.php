<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    // Parameter
    $keyword  = $_POST['keyword'] ?? '';
    $page     = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $province = $_POST['province'] ?? '';
    $regency  = $_POST['regency'] ?? '';

    $limit  = 10;
    $offset = ($page - 1) * $limit;

    $keyword = trim($keyword);
    $search  = "%$keyword%";

    // Query
    $query = "
        SELECT DISTINCT subdistrict AS nama, kode_mendagri_3 AS kode
        FROM wilayah
        WHERE province = ?
        AND regency = ?
        AND subdistrict LIKE ?
        ORDER BY subdistrict ASC
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("sssii", $province, $regency, $search, $offset, $limit);
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
        SELECT COUNT(DISTINCT subdistrict) as total
        FROM wilayah
        WHERE province = ?
        AND regency = ?
        AND subdistrict LIKE ?
    ";

    $stmtCount = $Conn->prepare($countQuery);
    $stmtCount->bind_param("sss", $province, $regency, $search);
    $stmtCount->execute();
    $total = $stmtCount->get_result()->fetch_assoc()['total'];

    // Response
    echo json_encode([
        "results" => $data,
        "pagination" => [
            "more" => ($offset + $limit) < $total
        ]
    ]);