<?php
    include "../../_Config/Connection.php";

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $limit = 20;
    $offset = ($page - 1) * $limit;

    $where = !empty($search) ? " AND (akses.nama LIKE ? OR akses.akses LIKE ?)" : "";
    $searchPattern = '%' . $search . '%';

    // Prepared Statement: fetch the paginated access options.
    $stmt = mysqli_prepare($Conn, "
        SELECT 
            akses.id_akses,
            akses.nama,
            akses.akses
        FROM akses
        WHERE akses.nama != ''
        $where
        ORDER BY akses.id_akses DESC
        LIMIT ?, ?
    ");
    if (!empty($search)) {
        mysqli_stmt_bind_param($stmt, 'ssii', $searchPattern, $searchPattern, $offset, $limit);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $offset, $limit);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $results = [];

    while ($data = mysqli_fetch_assoc($result)) {

        $results[] = [
            'id' => $data['id_akses'],
            'text' => $data['nama'].' ('.$data['akses'].')'
        ];
    }
    mysqli_stmt_close($stmt);

    // Prepared Statement: count matching access options.
    $stmtCount = mysqli_prepare($Conn, "
        SELECT COUNT(*) as total
        FROM akses
        WHERE nama != ''
        $where
    ");
    if (!empty($search)) {
        mysqli_stmt_bind_param($stmtCount, 'ss', $searchPattern, $searchPattern);
    }
    mysqli_stmt_execute($stmtCount);
    $count_result = mysqli_stmt_get_result($stmtCount);
    $count_data = mysqli_fetch_assoc($count_result);
    mysqli_stmt_close($stmtCount);

    $more = ($offset + $limit) < $count_data['total'];

    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>