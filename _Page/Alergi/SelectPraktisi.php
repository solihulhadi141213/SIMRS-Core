<?php
    include "../../_Config/Connection.php";

    $search = $_POST['search'] ?? '';
    $page   = (int)($_POST['page'] ?? 1);

    $limit  = 20;
    $offset = ($page - 1) * $limit;

    $sql = "
        SELECT *
        FROM praktisi
        WHERE 1=1
    ";

    $params = [];
    $types  = "";

    if (!empty($search)) {

        $sql .= " AND nama_praktisi LIKE ?";

        $params[] = "%$search%";
        $types .= "s";
    }

    $sql .= " ORDER BY nama_praktisi ASC LIMIT $limit OFFSET $offset";

    $stmt = $Conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        $data[] = [
            'id'   => $row['id_praktisi'],
            'text' => $row['nama_praktisi']
        ];
    }

    echo json_encode([
        'results' => $data,
        'pagination' => [
            'more' => count($data) >= $limit
        ]
    ]);