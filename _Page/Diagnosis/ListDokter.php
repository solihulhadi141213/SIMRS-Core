<?php
    header('Content-Type: application/json; charset=utf-8');

    // ======================================================
    // CONNECTION
    // ======================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // ======================================================
    // PARAMETER
    // ======================================================
    $search = trim($_POST['search'] ?? '');
    $page   = (int) ($_POST['page'] ?? 1);

    if ($page < 1) {
        $page = 1;
    }

    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // ======================================================
    // WHERE
    // ======================================================
    $where  = "WHERE status = 1";
    $params = [];
    $types  = '';

    if (!empty($search)) {

        $where .= " AND (
            nama LIKE ? OR
            kode LIKE ? OR
            kategori LIKE ?
        )";

        $searchLike = "%$search%";

        $params[] = $searchLike;
        $params[] = $searchLike;
        $params[] = $searchLike;

        $types .= 'sss';
    }

    // ======================================================
    // COUNT TOTAL
    // ======================================================
    $sqlCount = "
        SELECT COUNT(*) AS total
        FROM dokter
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $sqlCount);

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmtCount, $types, ...$params);
    }

    mysqli_stmt_execute($stmtCount);

    $resultCount = mysqli_stmt_get_result($stmtCount);
    $rowCount    = mysqli_fetch_assoc($resultCount);

    $totalData = $rowCount['total'] ?? 0;

    // ======================================================
    // QUERY DATA
    // ======================================================
    $sql = "
        SELECT
            id_dokter,
            kode,
            nama,
            kategori
        FROM dokter
        $where
        ORDER BY nama ASC
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    // parameter tambahan limit
    $paramsData = $params;
    $typesData  = $types . 'ii';

    $paramsData[] = $offset;
    $paramsData[] = $limit;

    mysqli_stmt_bind_param($stmt, $typesData, ...$paramsData);

    mysqli_stmt_execute($stmt);

    $query = mysqli_stmt_get_result($stmt);

    // ======================================================
    // RESULTS
    // ======================================================
    $results = [];

    while ($row = mysqli_fetch_assoc($query)) {

        $label = $row['nama'];

        if (!empty($row['kode'])) {
            $label .= ' (' . $row['kode'] . ')';
        }

        if (!empty($row['kategori'])) {
            $label .= ' - ' . $row['kategori'];
        }

        $results[] = [
            'id'   => $row['id_dokter'],
            'text' => $label
        ];
    }

    // ======================================================
    // PAGINATION
    // ======================================================
    $more = false;

    if (($offset + $limit) < $totalData) {
        $more = true;
    }

    // ======================================================
    // OUTPUT JSON
    // ======================================================
    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>