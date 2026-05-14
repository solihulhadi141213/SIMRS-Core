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
    $search       = trim($_POST['search'] ?? '');
    $page         = (int) ($_POST['page'] ?? 1);
    $icd_version  = trim($_POST['icd_version'] ?? '');

    if ($page < 1) {
        $page = 1;
    }

    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // ======================================================
    // VALIDASI ICD VERSION
    // ======================================================
    $allowedIcd = ['ICD9', 'ICD10', 'ICD11'];

    if (!in_array($icd_version, $allowedIcd)) {

        echo json_encode([
            'results' => [],
            'pagination' => [
                'more' => false
            ]
        ]);

        exit;
    }

    // ======================================================
    // WHERE
    // ======================================================
    $where  = "WHERE icd = ?";
    $params = [$icd_version];
    $types  = 's';

    if (!empty($search)) {

        $where .= " AND (
            kode LIKE ? OR
            short_des LIKE ? OR
            long_des LIKE ?
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
        FROM icd
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $sqlCount);

    mysqli_stmt_bind_param($stmtCount, $types, ...$params);

    mysqli_stmt_execute($stmtCount);

    $resultCount = mysqli_stmt_get_result($stmtCount);
    $rowCount    = mysqli_fetch_assoc($resultCount);

    $totalData = $rowCount['total'] ?? 0;

    // ======================================================
    // QUERY DATA
    // ======================================================
    $sql = "
        SELECT
            id_icd,
            kode,
            short_des,
            long_des
        FROM icd
        $where
        ORDER BY kode ASC
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    // tambahan limit
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

        $description = $row['short_des'];

        if (strlen($description) > 80) {
            $description = substr($description, 0, 80) . '...';
        }

        $results[] = [
            'id'   => $row['id_icd'],
            'text' => $row['kode'] . ' - ' . $description
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