<?php
    include "../../_Config/Connection.php";

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $limit = 20;
    $offset = ($page - 1) * $limit;

    $search_escape = mysqli_real_escape_string($Conn, $search);

    $query = "
        SELECT DISTINCT profesi_praktisi
        FROM praktisi
        WHERE profesi_praktisi != ''
    ";

    if (!empty($search_escape)) {
        $query .= " AND profesi_praktisi LIKE '%$search_escape%'";
    }

    $query .= "
        ORDER BY id_praktisi DESC
        LIMIT $offset, $limit
    ";

    $result = mysqli_query($Conn, $query);

    $results = [];

    while ($data = mysqli_fetch_assoc($result)) {

        $results[] = [
            'id' => $data['profesi_praktisi'],
            'text' => $data['profesi_praktisi']
        ];
    }

    // Cek masih ada data berikutnya
    $next_offset = $offset + $limit;

    $count_query = "
        SELECT COUNT(DISTINCT profesi_praktisi) as total
        FROM praktisi
        WHERE profesi_praktisi != ''
    ";

    if (!empty($search_escape)) {
        $count_query .= " AND profesi_praktisi LIKE '%$search_escape%'";
    }

    $count_result = mysqli_query($Conn, $count_query);
    $count_data = mysqli_fetch_assoc($count_result);

    $more = $next_offset < $count_data['total'];

    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>