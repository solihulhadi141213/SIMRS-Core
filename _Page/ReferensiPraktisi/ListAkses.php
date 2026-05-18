<?php
    include "../../_Config/Connection.php";

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $limit = 20;
    $offset = ($page - 1) * $limit;

    $search_escape = mysqli_real_escape_string($Conn, $search);

    $query = "
        SELECT 
            akses.id_akses,
            akses.nama,
            akses.akses
        FROM akses
        WHERE akses.nama != ''
    ";

    if (!empty($search_escape)) {
        $query .= "
            AND (
                akses.nama LIKE '%$search_escape%'
                OR akses.akses LIKE '%$search_escape%'
            )
        ";
    }

    $query .= "
        ORDER BY akses.id_akses DESC
        LIMIT $offset, $limit
    ";

    $result = mysqli_query($Conn, $query);

    $results = [];

    while ($data = mysqli_fetch_assoc($result)) {

        $results[] = [
            'id' => $data['id_akses'],
            'text' => $data['nama'].' ('.$data['akses'].')'
        ];
    }

    $count_query = "
        SELECT COUNT(*) as total
        FROM akses
        WHERE nama != ''
    ";

    if (!empty($search_escape)) {
        $count_query .= "
            AND (
                nama LIKE '%$search_escape%'
                OR akses LIKE '%$search_escape%'
            )
        ";
    }

    $count_result = mysqli_query($Conn, $count_query);
    $count_data = mysqli_fetch_assoc($count_result);

    $more = ($offset + $limit) < $count_data['total'];

    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>