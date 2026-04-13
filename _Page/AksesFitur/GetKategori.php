<?php
    include "../../_Config/Connection.php";

    header('Content-Type: application/json');

    $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

    $sql = "SELECT DISTINCT kategori 
            FROM akses_fitur
            WHERE kategori LIKE ?
            ORDER BY kategori ASC
            LIMIT 20";

    $stmt = mysqli_prepare($Conn, $sql);

    $search = "%$keyword%";

    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['kategori'],
            'text' => $row['kategori']
        ];
    }

    echo json_encode($data);
?>