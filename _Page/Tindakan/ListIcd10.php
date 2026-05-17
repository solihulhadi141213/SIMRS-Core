<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    $search            = $_POST['search'] ?? '';
    $page              = (int)($_POST['page'] ?? 1);
    $reson_reference   = $_POST['reson_reference'] ?? 'ICD10';

    $limit  = 20;
    $offset = ($page - 1) * $limit;

    $searchLike = "%$search%";

    $sql = "
        SELECT *
        FROM icd
        WHERE 
            icd = ?
            AND (
                kode LIKE ?
                OR long_des LIKE ?
                OR short_des LIKE ?
            )
        ORDER BY kode ASC
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($sql);

    $stmt->bind_param(
        "ssssii",
        $reson_reference,
        $searchLike,
        $searchLike,
        $searchLike,
        $offset,
        $limit
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $results = [];

    while ($row = $result->fetch_assoc()) {

        $results[] = [
            'id'        => $row['kode'],
            'text'      => $row['kode'].' - '.$row['long_des'],
            'display'   => $row['long_des']
        ];
    }

    // COUNT
    $countSql = "
        SELECT COUNT(*) as total
        FROM icd
        WHERE 
            icd = ?
            AND (
                kode LIKE ?
                OR long_des LIKE ?
                OR short_des LIKE ?
            )
    ";

    $countStmt = $Conn->prepare($countSql);

    $countStmt->bind_param(
        "ssss",
        $reson_reference,
        $searchLike,
        $searchLike,
        $searchLike
    );

    $countStmt->execute();

    $countResult = $countStmt->get_result()->fetch_assoc();

    $more = ($offset + $limit) < $countResult['total'];

    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>