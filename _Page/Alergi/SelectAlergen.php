<?php
    include "../../_Config/Connection.php";

    $search = $_POST['search'] ?? '';
    $kategori = $_POST['kategori_alergen'] ?? '';
    $page = (int)($_POST['page'] ?? 1);

    $limit = 20;
    $offset = ($page - 1) * $limit;

    $sql = "
        SELECT *
        FROM alergi_alergen
        WHERE kategori_alergen = ?
    ";

    $params = [$kategori];
    $types  = "s";

    if (!empty($search)) {
        $sql .= " AND nama_alergen LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    $sql .= " ORDER BY nama_alergen ASC LIMIT $limit OFFSET $offset";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        $data[] = [
            'id'   => $row['id_alergi_alergen'],
            'text' => $row['nama_alergen']
        ];
    }

    echo json_encode([
        'results' => $data,
        'pagination' => [
            'more' => count($data) >= $limit
        ]
    ]);