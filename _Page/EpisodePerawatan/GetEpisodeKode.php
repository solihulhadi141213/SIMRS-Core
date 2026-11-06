<?php
    // ==========================================
    // Endpoint GetEpisodeKode.php untuk Select2 AJAX
    // ==========================================

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    header('Content-Type: application/json');

    $keyword = $_REQUEST['keyword'] ?? '';
    $page    = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $limit   = 10; // Jumlah data per halaman
    $offset  = ($page - 1) * $limit;

    $searchTerm = "%" . trim($keyword) . "%";

    // 1. Hitung total data untuk pagination Select2
    $countSql = "SELECT COUNT(*) as total FROM episode_perawatan_kode WHERE status = 1 AND (episode_name LIKE ? OR episode_display LIKE ? OR episode_code LIKE ?)";
    $stmtCount = mysqli_prepare($Conn, $countSql);
    if ($stmtCount) {
        mysqli_stmt_bind_param($stmtCount, "sss", $searchTerm, $searchTerm, $searchTerm);
        mysqli_stmt_execute($stmtCount);
        $totalResult = mysqli_stmt_get_result($stmtCount);
        $totalRow = mysqli_fetch_assoc($totalResult);
        $totalData = $totalRow['total'] ?? 0;
        mysqli_stmt_close($stmtCount);
    } else {
        $totalData = 0;
    }

    // 2. Ambil data referensi dengan limit dan offset
    $dataSql = "SELECT id_episode_perawatan_kode, episode_category, episode_name, episode_display, episode_code FROM episode_perawatan_kode WHERE status = 1 AND (episode_name LIKE ? OR episode_display LIKE ? OR episode_code LIKE ?) ORDER BY episode_name ASC LIMIT ? OFFSET ?";
    $stmtData = mysqli_prepare($Conn, $dataSql);

    if ($stmtData) {
        mysqli_stmt_bind_param($stmtData, "sssii", $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        mysqli_stmt_execute($stmtData);
        $result = mysqli_stmt_get_result($stmtData);

        $results = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = [
                'id'              => $row['id_episode_perawatan_kode'],
                'episode_name'    => $row['episode_name'],
                'episode_display' => $row['episode_display'],
                'episode_code'    => $row['episode_code'],
                'episode_category'=> $row['episode_category']
            ];
        }
        mysqli_stmt_close($stmtData);
    } else {
        $results = [];
    }

    $more = ($offset + $limit) < $totalData;

    $response = [
        'results'    => $results,
        'pagination' => [
            'more' => $more
        ]
    ];

    echo json_encode($response);
?>