<?php
    include "../../_Config/Connection.php";

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $limit = 20;
    $offset = ($page - 1) * $limit;

    $where = !empty($search) ? " AND profesi_praktisi LIKE ?" : "";
    $searchPattern = '%' . $search . '%';

    // Prepared Statement: fetch the paginated profession options.
    $stmt = mysqli_prepare($Conn, "
        SELECT DISTINCT profesi_praktisi
        FROM praktisi
        WHERE profesi_praktisi != ''
        $where
        ORDER BY id_praktisi DESC
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
            'id' => $data['profesi_praktisi'],
            'text' => $data['profesi_praktisi']
        ];
    }
    mysqli_stmt_close($stmt);

    // Cek masih ada data berikutnya
    $next_offset = $offset + $limit;

    // Prepared Statement: count matching profession options.
    $stmtCount = mysqli_prepare($Conn, "
        SELECT COUNT(DISTINCT profesi_praktisi) as total
        FROM praktisi
        WHERE profesi_praktisi != ''
        $where
    ");
    if (!empty($search)) {
        mysqli_stmt_bind_param($stmtCount, 's', $searchPattern);
    }
    mysqli_stmt_execute($stmtCount);
    $count_result = mysqli_stmt_get_result($stmtCount);
    $count_data = mysqli_fetch_assoc($count_result);
    mysqli_stmt_close($stmtCount);

    $more = $next_offset < $count_data['total'];

    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>