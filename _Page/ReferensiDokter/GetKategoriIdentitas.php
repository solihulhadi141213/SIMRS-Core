<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $response = [
        'results' => [],
        'pagination' => ['more' => false]
    ];

    if (empty($SessionIdAkses)) {
        echo json_encode($response);
        exit;
    }

    $keyword = trim($_POST['keyword'] ?? '');
    $page    = max(1, (int) ($_POST['page'] ?? 1));
    $limit   = 10;
    $offset  = ($page - 1) * $limit;

    $sql = "
        SELECT DISTINCT kategori_identitas
        FROM dokter
        WHERE kategori_identitas IS NOT NULL
        AND kategori_identitas != ''
        AND kategori_identitas LIKE ?
        ORDER BY kategori_identitas ASC
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        echo json_encode($response);
        exit;
    }

    $keyword_like = "%" . $keyword . "%";
    mysqli_stmt_bind_param($stmt, "sii", $keyword_like, $offset, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $kategori = trim($row['kategori_identitas'] ?? '');
        if ($kategori === '') {
            continue;
        }

        $response['results'][] = [
            'id' => $kategori,
            'text' => $kategori
        ];
    }

    mysqli_stmt_close($stmt);

    echo json_encode($response);
?>
