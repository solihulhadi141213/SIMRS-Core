<?php
    include "../../_Config/Connection.php";

    $search = $_POST['search'] ?? '';

    $query = "SELECT id_dokter, nama FROM dokter WHERE nama LIKE ?";
    $stmt = mysqli_prepare($Conn, $query);

    $param = "%$search%";
    mysqli_stmt_bind_param($stmt, "s", $param);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "id" => $row['id_dokter'],
            "text" => $row['nama']
        ];
    }

    echo json_encode($data);