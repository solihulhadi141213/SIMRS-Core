<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    $keyword = $_POST['keyword'] ?? '';
    $page    = $_POST['page'] ?? 1;

    $limit = 10;
    $offset = ($page - 1) * $limit;

    $search = "%$keyword%";

    $query = "
        SELECT DISTINCT province as nama, kode_mendagri_1 as kode
        FROM wilayah
        WHERE province LIKE ?
        ORDER BY province ASC
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("sii", $search, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id"   => $row['nama'],
            "text" => $row['nama'],
            "kode" => $row['kode']
        ];
    }

    echo json_encode([
        "results" => $data,
        "pagination" => ["more" => count($data) == $limit]
    ]);
?>