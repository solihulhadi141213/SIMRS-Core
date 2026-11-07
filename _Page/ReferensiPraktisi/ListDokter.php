<?php
    include "../../_Config/Connection.php";

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $limit = 20;
    $offset = ($page - 1) * $limit;

    $where = !empty($search) ? " AND nama LIKE ?" : "";
    $searchPattern = '%' . $search . '%';

    // Prepared Statement: fetch the paginated doctor options.
    $stmt = mysqli_prepare($Conn, "
        SELECT 
            id_dokter,
            nama
        FROM dokter
        WHERE nama != ''
        $where
        ORDER BY id_dokter DESC
        LIMIT ?, ?
    ");
    if (!empty($search)) {
        mysqli_stmt_bind_param($stmt, 'sii', $searchPattern, $offset, $limit);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $offset, $limit);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $results = [];

    while ($data = mysqli_fetch_assoc($result)) {

        $results[] = [
            'id' => $data['id_dokter'],
            'text' => $data['nama']
        ];
    }
    mysqli_stmt_close($stmt);

    // Prepared Statement: count matching doctor options.
    $stmtCount = mysqli_prepare($Conn, "
        SELECT COUNT(*) as total
        FROM dokter
        WHERE nama != ''
        $where
    ");
    if (!empty($search)) {
        mysqli_stmt_bind_param($stmtCount, 's', $searchPattern);
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